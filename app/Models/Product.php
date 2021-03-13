<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "products"; 
    

    public function purchaser()
    {
        return $this->belongsToMany(Purchchaser::class,'product_purchases','product_id','purchase_id')
        ->withPivot('purchase_timestamp');
    }
}

