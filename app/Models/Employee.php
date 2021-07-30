<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Model
{
    use HasFactory, HasApiTokens, HasRoles;

    protected $fillable = [
        'name',
        'cpf',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];
}
