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

        try {
            if ($request->hasFile($key)) {
                $model->addMediaFromRequest($key)
                    ->withCustomProperties(['classification' => $classification])
                    ->toMediaCollection('application-documents');
                error_log("Uploaded file for key: $key"); // Log successful upload
            } else {
                error_log("File not found for key: $key"); // Log if file not found
            }
        } catch (\Exception $e) {
            error_log("Error uploading file for key $key: " . $e->getMessage()); // Log any exceptions
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
        foreach ($data->files as $key => $file) {
            if (preg_match('/^attachment_\d+$/', $key)) {
                $classification = $key;
                self::handlePossibleFileUpload(
                    $data,
                    $model,
                    $key,
                    $classification
                );
            } else {
                error_log("Unexpected file key: $key"); // Log unexpected keys
            }
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
