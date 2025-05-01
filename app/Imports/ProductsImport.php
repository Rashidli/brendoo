<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\ProductTranslation;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToCollection, WithHeadingRow
{

    function generateUniqueSlug($title): string
    {
        return Str::slug($title);
    }

    public function collection(Collection $rows)
    {

        try {

            foreach ($rows as $row) {

                $product = Product::create([
                    'price' => $row['price'],
                    'discount' => $row['discount'],
                    'discounted_price' => $row['discounted_price'],
                    'stock' => $row['stock'],
                    'code' => $row['code'],
                    'user_id' => auth()->user()->id,
                ]);

                $product->translations()->createMany([
                    [
                        'locale' => 'en',
                        'title' => $row['en_title'],
                        'slug' => $this->generateUniqueSlug($row['en_title']),
                    ],
                    [
                        'locale' => 'ru',
                        'title' => $row['ru_title'],
                        'slug' => $this->generateUniqueSlug($row['ru_title']),
                    ]
                ]);
            }
        }catch (\Exception $exception){
            return response()->json($exception->getMessage());
        }
    }
}

