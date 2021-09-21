<?php

namespace App\Http\Models;

use App\Http\Models\User;
use App\Http\Services\Model;

class Role extends Model
{

    protected $table = 'roles';


    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function users() {
        return $this->hasMany(User::class);
    }
}
