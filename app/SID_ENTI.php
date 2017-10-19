<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SID_ENTI extends Model
{
    Protected $table = "SID_ENTI";

    public $timestamps = false;

	protected $fillable = ['COD_ENTI', 'NOM_ENTI', 'NIT_ENTI', 'DIR_ENTI', 'IND_ESTA'];
}
