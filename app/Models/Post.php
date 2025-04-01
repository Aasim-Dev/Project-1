<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = 'posts';

    protected $fillable = [
        'website_url',
        'host_url',
        'da',
        'sample_post',
        'country',
        'normal',
        'other',
        'user_id'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
