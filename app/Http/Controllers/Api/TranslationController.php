<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class TranslationController extends Controller
{
    public function index()
    {
        $locale =  request()->header('Accept-Language')
            ?? 'ru'; // Default fallback dili

        $translations = Translation::with(['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }])->get()->mapWithKeys(function ($item) use ($locale) {
            return [$item->key => $item->translate($locale)?->title];
        });

        // Açarları nested array-ə çevir
        $grouped = [];

        foreach ($translations as $key => $value) {
            Arr::set($grouped, $key, $value);
        }

        return response()->json($grouped);
    }
}
