<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class YamahaSetting extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'yamaha_settings';

    protected $fillable = ['id', 'access_token', 'expires_at', 'expires_in', 'created_at', 'updated_at', 'deleted_at'];

}
