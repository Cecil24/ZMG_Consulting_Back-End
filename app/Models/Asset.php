<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\File;

class Asset extends Model implements HasMedia
{
    use HasFactory, Notifiable, InteractsWithMedia;

    /**
     * @var string[]
     */
    protected $fillable = [
        'type',
        'asset_id',
        'location',
        'employee',
        'brand_name',
        'serial_number',
        'status',
        'imei_number',
        'start_date',
        'end_date',
        'model',
        'ram_size',
        'furniture_type',
        'description',
    ];

    /**
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('application-documents')
            ->acceptsFile(function (File $file) {
                $allowedMimeTypes = [
                    'application/pdf',
                    'image/jpeg',
                    'image/png',
                    'text/plain',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/vnd.ms-excel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    // Add other MIME types as needed
                ];

                return in_array($file->mimeType, $allowedMimeTypes);
            })->useDisk('media');
    }
}
