<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemModel extends Model
{
    protected $table = 'item';
    protected $fillable = [
        'judul',
        'bahan',
        'cara_pembuatan',
        'picture',
        'status',
        'user_id'
    ];
}
