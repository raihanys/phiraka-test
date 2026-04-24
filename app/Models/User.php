<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'tbl_user';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'Username',
        'Password',
    ];

    public function getAuthPassword()
    {
        return $this->Password;
    }
}
