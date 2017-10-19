<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SID_TRD_DETA extends Model
{
    protected $table = "SID_TRD_DETA";

    public $timestamps = false;
    
	protected $fillable = ['COD_ENTI', 
							'COD_TRD', 
							'NUM_REGI',  
							'NOM_DESC',
							'COD_USUA',
							'FEC_ACTU',
							'HOR_ACTU'
							];
}
