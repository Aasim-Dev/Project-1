<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
    use HasFactory;
    protected $fillable = [
        'advertiser_id',
        'website_id',
        'status'
    ];

    public function users(){
        return $this->belongsTo(User::class);
    }
    public function post(){
        return $this->belongsTo(Post::class, 'website_id', 'id');
    }
    public function orders(){
        return $this->hasMany(Order::class);
    }

}
