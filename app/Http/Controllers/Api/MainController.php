<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MainResource;
use App\Models\Main;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $main = Main::query()->first();
        return response()->json(new MainResource($main));
    }
}
