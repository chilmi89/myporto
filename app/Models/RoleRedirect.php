<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleRedirect extends Model
{
    use HasFactory;


    protected $fillable = ['role_name', 'route_name'];
}
