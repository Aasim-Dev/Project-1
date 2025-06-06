<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'advertiser_id',
        'website_id',
        'host_url',
        'da',
        'tat',
        'semrush',
        'guest_post_price',
        'linkinsertion_price',
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
        'client_token',
    ];

    protected $dates = ['deleted_at'];

    public function users(){
        return $this->belongsTo(User::class);
    }
    public function website(){
        return $this->belongsTo(Website::class, 'website_id', 'id');
    }
    public function orders(){
        return $this->hasMany(Order::class);
    }

}
