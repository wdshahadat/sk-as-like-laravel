<?php

namespace App\Http\Models;

use App\Http\Models\Role;
use App\Http\Services\Model;

class User extends Model
{
    protected $table = 'users';

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
