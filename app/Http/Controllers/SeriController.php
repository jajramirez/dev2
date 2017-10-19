<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
use App\SID_SERI;
use App\SID_ENTI;
use App\SID_CCD;

class SeriController extends Controller
{
    
    public function __construct()
    {

        $this->middleware('auth');
    }



     //
    public function index(Request $request)
    {

    	$seris = DB::table('SID_SERI')
            ->select('COD_ENTI', 'COD_SERI', 'NOM_SERI', 'IND_ESTA','COD_USUA', 'FEC_ACTU', 'HOR_ACTU')
            ->where('NOM_SERI', 'like', "%$request->cod_seri%")
            ->get();


        return view('seris.index')
       		->with('seris', $seris);
    }
    

    public function create()
    {   
        $enti = SID_ENTI::all();
        return view('seris.create')
            ->with('entis', $enti);;
    }   

    public function store(Request $request)
    {

       
       $enti = DB::table('SID_SERI')
            ->where('COD_SERI', '=', $request->COD_SERI)
            ->get();

    
       if(count($enti) == 0)
       {
            $respuesta=null;
            DB::beginTransaction();
            date_default_timezone_set('America/Bogota');
            $COD_USUA = Auth::user()->COD_USUA;
            $FEC_ACTU = strftime( "%Y-%m-%d", time() );
            $HOR_ACTU = strftime( "%H:%M:%S", time() );
            try {
                $seri = SID_SERI::create([
                        'COD_ENTI'=> '01',
                        'COD_SERI'=> $request->COD_SERI,
                        'NOM_SERI'=> $request->NOM_SERI,
                        'IND_ESTA'=> $request->IND_ESTA,
                        'COD_USUA'=> $COD_USUA,
                        'FEC_ACTU'=> $FEC_ACTU,
                        'HOR_ACTU'=> $HOR_ACTU ]);

                DB::commit();
               
            } catch(\Illuminate\Database\QueryException $ex){ 
                DB::rollback();
                $respuesta = $ex->getMessage(); 
            }
            
            if($respuesta !=null)
            {
                Flash::warning($respuesta);
                return redirect()->route('seris.index');
            }
            else
            {
                Flash::success("Se insertó correctamente el registro");
                return redirect()->route('seris.index');
            }

        }
        else
        {
            Flash::warning("El codigo " .$request->COD_SERI. " ya existe");
            return redirect()->route('seris.index');
        }

    }

    public function destroy($id)
    {
        $data = explode('_', $id);
        $ccd = SID_CCD::where('COD_SERI', '=', $data[1])->get();
	if(count($ccd)>0)
	{
	Flash::success("No se puede elimiar un registro en uso CCD");
        return redirect()->route('seris.index');

	}
	else{

        $seri = SID_SERI::where('COD_SERI', '=', $data[1])
            ->where('COD_ENTI', '=', $data[0])
            ->delete();
        Flash::success("Se ha eliminado correctamente");
        return redirect()->route('seris.index');
	}
    }

    public function edit($id)
    {   
        $data = explode('_', $id);
        $seriF = SID_SERI::where('COD_ENTI',  $data[0] );
        $seri = DB::table('SID_SERI')
            ->select('COD_ENTI', 'COD_SERI', 'NOM_SERI', 'IND_ESTA','COD_USUA', 'FEC_ACTU', 'HOR_ACTU')
            ->where('COD_SERI', '=', $data[1])
            ->where('COD_ENTI', '=', $data[0])
            ->get();
        $res = $seri->toArray();
        return view('seris.edit')
            ->with('seri', $res[0])
            ->with('serif', $seriF);
    }


    public function actualizar(Request $request)
    {

        date_default_timezone_set('America/Bogota');
        $COD_USUA = Auth::user()->COD_USUA;
        $FEC_ACTU = strftime( "%Y-%m-%d", time() );
        $HOR_ACTU = strftime( "%H:%M:%S", time() );
        $seri = SID_SERI::where('COD_SERI', '=', $request->COD_SERI)
            ->where('COD_ENTI', '=', $request->COD_ENTI)
            ->update(['NOM_SERI' => $request->NOM_SERI, 'IND_ESTA'=> $request->IND_ESTA,'COD_USUA'=> $COD_USUA,
            'FEC_ACTU'=> $FEC_ACTU, 'HOR_ACTU'=> $HOR_ACTU]);

        Flash::warning("Se actualizó correctamente el registro");
        return redirect()->route('seris.index');
    }

    public function update(Request $request, $id)
    {

    }   

    public function buscarccd(Request $request)
    {

        echo '<option value="">Seleccione una subserie</option>'; 
        $ccd = SID_CCD::where('COD_SERI', '=', $request->cod_seri)->
                where('COD_SUBS', '<>', null)->get();
        if($ccd != null)
        {
            foreach ($ccd as $c) {
                if($request->cod_subs == $c->COD_SUBS )
                {
                    if($request->cod_subs != null){
                        echo '<option value="'.$c->COD_SUBS.'" selected>'.$c->NOM_SUBS.'</option>';
                    }
                }
                else
                {
                    echo '<option value="'.$c->COD_SUBS.'">'.$c->NOM_SUBS.'</option>';
                }
            }
        }

    }   
}
