<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    protected $table = 'orders';
    
    protected $fillable = [
        'user_id',
        'paket_id',
        'price_id',
        'status_pesanan',
        'berat',
        'total_harga',
        'snap_token',
        'status',
        'tanggal_pesanan',
    
    ];
}
