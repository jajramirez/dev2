<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class V_SID_TRD_DETA extends Model
{
    protected $table = "V_SID_TRD2";

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
							'NOM_DESC'
							];
}
