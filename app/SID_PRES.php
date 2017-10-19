<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SID_PRES  extends Model
{
    protected $table = "SID_PRES";

    public $timestamps = false;


	protected $fillable = ['SID_PRES', 'FEC_ENTR','SID_OFCI', 'NOM_SOLI', 'DES_SOPO', 'COD_USUA', 'FEC_ACTU', 'HOR_ACTU'];
}


