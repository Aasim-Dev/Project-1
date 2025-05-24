<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrlChecker extends Model
{
    use HasFactory;
    protected $table = 'url_checker';
    protected $fillable = [
        'user_id',
        'url',
        'checked',
    ];
}
