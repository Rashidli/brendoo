<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\ProductsImport;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\ThirdCategory;
use App\Services\ImageUploadService;
use App\Services\PriceCalculatorService;
use App\Services\ProductService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function __construct(
        protected ImageUploadService $imageUploadService,
        protected ProductService $productService,
        protected PriceCalculatorService $calculatorService
    ) {
        $this->middleware('permission:list-products|create-products|edit-products|delete-products', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-products', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-products', ['only' => ['edit']]);
        $this->middleware('permission:delete-products', ['only' => ['destroy']]);
    }

    public function generateUniqueSlug($title, $itemId = null)
    {
        $slug = Str::slug($title);

        if ($itemId) {
            $count = Product::query()->whereNot('id', $itemId)->whereTranslation('title', $title)->count();
        } else {
            $count = Product::query()->whereTranslation('title', $title)->count();
        }

        if ($count > 0) {
            $slug .= '-' . $count;
        }

        return $slug;
    }

    public function index(Request $request)
    {
        $limit    = $request->input('limit', '15');
        $products = $this->productService->filterProducts($request)->orderByDesc('id')->paginate($limit)->withQueryString();

        $categories    = Category::all();
        $subcategories = SubCategory::all();
        $brands        = Brand::all();

        return view('admin.products.index', compact(
            'products',
            'categories',
            'subcategories',
            'brands'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories    = Category::all();
        $subCategories = SubCategory::all();
        $brands        = Brand::all();

        return view('admin.products.create', compact('categories', 'subCategories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id'       => 'required|exists:categories,id',
            'sub_category_id'   => 'required|exists:sub_categories,id',
            'third_category_id' => 'nullable|exists:third_categories,id',
            'en_title'          => 'required',
            'ru_title'          => 'required',
            'en_description'    => 'nullable',
            'ru_description'    => 'nullable',
            'image'             => 'required|image',
            'size_image'        => 'nullable',
            'price'             => 'nullable|numeric',
            'cost_price'        => 'nullable|numeric',
            'stock'             => 'nullable|integer',
            'brand_id'          => 'nullable',
            'en_short_title'    => 'nullable',
            'ru_short_title'    => 'nullable',
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('image')) {
                $filename = $this->imageUploadService->upload($request->file('image', true));
            }

            if ($request->hasFile('size_image')) {
                $filename_size_image = $this->imageUploadService->upload($request->file('size_image'), true);
            }

            $product = Product::create([
                'category_id'       => $request->category_id,
                'brand_id'          => $request->brand_id,
                'sub_category_id'   => $request->sub_category_id,
                'third_category_id' => $request->third_category_id,
                'user_id'           => auth()->id(),
                'image'             => $filename            ?? null,
                'size_image'        => $filename_size_image ?? null,
                'video'             => $request->video,
                'unit'              => $request->unit,
                'cost_price'        => $request->cost_price,
                'price'             => $request->price,
                'discount'          => $request->discount,
                'discounted_price'  => $request->discounted_price,
                'is_new'            => $request->has('is_new'),
                'is_active'         => $request->has('is_active'),
                'is_stock'          => $request->has('is_stock'),
                'is_return'         => $request->has('is_return'),
                'is_season'         => $request->has('is_season'),
                'is_popular'        => $request->has('is_popular'),
                'code'              => $request->code,
                'stock'             => $request->stock,
                'status'            => $request->status,
            ]);

            $product->translations()->createMany([
                [
                    'locale'           => 'en',
                    'title'            => $request->en_title,
                    'short_title'      => $request->en_short_title,
                    'description'      => $request->en_description,
                    'img_alt'          => $request->en_img_alt,
                    'img_title'        => $request->en_img_title,
                    'slug'             => $this->generateUniqueSlug($request->en_title),
                    'meta_title'       => $request->en_meta_title,
                    'meta_description' => $request->en_meta_description,
                    'meta_keywords'    => $request->en_meta_keywords,
                ],
                [
                    'locale'           => 'ru',
                    'title'            => $request->ru_title,
                    'short_title'      => $request->ru_short_title,
                    'description'      => $request->ru_description,
                    'img_alt'          => $request->ru_img_alt,
                    'img_title'        => $request->ru_img_title,
                    'slug'             => $this->generateUniqueSlug($request->ru_title),
                    'meta_title'       => $request->ru_meta_title,
                    'meta_description' => $request->ru_meta_description,
                    'meta_keywords'    => $request->ru_meta_keywords,
                ],
            ]);

            if ($request->hasFile('slider_images')) {
                foreach ($request->file('slider_images') as $file) {
                    $filename = $this->imageUploadService->upload($file, true);
                    $product->sliders()->create([
                        'image' => $filename,
                    ]);
                }
            }

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            return $exception->getMessage();
        }

        return redirect()->route('products.edit', $product->id)->with('message', 'Product added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): void {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {

        $brands          = Brand::all();
        $categories      = Category::query()->with('filters.options')->get();
        $subCategories   = SubCategory::all();
        $thirdCategories = ThirdCategory::all();
        $selectedOptions = [];
        $defaultOptions  = [];
        $stockOptions    = [];

        foreach ($product->filters as $filter) {
            $selectedOptions[$filter->id] = $filter->pivot->pluck('option_id')->toArray();
            $defaultOptions[$filter->id]  = $filter->pivot->where('is_default', true)->first()->option_id ?? null;
            if ( ! empty($filter->pivot) && is_iterable($filter->pivot)) {
                foreach ($filter->pivot as $pivot) {
                    if ( ! empty($pivot) && is_object($pivot)) {
                        $stockOptions[$filter->id][$pivot->option_id] = $pivot->is_stock ?? false;
                    }
                }
            }
        }

        return view('admin.products.edit', compact(
            'product',
            'categories',
            'subCategories',
            'brands',
            'selectedOptions',
            'defaultOptions',
            'thirdCategories',
            'stockOptions'
        ));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id'       => 'required|exists:categories,id',
            'sub_category_id'   => 'nullable|exists:sub_categories,id',
            'third_category_id' => 'nullable|exists:third_categories,id',
            'en_title'          => 'required',
            'ru_title'          => 'required',
            'en_description'    => 'nullable',
            'ru_description'    => 'nullable',
            'price'             => 'nullable|numeric',
            'cost_price'        => 'nullable|numeric',
            'stock'             => 'nullable|integer',
            'brand_id'          => 'nullable',
        ]);

        DB::beginTransaction();

        try {
            if ($request->hasFile('image')) {
                $product->image = $this->imageUploadService->upload($request->file('image'), true);
            }
            if ($request->hasFile('size_image')) {
                $product->size_image = $this->imageUploadService->upload($request->file('size_image'), true);
            }
            $wasInactive = !$product->is_active;
            $isActiveNow = $request->has('is_active');
            $product->update([
                'category_id'       => $request->category_id,
                'brand_id'          => $request->brand_id,
                'sub_category_id'   => $request->sub_category_id,
                'third_category_id' => $request->third_category_id,
                'user_id'           => auth()->id(),
                'video'             => $request->video,
                'unit'              => $request->unit,
                'cost_price'        => $request->cost_price,
                'price'             => $request->price,
                'tr_price'          => $request->tr_price,
                'discount'          => $request->discount,
                'discounted_price'  => $request->discounted_price,
                'is_new'            => $request->has('is_new'),
                'is_active'         => $request->has('is_active'),
                'is_stock'          => $request->has('is_stock'),
                'is_accept'         => $request->has('is_accept'),
                'is_return'         => $request->has('is_return'),
                'is_season'         => $request->has('is_season'),
                'is_popular'        => $request->has('is_popular'),
                'code'              => $request->code,
                'stock'             => $request->stock,
                'status'            => $request->status,
            ]);
            if ($wasInactive && $isActiveNow && is_null($product->activation_date)) {
                $product->activation_date = now();
                $product->save();
            }
            $product->translations()->updateOrCreate(['locale' => 'en'], [
                'title'            => $request->en_title,
                'short_title'      => $request->en_short_title,
                'description'      => $request->en_description,
                'img_alt'          => $request->en_img_alt,
                'img_title'        => $request->en_img_title,
                'slug'             => $this->generateUniqueSlug($request->en_title),
                'meta_title'       => $request->en_meta_title,
                'meta_description' => $request->en_meta_description,
                'meta_keywords'    => $request->en_meta_keywords,
            ]);

            $product->translations()->updateOrCreate(['locale' => 'ru'], [
                'title'            => $request->ru_title,
                'short_title'      => $request->ru_short_title,
                'description'      => $request->ru_description,
                'img_alt'          => $request->ru_img_alt,
                'img_title'        => $request->ru_img_title,
                'slug'             => $this->generateUniqueSlug($request->ru_title),
                'meta_title'       => $request->ru_meta_title,
                'meta_description' => $request->ru_meta_description,
                'meta_keywords'    => $request->ru_meta_keywords,
            ]);

            if ($request->hasFile('slider_images')) {
                foreach ($request->file('slider_images') as $file) {
                    $filename = $this->imageUploadService->upload($file, true);
                    $product->sliders()->create([
                        'image' => $filename,
                    ]);
                }
            }

            $data = $request->all();

            if (isset($data['filter_id'])) {
                DB::table('product_filter_options')->where('product_id', $product->id)->delete();

                foreach ($data['filter_id'] as $filterId) {
                    $selectedOptions = $data['selected_options'][$filterId] ?? [];

                    foreach ($selectedOptions as $optionId) {
                        $isDefault = isset($data['default_option'][$filterId]) && $data['default_option'][$filterId] == $optionId;
                        $isStock   = isset($data['is_stock'][$filterId][$optionId]);

                        $product->filters()->attach($filterId, [
                            'option_id'  => $optionId,
                            'is_default' => $isDefault,
                            'is_stock'   => $isStock,
                        ]);
                    }
                }
            }

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            return $exception->getMessage();
        }

        return redirect()->back()->with('message', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('message', 'Product deleted successfully');
    }

    public function uploadExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        Excel::import(new ProductsImport(), $request->file('file'));

        return redirect()->route('products.index')->with('success', 'Products imported successfully');
    }

    public function import(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'xml_file' => 'required',
            ]);

            $file       = $request->file('xml_file');
            $xmlContent = file_get_contents($file);

            $xml  = simplexml_load_string($xmlContent, 'SimpleXMLElement', LIBXML_NOCDATA);
            $json = json_decode(json_encode($xml), true);

            $results = $json['Product'];

            foreach ($results as $product) {
                if (Product::query()->where('listing_id', $product['id'])->exists()) {
                    continue;
                }

                $images = $product['images'] ?? [];

                $new_product = Product::create([
                    'user_id'           => auth()->id(),
                    'listing_id'        => $product['id'],
                    'price'             => $this->calculatorService::calculate($product['price']['sellingPrice'] ?? 0),
                    'tr_price'          => $product['price']['sellingPrice']    ?? 0,
                    'discounted_price'  => $product['price']['discountedPrice'] ?? 0,
                    'image'             => $product['images']['image'][0],
                    'category_id'       => $request->category_id,
                    'sub_category_id'   => $request->sub_category_id,
                    'third_category_id' => $request->third_category_id,
                    'brand_id'          => $request->brand_id,
                    'is_active'         => false,
                    'en'                => [
                        'title'     => $product['name'],
                        'img_alt'   => $product['imageAlt'] ?? '',
                        'img_title' => $product['imageAlt'] ?? '',
                        'slug'      => $this->generateUniqueSlug($product['name']) . '-en',
                    ],
                    'ru' => [
                        'locale'    => 'ru',
                        'title'     => $product['name'],
                        'img_alt'   => $product['imageAlt'] ?? '',
                        'img_title' => $product['imageAlt'] ?? '',
                        'slug'      => $this->generateUniqueSlug($product['name']) . '-ru',
                    ],
                ]);

                if (is_array($images) && isset($images['image'])) {
                    $imageList = $images['image'];

                    if (is_string($imageList)) {
                        $imageList = [$imageList];
                    }

                    foreach ($imageList as $img) {
                        $new_product->sliders()->create([
                            'image' => $img,
                        ]);
                    }
                }

                DB::commit();
            }
        } catch (Exception $exception) {
            DB::rollBack();

            return $exception->getMessage();
        }

        return redirect()->back()->with('success', 'Məhsullar uğurla yükləndi.');
    }

    public function increasePrices(Request $request)
    {
        $request->validate([
            'brand_id' => 'nullable|integer|exists:brands,id',
            'percent' => 'required|numeric|min:0',
        ]);

        $brandId = $request->input('brand_id');
        $percent = $request->input('percent');
        $multiplier = 1 + ($percent / 100);

        $query = DB::table('products');

        if ($brandId) {
            $query->where('brand_id', $brandId);
        }

        $query->update([
            'price' => DB::raw("ROUND(price * $multiplier)")
        ]);

        return back()->with('success', 'Qiymətlər uğurla artırıldı.');
    }
}
