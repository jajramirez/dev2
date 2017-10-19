<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SID_FUID extends Model
{
    protected $table = "SIS_FUID";

    public $timestamps = false;
    
	protected $fillable = ['COD_ENTI', 
							'COD_TRD', 
							'NUM_REGI', 
							'NOM_ASUN', 
							'NUM_DOCU', 
							'FEC_INIC', 
							'FEC_FINA', 
							'NUM_CARP', 
							'NUM_TOMO',
							'NUM_CAJA',
							'NUM_INTE',
							'NUM_FOLI',
							'BAN_DIGI',
							'FRE_CONS',
							'NOM_DIGI',
							'NOM_ARCH',
							'FEC_CREA',
							'NUM_PAGI',
							'TAM_ARCH',
							'SOF_CAPT',
							'VER_ARCH',
							'RES_ARCH',
							'IDI_ARCH',
							'ENT_ARCH',
							'OBS_GEN1',
							'OBS_GEN2',
							'OBS_GEN3',
							'OBS_GEN4',
							'COD_CCD',
							'COD_ORGA',
							'CON_BODE',
							'GEN_SOPO',
							'NUM_ORDE',
						];


	public function scopeSearch($query, $NUM_REGI)
	{
		return $query->where('NUM_REGI', 'LIKE', "%$NUM_REGI%");
	}

}
