<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SID_CCD_META extends Model
{
    protected $table = "SID_CCD_META";

    public $timestamps = false;

	protected $fillable = ['COD_ENTI', 'NUM_REGI', 'MET1'
							, 'MET2'
							, 'MET3'
							, 'MET4'
							, 'MET5'
							, 'MET6'
							, 'MET7'
							, 'MET8'
							, 'MET9'
							, 'MET10'
							, 'MET11'];
}
