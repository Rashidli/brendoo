<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Word;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TranslateController extends Controller
{
    public function translates(): JsonResponse
    {

        $locale = app()->getLocale();
        $words = Word::all();

        $translations = [];
        foreach ($words as $word) {
            $key = $word->key;
            $translations[$key] = $word->translate($locale)->title;
        }

        return response()->json($translations);

    }
}
