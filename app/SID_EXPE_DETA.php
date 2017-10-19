<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SID_EXPE_DETA extends Model
{
    protected $table = "SID_EXPE_DETA";

    public $timestamps = false;
    
	protected $fillable = ['COD_EXPE', 
							'NUM_REGI', 
							'COD_ORGA',  
							'COD_TIPO', 
							'NOM_PROG', 
							'NOM_MODA', 
							'TIP_NIVEL',
							'FEC_INGR',
							'ANH_FINA',
							'OBS_GENE',
							'COD_SUBS'
							];
}
