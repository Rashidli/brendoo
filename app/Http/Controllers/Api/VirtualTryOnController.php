<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\KlingAIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Mockery\Exception;

class VirtualTryOnController extends Controller
{
    protected $klingAIService;

    public function __construct(KlingAIService $klingAIService)
    {
        $this->klingAIService = $klingAIService;
    }

    public function submitTryOn(Request $request)
    {
        $validated = $request->validate([
            'human_image' => 'required|string',
            'cloth_image' => 'required|string',
            'model_name' => 'sometimes|string',
            'callback_url' => 'sometimes|url'
        ]);

        $response = $this->klingAIService->submitVirtualTryOn($validated);

        return response()->json($response);
    }

    public function checkStatus($task_id)
    {
        $response = $this->klingAIService->checkTaskStatus($task_id);

        return response()->json($response);
    }
}
