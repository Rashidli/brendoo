<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImageUploadService
{

    public function upload($file, bool $isProduct = false): string
    {
        if (in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/gif', 'image/webp'])) {
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file);
            $image = $image->toWebp(60);
            $filename = Str::uuid() . '.webp';
            Storage::put('public/' . $filename, (string) $image);
        } else {
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            Storage::put('public/' . $filename, file_get_contents($file));
        }

        if ($isProduct) {
            return config('app.url') . '/storage/' . $filename;
        }

        return  $filename;
    }

}
