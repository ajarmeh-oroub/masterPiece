<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pharmacy extends Authenticatable

{
    use HasFactory;
    use HasApiTokens;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'password',
        'owner_name',
        'owner_phone',
        'owner_email',
        'description',
        'active',
        'pharm_phone',
        'pharm_email',
        'facebook',
        'instagram',
        'twitter',
        'latitude',
        'longitude',
        'delivers',
        'logo' 
    ];
    

  
    public function products()
    {
        return $this->belongsToMany(Product::class, 'pharmacy_product', 'pharmacy_id', 'product_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function discounts(){
        return $this->hasMany(Discount::class);
    }

}
