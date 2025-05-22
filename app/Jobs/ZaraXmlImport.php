<?php

namespace App\Jobs;

use App\Models\Product;
use App\Services\PriceCalculatorService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ZaraXmlImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $filePath;

    public $category_id;

    public $sub_category_id;

    public $third_category_id;

    public $brand_id;

    public $user_id;

    public function __construct(
        $filePath,
        $category_id,
        $sub_category_id,
        $third_category_id,
        $brand_id,
        $user_id,
    ) {
        $this->filePath          = $filePath;
        $this->category_id       = $category_id;
        $this->sub_category_id   = $sub_category_id;
        $this->third_category_id = $third_category_id;
        $this->brand_id          = $brand_id;
        $this->user_id           = $user_id;
    }

    public function generateUniqueSlug($title, $itemId = null): string
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

    public function handle(): void
    {
        $fullPath = storage_path('app/' . $this->filePath);

        if ( ! file_exists($fullPath)) {
            Log::error('XML faylı tapılmadı: ' . $fullPath);

            return;
        }

        $calculatorService = new PriceCalculatorService();
        $xmlContent        = file_get_contents($fullPath);
        $xml               = simplexml_load_string($xmlContent, 'SimpleXMLElement', LIBXML_NOCDATA);
        $json              = json_decode(json_encode($xml), true);
        $products          = $json['urun'] ?? [];

        foreach ($products as $product) {
            if (Product::query()->where('url', $product['url'])->exists()) {
                continue;
            }

            $images = $product['images'] ?? [];

            $new_product = Product::create([
                'user_id'    => $this->user_id,
                'listing_id' => $product['id'],
                'url'        => $product['url'],
                'price'      => $calculatorService::calculate(
                    $calculatorService::parsePrice($product['fiyat'] ?? 0)
                ),
                'tr_price'          => $calculatorService::parsePrice($product['fiyat'] ?? 0),
                'image'             => $product['ana_gorsel_url'],
                'category_id'       => $this->category_id,
                'sub_category_id'   => $this->sub_category_id,
                'third_category_id' => $this->third_category_id,
                'brand_id'          => $this->brand_id,
                'is_active'         => false,
                'en'                => [
                    'title'     => $product['baslik'],
                    'img_alt'   => $product['baslik'] ?? '',
                    'img_title' => $product['baslik'] ?? '',
                    'slug'      => $this->generateUniqueSlug($product['baslik']) . '-en',
                ],
                'ru' => [
                    'title'     => $product['baslik'],
                    'img_alt'   => $product['baslik'] ?? '',
                    'img_title' => $product['baslik'] ?? '',
                    'slug'      => $this->generateUniqueSlug($product['baslik']) . '-ru',
                ],
            ]);

            $images = $product['gorseller'] ?? [];

            if (is_array($images)) {
                $imageList = array_values($images);

                $imageList = array_filter($imageList, fn ($url) => is_string($url) && ! str_contains($url, 'transparent-background'));

                foreach ($imageList as $img) {
                    $new_product->sliders()->create(['image' => $img]);
                }
            }
        }

        // İsteğe bağlı: faylı sil
        unlink($fullPath);
    }
}
