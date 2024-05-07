<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\File;

class ClientDocumentRequests extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * @var string[]
     */
    protected $fillable = [
        'client_id',
        'instructions',
        'is_submitted',
        'is_url_opened'
    ];

    /**
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('application-documents')
            ->acceptsFile(function (File $file) {
                return $file->mimeType == 'application/pdf';
            })->useDisk('media');
    }
}
