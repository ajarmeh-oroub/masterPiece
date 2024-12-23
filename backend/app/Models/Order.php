<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
      'user_id',
        'store_id',
        'status',
        'total'
    ];

    PUBLIC function user(){
        return $this->belongsTo(User::class);
    }
    public function orderItems(){
        return $this->belongsTo(Order::class);

    }
 public function pharmacy(){
        return $this->belongsTo(Pharmacy::class);
 }
}
