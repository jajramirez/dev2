<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SID_ORGA extends Model
{
    protected $table = "SID_ORGA";

    public $timestamps = false;


	protected $fillable = ['COD_ENTI', 
							'COD_ORGA', 
							'NOM_ORGA', 
							'COD_NIVE', 
							'IND_ESTA', 
							'COD_PADR', 
							'COD_USUA', 
							'FEC_ACTU', 
							'HOR_ACTU'
							];
}
