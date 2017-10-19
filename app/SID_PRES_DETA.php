<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SID_PRES_DETA extends Model
{
    protected $table = "SID_PRES_DETA";

    public $timestamps = false;


	protected $fillable = ['SID_COD', 'SID_PRES', 'COD_TRD',
				'SID_CAJA', 'SID_CARP', 'SID_CONT', 'SID_TIPO', 'SID_OBSE', 'FEC_SOLI',
				 'FEC_ENTR', 'FEC_DEVO', 'SID_VIA'
							];
}


