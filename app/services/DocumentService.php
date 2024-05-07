<?php

namespace App\services;

use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DocumentService
{
    /**
     * @param Request $request
     * @return BinaryFileResponse
     */
    public function downloadDocument($request)
    {
        return (new AttachmentService)->downloadDocument($request);
    }
}
