<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SID_SERI extends Model
{
    protected $table = "SID_SERI";

    public $timestamps = false;
    
	protected $fillable = ['COD_ENTI', 
							'COD_SERI', 
							'NOM_SERI',  
							'IND_ESTA', 
							'COD_USUA', 
							'FEC_ACTU', 
							'HOR_ACTU'
							];
}
