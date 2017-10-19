<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
use App\SID_SERI;
use App\SID_CCD;
use App\SID_ENTI;
use App\SID_FUID;

class CcdController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	
    	 	$ccd = DB::table('SID_CCD')
            ->select('COD_ENTI', 'NUM_REGI', 'COD_SERI', 'COD_SUBS', 'NOM_SUBS', 'IND_ESTA', 'COD_USUA', 'FEC_ACTU', 'HOR_ACTU')
            ->where('COD_SUBS', 'like', "%$request->COD_SUBS%")
            ->get();

           return view('ccd.index')
       		->with('ccds', $ccd);
    }

    public function create()
    {
    	$seri = SID_SERI::all();
    	$enti = SID_ENTI::all();
           return view('ccd.create')
       		->with('seris', $seri)
       		->with('entis', $enti);
    }

    public function store(Request $request)
    {   
        $respuesta=null;
        DB::beginTransaction();
        date_default_timezone_set('America/Bogota');
        $COD_USUA = \Auth::user()->COD_USUA;
        $FEC_ACTU = strftime( "%Y-%m-%d", time() );
        $HOR_ACTU = strftime( "%H:%M:%S", time() );
        $max = $ccd = DB::table('SID_CCD')
            ->select(DB::raw('max(NUM_REGI) as max'))
            ->get();
        
        $serir = $max[0]->max + 1;

        $ccd = DB::table('SID_CCD')
            ->where('COD_SERI', '=', $request->COD_SERI)
            ->where('COD_SUBS', '=', $request->COD_SUBS)
            ->get();


        if(count($ccd)==0)
        {

            try {
                $seri = SID_CCD::create([
                        'COD_ENTI'=> '01',
                        'NUM_REGI'=> $serir,
                        'COD_SERI'=> $request->COD_SERI,
                        'COD_SUBS'=> $request->COD_SUBS,
                        'IND_ESTA'=> $request->IND_ESTA,
                        'COD_USUA'=> $COD_USUA,
                        'FEC_ACTU'=> $FEC_ACTU,
                        'HOR_ACTU'=> $HOR_ACTU,
                        'NOM_SUBS'=> $request->NOM_SUBS
                        ]);

                DB::commit();
               
            } catch(\Illuminate\Database\QueryException $ex){ 
                DB::rollback();
                $respuesta = $ex->getMessage(); 
            }
            
            if($respuesta !=null)
            {
                Flash::warning($respuesta);
                return redirect()->route('ccd.create');
            }
            else
            {
                Flash::success("Se insertó correctamente el registro");
                return redirect()->route('ccd.index');
            }
        }
        else
        {
            Flash::warning("Ya existe un registro para la serie y la subserie ingresada.");
            return redirect()->route('ccd.create');
        }

    }


    public function destroy($id)
    {
        $data = explode('_', $id);
        $serid1 = SID_CCD::where('NUM_REGI', '=', $data[1])
            ->where('COD_ENTI', '=', $data[0])
            ->get();
        foreach ($serid1 as $serid) {
           $ccd = $serid->COD_SERI.'.'.$serid->COD_SUBS;
        }

        $fuid = SID_FUID::where('COD_CCD', '=', $ccd)->get();
        
        if(count($fuid)>0)
        {
            Flash::success("No se puede eliminar un registro en uso FUID");
            return redirect()->route('ccd.index');
        }
        else
        {
              $seri = SID_CCD::where('NUM_REGI', '=', $data[1])
            ->where('COD_ENTI', '=', $data[0])
            ->delete();
    
            Flash::success("Se ha eliminado correctamente");
        return redirect()->route('ccd.index');
        }

    }

    public function edit($id)
    {   
        $data = explode('_', $id);
        $ccdF = SID_CCD::where('COD_ENTI',  $data[0] );
        $ccd = DB::table('SID_CCD')
            ->select('COD_ENTI', 'NUM_REGI', 'COD_SERI', 'COD_SUBS', 'NOM_SUBS', 'IND_ESTA', 'COD_USUA', 'FEC_ACTU', 'HOR_ACTU')
            ->where('NUM_REGI', '=', $data[1])
            ->where('COD_ENTI', '=', $data[0])
            ->get();
        $seri = SID_SERI::all();
        return view('ccd.edit')
            ->with('ccd', $ccd[0])
            ->with('ccdf', $ccdF)
            ->with('seris', $seri);
    }


    public function actualizar(Request $request)
    {
        date_default_timezone_set('America/Bogota');
        $COD_USUA = Auth::user()->COD_USUA;
        $FEC_ACTU = strftime( "%Y-%m-%d", time() );
        $HOR_ACTU = strftime( "%H:%M:%S", time() );

        $ccd = DB::table('SID_CCD')
            ->where('COD_SERI', '=', $request->COD_SERI)
            ->where('COD_SUBS', '=', $request->COD_SUBS)
            ->where('NUM_REGI', '<>', $request->NUM_REGI)
            ->get();

        if(count($ccd) == 0)
        {
           
            $seri = SID_CCD::where('NUM_REGI', '=', $request->NUM_REGI)
                ->where('COD_ENTI', '=', $request->COD_ENTI)
                ->update(['COD_SERI' => $request->COD_SERI,'COD_SUBS'=>$request->COD_SUBS, 'NOM_SUBS'=> $request->NOM_SUBS, 'IND_ESTA'=> $request->IND_ESTA,'COD_USUA'=> $COD_USUA,
                'FEC_ACTU'=> $FEC_ACTU, 'HOR_ACTU'=> $HOR_ACTU]);

            Flash::warning("Se actualizó correctamente el registro");
            return redirect()->route('ccd.index');
        }
        else
        {
            
            Flash::warning("No se puede actualizar el registro, la serie ". $request->COD_SERI . " y la subserie ".$request->COD_SUBS. " existe para otro registro   ") ;
            return redirect()->route('ccd.index');
        }
    }

    public function update(Request $request, $id)
    {

    }      



}
