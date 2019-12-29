<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleDetails extends Model
{
    protected $fillable = [
        'product_id','sale_id','price','quantity','subtotal',
    ];
    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function purchase()
    {
        return $this->belongsTo(Sale::class);
    }
}
