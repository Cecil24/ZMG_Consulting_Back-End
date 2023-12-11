<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\File;

class Note extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'note',
        'created_by',
        'type',
        'object_id',
    ];

    /**
     * @return BelongsTo
     */
    public function By(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by',
            'id'
        );
    }

    /**
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('claim-motivation')
            ->acceptsFile(function (File $file) {
                return in_array($file->mimeType, [
                    'application/pdf',
                    'image/jpeg',
                    'image/jpg',
                    'image/png'
                ]);
            })->useDisk('media');
    }
}
