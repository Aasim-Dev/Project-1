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
        'host_url',
        'da',
        'tat',
        'semrush',
        'price',
        'status',
        'type',
        'language',
        'attachment',
        'special_instruction',
        'existing_post_url',
        'title_suggestion',
        'keywords',
        'anchor_text',
        'country',
        'word_count',
        'category',
        'reference_link',
        'target_url',
        'special_note',
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
