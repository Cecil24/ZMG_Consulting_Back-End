<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class AuditTrail extends Model
{
    use HasFactory;

    protected $fillable = [
        'object_id',
        'description',
        'name',
        'ip_address',
    ];
}
