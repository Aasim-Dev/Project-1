<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'transaction_id',
        'transaction_reference',
        'order_type',
        'description',
        'payment_status',
        'payment_type',
        'credit_debit',
        'amount',
        'total',
        'paypal_fee',
        'tax',
        'order_id',
    ];

    protected $dates = ['deletes_at'];
}
