<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SID_USUA extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;
    
    protected $table = "SID_USUA";
   
    protected $fillable = [
        'COD_USUA', 'CON_USUA', 'NOM_USUA','IND_ESTA', 'COD_ROLE'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'CON_USUA',
    ];

    public function administrador()
    {
        return $this->COD_ROLE === 1;
    }
    public function operario()
    {
        return $this->COD_ROLE === 2;
    }
    public function consulta()
    {
        return $this->COD_ROLE === 3;
    }


}
