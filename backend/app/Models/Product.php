<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'subcategory_id',
        'visible',
        'main_image',
        'is_package',
        'warnings',
        'disclaimer',
        'other_ingredients',
        'created_at',
        'updated_at',
        'created_by',
        'created_by_id', // Add this
        'created_by_type', // Add this
        'nutritional_information',
        'brand_id',
        'skin_type',
        'active_ingredients',
        'usage_instructions',
        'bottle_volume',
        'bottle_material',
        'bottle_type',
        'cap_type',
    ];
    
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function pharmacies()
    {
        return $this->belongsToMany(Pharmacy::class, 'pharmacy_product', 'product_id', 'pharmacy_id');
    }
    public function category()
    {
        return $this->belongsTo(Sub_category::class, 'subcategory_id', 'id');
    }

 // In Product model
public function images()
{
    return $this->hasMany(Product_image::class);
}


    public function order_item(){
        return $this->hasMany(Order_item::class);
    }
     public function reviews(){
        return $this->hasMany(Review::class);
     }
public function discounts()
{
    return $this->hasMany(Discount::class);
}

public function brand(){
    return $this->belongsTo(Brand::class);
}
}
