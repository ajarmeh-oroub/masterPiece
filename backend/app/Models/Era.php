<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Era extends Model
{
    use HasFactory;
    protected $fillable = [
        'era_name',
        'start_year',
        'end_year'
    ];
    public function product(){
        return $this->hasMany(Product::class);
    }
}
