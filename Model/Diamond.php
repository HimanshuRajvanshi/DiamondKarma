<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Diamond extends Model
{
    protected $table = 'webg_diamond';
    public $timestamps = false;

    protected $fillable = [
        'id','shop_id','diamond_retail_price','diamond_sale_price','diamond_title','diamond_description',
        'diamond_sku','is_active','is_available','stock_value','last_updated_dt','created_dt','created_ip','shape',
    ];


    public function shopDetails()
    {
        return $this->hasOne('App\Model\Shop','id','shop_id');
    }
}
