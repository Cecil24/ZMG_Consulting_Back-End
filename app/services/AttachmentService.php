<?php

namespace App\services;

use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AttachmentService
{
    /**
     * @param $request
     * @param $model
     * @param string $key
     * @param string $classification
     * @return void
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public static function handlePossibleFileUpload($request, $model, string $key, string $classification): void {

        if ($request->hasFile($key)) {
            $model->addMediaFromRequest($key)
                ->withCustomProperties(['classification'=> $classification])
                ->toMediaCollection('application-documents');
        }
    }

    /**
     * @param $data
     * @param $model
     * @return void
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public static function processAttachedFiles($data , $model): void
    {
        for( $i=1 ; $i<=count($data->files) ; $i++){
            self::handlePossibleFileUpload(
                $data,
                $model,
                'attachment_' . $i,
                'Attachment_' . $i
            );
        }
    }

    /**
     * @param Request $request
     * @return BinaryFileResponse
     */
    public function downloadDocument(Request $request)
    {
        $media = Media::find($request->id);
        return response()->download($media->getPath(), $media->file_name);
    }

    /**
     * @param Request $request
     * @return BinaryFileResponse
     */
    public function downloadDocumentUUID(Request $request)
    {
        $media = Media::where('uuid',$request->uuid)->first();
        return response()->download($media->getPath(), $media->file_name);
    }
}
