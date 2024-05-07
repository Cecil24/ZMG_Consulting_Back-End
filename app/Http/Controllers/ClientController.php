<?php

namespace App\Http\Controllers;

use App\Exceptions\ClientDocumentException;
use App\Http\Requests\ClientDocumentRequest;
use App\Http\Requests\ClientRequest;
use App\Http\Requests\DocumentsRequest;
use App\Http\Requests\GetClientRequest;
use App\services\ClientService;
use Exception;
use Illuminate\Http\Request;
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

    /**
     * @param DocumentsRequest $request
     * @param ClientService $service
     * @return Response
     */
    public function requestDocuments(DocumentsRequest $request, ClientService $service): Response
    {
        return $this->json($service->requestDocuments($request)->toArray());
    }

    /**
     * @param Request $request
     * @param ClientService $service
     * @return Response
     */
    public function getClientByToken(Request $request, ClientService $service): Response
    {
        try{
            return $this->json($service->getClientByToken($request)->toArray());
        }catch(ClientDocumentException $exception){
            return $this->jsonReportSubmitted($exception->getMessage());
        }catch(Exception $exception){
            return $this->jsonServerError($exception->getMessage());
        }
    }

    /**
     * @param ClientDocumentRequest $request
     * @param ClientService $service
     * @return Response
     */
    public function clientDocuments(ClientDocumentRequest $request, ClientService $service): Response
    {
        $service->submitDocuments($request);
        return $this->jsonSuccess();
    }

    /**
     * @param GetClientRequest $request
     * @param ClientService $service
     * @return Response
     */
    public function getClientDocuments(GetClientRequest $request,ClientService $service): Response
    {
        return $this->json($service->getClientDocuments($request->validated())->toArray());
    }
}
