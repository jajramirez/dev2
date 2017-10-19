<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
use App\SID_SERI;
use App\SID_ENTI;
use App\SID_ORGA;
use App\SID_FUID;

class DependenciaController extends Controller
{
    
    public function __construct()
    {

        $this->middleware('auth');
    }

     //
    public function index(Request $request)
    {

    	  $deps = DB::table('SID_ORGA')
            ->select('COD_ENTI', 'COD_ORGA', 'NOM_ORGA', 'COD_NIVE', 'IND_ESTA', 'COD_PADR', 'COD_USUA', 'FEC_ACTU', 'HOR_ACTU',  'PATH')
            ->where('NOM_ORGA', 'like', "%$request->NOM_ORGA%")
            ->get();

        return view('dependencias.index')
       		->with('deps', $deps);
    }
    

    public function create()
    {   
        $enti = SID_ENTI::all();
        $orgs = SID_ORGA::all();
        return view('dependencias.create')
            ->with('entis', $enti)
            ->with('orgs', $orgs);
    }   

    public function store(Request $request)
    {
        $respuesta=null;
        DB::beginTransaction();
        date_default_timezone_set('America/Bogota');
        $COD_USUA = Auth::user()->COD_USUA;
        $FEC_ACTU = strftime( "%Y-%m-%d", time() );
        $HOR_ACTU = strftime( "%H:%M:%S", time() );

        $deps = DB::table('SID_ORGA')
            ->where('COD_ENTI', '=', "01")
            ->where('COD_ORGA', '=', $request->COD_ORGA)
            ->get();

        if(count($deps) == 0)
        {
            try {
                $seri = SID_ORGA::create([

                        'COD_ENTI'=> '01' ,
                        'COD_ORGA'=> $request->COD_ORGA,
                        'NOM_ORGA'=> $request->NOM_ORGA,
                        'IND_ESTA'=> $request->IND_ESTA,
    		            'PATH'=> $request->PATH,
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
                return redirect()->route('dependencias.index');
            }
            else
            {
                Flash::success("Se insertó correctamente el registro");
                return redirect()->route('dependencias.index');
            }

        }
        else
        {
            Flash::warning("El codigo ". $request->COD_ORGA . " ya existe en la base de datos.");
            return redirect()->route('dependencias.index');
        }

    }

    public function destroy($id)
    {
        $data = explode('_', $id);
	$sid_seri = SID_FUID::where('COD_ORGA', '=', $data[1])->get();
	if(count($sid_seri)>0)
        {
	Flash::success("No se puede eliminar un registro en uso por lista FUID");
        return redirect()->route('dependencias.index');
	}
	else{
        $seri = SID_ORGA::where('COD_ORGA', '=', $data[1])
            ->where('COD_ENTI', '=', $data[0])
            ->delete();
        Flash::success("Se ha eliminado correctamente");
        return redirect()->route('dependencias.index');
	 }
    }

    public function edit($id)
    {   
        $data = explode('_', $id);
        $enti = SID_ENTI::all();
        $orgs = SID_ORGA::all();            
        $seri = DB::table('SID_ORGA')
            ->select('COD_ENTI', 'COD_ORGA', 'NOM_ORGA', 'COD_NIVE', 'IND_ESTA', 'COD_PADR',  'PATH')
            ->where('COD_ORGA', '=', $data[1])
            ->where('COD_ENTI', '=', $data[0])
            ->get();
        $res = $seri->toArray();
        return view('dependencias.edit')
            ->with('seri', $res[0])
            ->with('entis', $enti)
            ->with('orgs', $orgs);
    }


    public function actualizar(Request $request)
    {
        date_default_timezone_set('America/Bogota');
        $COD_USUA = Auth::user()->COD_USUA;
        $FEC_ACTU = strftime( "%Y-%m-%d", time() );
        $HOR_ACTU = strftime( "%H:%M:%S", time() );
        $seri = SID_ORGA::where('COD_ORGA', '=', $request->COD_ORGA)
            ->where('COD_ENTI', '=', $request->COD_ENTI)
            ->update(['NOM_ORGA' => $request->NOM_ORGA, 'IND_ESTA'=> $request->IND_ESTA,'COD_USUA'=> $COD_USUA,
            'FEC_ACTU'=> $FEC_ACTU, 'HOR_ACTU'=> $HOR_ACTU,  'PATH'=> $request->PATH]);

        Flash::warning("Se actualizó correctamente el registro");
        return redirect()->route('dependencias.index');
    }

    public function update(Request $request, $id)
    {

    }      
}
