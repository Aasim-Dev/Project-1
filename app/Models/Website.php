<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Website extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'websites';

    protected $fillable = [
        'website_url',
        'host_url',
        'da',
        'sample_post',
        'ahref_traffic',
        'tat',
        'country',
        'normal',
        'normal',
        'guest_post_price',
        'linkinsertion_price',
        'user_id',
    ];

    protected $dates = ['deleted_at'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function orders(){
        return $this->hasMany(Order::class);
    }
    public function cart(){
        return $this->hasMany(Cart::class);
    }
    
}
