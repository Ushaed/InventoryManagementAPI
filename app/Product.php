<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name','slug','category_id','brand_id','status','description','buy_price','sell_price'
        ];
    protected $hidden = [];
    protected $dates = ['deleted_at'];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class,'brand_id');
    }

    public function stock()
    {
        return $this->hasOne(CurrentStock::class,'product_id');
    }
}
