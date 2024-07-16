<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_id',
        'status',
    ];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function orderItems()
    {
        return $this->hasMany(Orderitem::class);
    }
    public function items()
    {
        return $this->belongsToMany(Item::class, 'orderitems')->withPivot('quantity');
    }
}
