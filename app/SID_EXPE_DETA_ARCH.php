<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SID_EXPE_DETA_ARCH extends Model
{
    protected $table = "SID_EXPE_DETA_ARCH";

    public $timestamps = false;
    
	protected $fillable = ['COD_EXPE', 
							'NUM_REGI', 
							'NUM_ARCH',  
							'NOM_ARCH', 
							'FEC_ARCH', 
							'NUM_PAGI', 
							'NUM_TAMA',
							'NOM_SOFT',
							'NOM_VERS',
							'NOM_RESO',
							'NOM_IDIO'
							];
}
