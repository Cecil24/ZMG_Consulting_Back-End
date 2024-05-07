<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentRequest;
use App\services\AttachmentService;
use App\services\DocumentService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DocumentController extends Controller
{
    public function getMediaDocument(Request $request, AttachmentService $service): BinaryFileResponse
    {
        return $service->downloadDocument($request);
    }
}
