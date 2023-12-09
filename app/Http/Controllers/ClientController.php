<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Http\Requests\GetClientRequest;
use App\services\ClientService;
use Illuminate\Http\Response;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class ClientController extends Controller
{
    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function captureClient(ClientRequest $request, ClientService $service): Response
    {
        return $this->json($service->captureClient($request)->toArray());
    }

    /**
     * @param ClientService $service
     * @return Response
     */
    public function getClients(ClientService $service): Response
    {
        return $this->json($service->getClients()->toArray());
    }

    /**
     * @param GetClientRequest $request
     * @param ClientService $service
     * @return Response
     */
    public function getClient(GetClientRequest $request,ClientService $service): Response
    {
        return $this->json($service->getClient($request->validated())->toArray());
    }

    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function updateClient(ClientRequest $request, ClientService $service): Response
    {
        return $this->json($service->updateClient($request)->toArray());
    }
}
