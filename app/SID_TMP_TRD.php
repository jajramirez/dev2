<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SID_TMP_TRD extends Model
{
    protected $table = "SID_TMP_TRD";

    public $timestamps = false;
    
	protected $fillable = ['id', 
							'TRD_TMP1',
							'TRD_TMP2', 
							'TRD_TMP3', 
							'TRD_TMP4', 
							'TRD_TMP5', 
							'TRD_TMP6', 
							'TRD_TMP7', 
							'TRD_TMP8', 
							'TRD_TMP9', 
							'TRD_TMP10', 
							'COD_USUA'
							];
}
