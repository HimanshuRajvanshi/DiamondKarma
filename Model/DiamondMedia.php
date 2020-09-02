<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DiamondMedia extends Model
{
    protected $table = 'webg_diamond_media';
    public $timestamps = false;

    protected $fillable = [
        'id','media_type','media_path','diamond_id',
    ];
}
