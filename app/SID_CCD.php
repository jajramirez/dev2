<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SID_CCD extends Model
{
    protected $table = "SID_CCD";

    public $timestamps = false;

	protected $fillable = ['COD_ENTI', 'NUM_REGI', 'COD_SERI', 'COD_SUBS', 'NOM_SUBS', 'IND_ESTA', 'COD_USUA', 'FEC_ACTU', 'HOR_ACTU'];
}
