<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'invoice_code','supplier_id','gross_total','discount','net_total','remarks',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class,'supplier_id');
    }

    public function purchase_details()
    {
        return $this->hasMany(PurchaseDetails::class);
    }

}
