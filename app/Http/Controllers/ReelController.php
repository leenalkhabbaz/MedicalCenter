<?php

namespace App\Http\Controllers;

use App\Http\Requests\Assistant\ReelRequest;
use App\Http\Resources\ApiResponse;
use App\Http\Resources\ReelResponse;
use App\Services\ReelService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ReelController extends Controller
{
    private ReelService $reelService;

    public function __construct(ReelService $reelService)
    {
        $this->reelService = $reelService;
    }

    public function uploadReel(ReelRequest $request)
    {
        try {
            if ($request->hasFile('reel')) {
                \Log::info("Reel file name: " . $request->file('reel')->getClientOriginalName());
            } else {
                \Log::error("File 'reel' was not found in the request.");
            }

            $data = $request->all();

            $reel = $this->reelService->uploadReel($data);

            return ApiResponse::success(true, 200, 'Reel uploaded successfully');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500,500);
        }
    }
}
