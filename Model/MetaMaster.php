<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class MetaMaster extends Model
{
    protected $table = 'webg_meta_master';
    public $timestamps = false;

    protected $fillable = [
        'id','name','is_searchable','has_defined_value','created_dt','input_type','tooltip','icon',
    ];




}
