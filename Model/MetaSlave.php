<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MetaSlave extends Model
{
    protected $table = 'webg_meta_slave';
    public $timestamps = false;

    protected $fillable = [
        'id','master_id','value','is_active',
    ];
}
