<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'invoice_code','customer_name','customer_phone','gross_total','discount','net_total','remarks',
    ];

    public function sales_details()
    {
        return $this->hasMany(SaleDetails::class);
    }
}
