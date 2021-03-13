<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchchaser extends Model
{
    use HasFactory;
 

    public function products()
    {
        return $this->belongsToMany(Product::class,'product_purchases','purchase_id','product_id')
        ->withPivot('purchase_timestamp');;
    }
}
