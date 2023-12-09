<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssetRequest;
use App\Http\Requests\ClientRequest;
use App\Http\Requests\GetAssetRequest;
use App\Http\Requests\GetClientRequest;
use App\services\AssetService;
use App\services\ClientService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class AssetController extends Controller
{
    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function captureAsset(AssetRequest $request, AssetService $service): Response
    {
        return $this->json($service->captureAsset($request)->toArray());
    }

    /**
     * @param AssetService $service
     * @return Response
     */
    public function getAssets(AssetService $service): Response
    {
        return $this->json($service->getAssets()->toArray());
    }

    /**
     * @param GetAssetRequest $request
     * @param AssetService $service
     * @return Response
     */
    public function getAsset(GetAssetRequest $request,AssetService $service): Response
    {
        return $this->json($service->getAsset($request->validated())->toArray());
    }

    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function updateAsset(AssetRequest $request, AssetService $service): Response
    {
        return $this->json($service->updateAsset($request)->toArray());
    }
}
