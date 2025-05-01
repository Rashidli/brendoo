<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ImageResource;
use App\Http\Resources\RegisterImageResource;
use App\Models\Image;
use App\Models\RegisterImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogoController extends Controller
{

    public function logo() : JsonResponse
    {
        try {
            $logo = Image::query()->where('type','logo')->first();
            return response()->json(new ImageResource($logo));
        }catch (\Exception $exception){
            return response()->json($exception->getMessage());
        }
    }

    public function favicon() : JsonResponse
    {
        $favicon = Image::query()->where('type','favicon')->first();
        return response()->json(new ImageResource($favicon));
    }

    public function registerImage() : JsonResponse
    {
        $register_image = RegisterImage::query()->first();
        return response()->json(new RegisterImageResource($register_image));
    }

}
