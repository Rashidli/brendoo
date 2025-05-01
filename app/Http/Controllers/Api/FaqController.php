<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FaqCategoryResource;
use App\Http\Resources\FaqResource;
use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function faqCategory() : JsonResponse
    {
        $faq_categories = FaqCategory::all();
        return response()->json(FaqCategoryResource::collection($faq_categories));
    }

    public function faqs(Request $request) : JsonResponse
    {

        try {
            $query = Faq::query()->active();

            if($request->has('faq_category_id')){
                $query->where('faq_category_id', $request->faq_category_id);
            }

            $faqs = $query->get();

            return response()->json(FaqResource::collection($faqs));
        }catch (\Exception $exception){
            return response()->json($exception->getMessage());
        }

    }
}
