<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\File;

class Client extends Model implements HasMedia
{
    use HasFactory, Notifiable, InteractsWithMedia;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'client_id',
        'email',
        'employee',
        'contact_phone_number',
        'services_rendered',
        'agent_name',
        'contact_person',
        'year_end_date',
        'start_date',
        'end_date',
        'frequency',
        'status',
        'type',
        'nature',
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
