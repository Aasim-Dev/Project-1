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
        'normal_gp',
        'normal_li',
        'other_gp',
        'other_li',
        'user_id',
        'category_id'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
