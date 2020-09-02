<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $table = 'webg_shop';
    public $timestamps = false;

    protected $fillable = [
        'id','shop_name','shop_url','shop_description','shop_affiliate_id','shop_rating','created_dt','lastupdate_dt','shop_image','shop_url_type',
    ];
}
