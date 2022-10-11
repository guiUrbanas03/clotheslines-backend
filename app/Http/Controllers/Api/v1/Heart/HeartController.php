<?php

namespace App\Http\Controllers\Api\v1\Heart;

use App\Http\Controllers\Controller;
use App\Services\Heart\HeartService;
use Illuminate\Http\Request;

class HeartController extends Controller
{
    protected $heartService;

    public function __construct(HeartService $heartService)
    {
        $this->heartService = $heartService;
    }

    public function store(Request $request)
    {
        $heart = $this->heartService->heart();

        return $this->jsonResponse([
            'message' => 'Heart created successfully',
            'heart' => $heart->resource
        ]);
    }

    public function destroy(Request $request)
    {
        $heart = $this->heartService->unheart();

        return $this->jsonResponse([
            'message' => 'Playlist heart deleted successfully',
            'heart' => $heart->resource
        ]);
    }

    public function getProfileHeartedIds(Request $request)
    {
        $heartedIds = $this->heartService->getProfileHeartedIds();

        return $this->jsonResponse([
            'message' => 'Hearts found successfully',
            'hearts' => $heartedIds
        ]);
    }

    public function getHeartsCount(Request $request)
    {
        $heartsCount = $this->heartService->getHeartsCount();

        return $this->jsonResponse([
            'message' => "Hearts counted successfully",
            'hearts' => $heartsCount,
        ]);
    }
}
