<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;
    protected $fillable = [
        'store_id',
        'name',
        'capacity',
        'qr_code_image',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
