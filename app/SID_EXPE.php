<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SID_EXPE extends Model
{
    protected $table = "SID_EXPE";

    public $timestamps = false;
    
	protected $fillable = ['COD_EXPE', 
							'NUM_DOCU', 
							'TIP_DOCU',  
							'PRI_NOMB', 
							'SEG_NOMB', 
							'PRI_APEL', 
							'SEG_APEL'
							];
}
