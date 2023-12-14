<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\MediaCollections\File;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'employee_number',
        'phone_number',
        'gender',
        'race',
        'role',
        'marital_status',
        'next_kin',
        'kin_number',
        'start_date',
        'employee_status',
        'id_number',
        'date_of_birth',
        'tax_number',
        'disability',
        'disabilityYes',
        'bank_details',
        'benefit_details',
        'address_details',
        'office',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
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
