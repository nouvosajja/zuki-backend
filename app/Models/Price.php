<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class price extends Model
{
    use HasFactory;


   
    public function scopeFilter($query, array $filters)
    {

        if (isset($filters['paket_id'])) {
            $query->where('paket_id', $filters['paket_id']);
        }
    }
}


