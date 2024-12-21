<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'address',
        'phone',
        'email',
        'password',
        'owner_name',
        'owner_phone',
        'owner_email',
        'description',
        'active'
    ];

    public function users(){
        return $this->belongsTo(User::class, 'owner_id');
    }
    public function products(){
        return $this->hasMany(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function discounts(){
        return $this->hasMany(Discount::class);
    }
}
