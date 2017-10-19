<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SID_TRD extends Model
{
    protected $table = "SID_TRD";

    public $timestamps = false;
    
	protected $fillable = ['COD_ENTI', 
							'COD_TRD', 
							'ARC_GEST',  
							'ARC_CENT', 
							'BAN_CT', 
							'BAN_E', 
							'BAN_M',
							'BAN_S',
							'TEX_OBSE',
							'IND_ESTA',
							'COD_USUA',
							'FEC_ACTU',
							'HOR_ACTU',
							'COD_ORGA',
							'COD_CCD'
							];
}
