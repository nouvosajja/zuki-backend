<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subject',
        'message',
        'type',
        'redirect_id',
        'tanggal_inbox'
    ];

    public function user()
    {
        return $this->morphTo();
    }
}
