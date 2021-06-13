<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Person extends Model
{
    protected $table = 'people';
    protected $fillable = [
        'organization_id',
        'name',
        'phone',
        'email',
        'avatar'
    ];

    public function getAvatarAttribute()
    {
        return $this->avatar
            ? Storage::disk(config('filesystems.default'))->url($this->avatar)
            : $this->defaultAvatarPhotoUrl();
    }

    public function defaultAvatarPhotoUrl()
    {
        return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&color=7F9CF5&background=EBF4FF';
    }

}
