<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DiamondParameter extends Model
{
    protected $table = 'webg_diamond_parameter';
    public $timestamps = false;

    protected $fillable = [
        'id','parameter_id','parameter_name','parameter_value','diamond_id','master_id',
    ];


    public function typeDetails()
    {
        return $this->hasOne('App\Model\MetaMaster','id','master_id');
    }
}
