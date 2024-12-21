<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'new_price',
        'start_date',
        'expire_date',
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function stores(){
        return $this->belongsTo(Store::class);
    }
}
