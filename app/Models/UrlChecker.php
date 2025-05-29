<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UrlChecker extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'url_checker';
    protected $fillable = [
        'user_id',
        'url',
        'checked',
        'batch_id',
    ];

    protected $dates = ['deleted_at'];
}
