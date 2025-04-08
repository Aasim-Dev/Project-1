<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable =[
        
        'advertiser_id',
        'publisher_id',
        'website_id',
        'purpose',
        'status',
        'price',

    ];

    public function users(){
        return $this->belongsTo(User::class);
    }
    public function posts(){
        return $this->belongsTo(Post::class);
    }
    public function cart(){
        return $this->belongsTo(Cart::class);
    }
}
