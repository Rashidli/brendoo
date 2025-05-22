<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RuleResource;
use App\Models\Delivery;
use App\Models\Refund;
use App\Models\Rule;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{

    public function pages()
    {

        $pages = Rule::active()->get();

        $result = [];

        foreach ($pages as $page) {
            $key = 'page_' . $page->id;
            $result[$key] = new RuleResource($page);
        }

        return response()->json($result);
    }

}
