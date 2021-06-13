<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $table = 'organizations';
    protected $fillable = [
        'name',
        'phone',
        'email',
        'website',
        'org_logo'
    ];

    public function PersonInCharge()
    {
        return $this->hasMany(Person::class);
    }

    public function AccountManager()
    {
        return $this->hasOne(User::class);
    }
}
