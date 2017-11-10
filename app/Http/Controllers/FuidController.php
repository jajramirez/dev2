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
use App\SID_CCD;
use MBarryvdh\DomPDF\Facade;

class FuidController extends Controller
{
    
    public function __construct()
    {

        $this->middleware('auth');
    }

     //
    public function index(Request $request)
    {
        $url=$request->documento;
        return view('fuid.documento')
            ->with('url', $url);
    }
    

    public function create(Request $request)
    {   

        $orgas = SID_ORGA::all();
        $ccds = SID_CCD::all();
        $seris = SID_SERI::all();

        return view('fuid.create')
            ->with('busqueda', $request->busqueda)
            ->with('orgas', $orgas)
            ->with('ccds', $ccds)
            ->with('seris', $seris);
    }   

    public function store(Request $request)
    {
        $respuesta=null;
        DB::beginTransaction();
        date_default_timezone_set('America/Bogota');
        $COD_USUA = Auth::user()->COD_USUA;
        $FEC_ACTU = strftime( "%Y-%m-%d", time() );
        $HOR_ACTU = strftime( "%H:%M:%S", time() );
        $fechai = null;
        $fechaf = null;
        if($request->FEC_INIC != null)
        {
            $fechai = substr($request->FEC_INIC,6,4) .'-'.substr($request->FEC_INIC,0,2) .'-'. substr($request->FEC_INIC,3,2) ;
        }
        if($request->FEC_FINA != null)
        {
            $fechaf = substr($request->FEC_FINA,6,4) .'-'.substr($request->FEC_FINA,0,2) .'-'. substr($request->FEC_FINA,3,2) ;
        }
        $name = null;
        if($request->file('NOM_ARCH'))
        {
            $file = $request->file('NOM_ARCH');
            $name = 'expdiente' . time() . "." . $file->getClientOriginalExtension();
            $nombre = $file->getClientOriginalName();
            $path = public_path().'/documentos/';
            $file->move($path, $name);
        }
        
        $codorga = null;
        $codccd = null;
        if($request->COD_SUBS != null)
        {
            $codorga = $request->COD_ORGA .'.'. $request->COD_SERI . '.'.$request->COD_SUBS;
            $codccd =  $request->COD_SERI . '.'.$request->COD_SUBS;
        }
        else
        {
            $codorga =  $request->COD_ORGA .'.'. $request->COD_SERI ;
            $codccd = $request->COD_SERI ;
        }

        try {

            $max = DB::table('SIS_FUID')
                ->select(DB::raw('max(NUM_REGI) as max'))
                ->get();


                
            $num_regi = $max[0]->max + 1;


            $seri = SID_FUID::create([

                    'COD_ENTI'=> '01' ,
                    'NUM_REGI'=> $num_regi,
                    'COD_TRD' => $codorga,
                    'COD_ORGA'=> $request->COD_ORGA,
                    'COD_CCD' => $codccd,
                    'FEC_INIC' => $fechai,
                    'FEC_FINA' => $fechaf,
                    'NUM_CAJA' => $request->NUM_CAJA,
                    'NUM_CARP' => $request->NUM_CARP,
                    'NUM_TOMO' => $request->NUM_TOMO,
                    'NUM_INTE' => $request->NUM_INTE,
                    'NUM_FOLI' => $request->NUM_FOLI,
                    'OBS_GEN1' => $request->OBS_GEN1,
                    'FRE_CONS' => $request->FRE_CONS,
                    'NOM_ARCH' => $name,
                    'NOM_ASUN' => $request->NOM_ASUN,
                    'CON_BODE' => $request->CON_BODE,
                    'GEN_SOPO' => $request->GEN_SOPO,
                    'NUM_ORDE' => $num_regi]);

            DB::commit();
           
        } catch(\Illuminate\Database\QueryException $ex){ 
            DB::rollback();
            $respuesta = $ex->getMessage(); 
        }
        
        if($respuesta !=null)
        {
            Flash::warning($respuesta);
            return redirect()->route('home.fuid');
        }
        else
        {
            Flash::success("Se insertó correctamente el registro");
            return redirect()->route('home.fuid');
        }

    }

    public function destroy($id)
    {
        $data = explode('_', $id);  
        $seri = SID_FUID::where('COD_ENTI', '=', $data[0])
            ->where('COD_TRD', '=', $data[1])
            ->where('NUM_REGI', '=', $data[2])
            ->delete();
        Flash::success("Se ha eliminado correctamente");
        return redirect()->route('home.fuid');
	 
    }

    public function edit($id)
    {   
        $data = explode('_', $id);          
        $seri = DB::table('SIS_FUID')
            ->where('COD_ENTI', '=', $data[0])
            ->where('COD_TRD', '=', $data[1])
            ->where('NUM_REGI', '=', $data[2])
            ->get();
        $res = $seri->toArray();
        $resultado = $res[0];
        $resultado->FEC_FINA = substr($resultado->FEC_FINA,5,2) .'/'.substr($resultado->FEC_FINA,8,2) .'/'. substr($resultado->FEC_FINA,0,4) ;
        $resultado->FEC_INIC= substr($resultado->FEC_INIC,5,2) .'/'.substr($resultado->FEC_INIC,8,2) .'/'. substr($resultado->FEC_INIC,0,4) ;

        //$codigos = explode(".",$$resultado->COD_CCD);
     
        $orgas = SID_ORGA::all();
        $ccds = SID_CCD::all();
        $seris = SID_SERI::all();

        return view('fuid.edit')
            ->with('fuid', $res[0])
            ->with('orgas', $orgas)
            ->with('ccds', $ccds)
            ->with('seris', $seris);;
    }


    public function actualiza(Request $request)
    {

        $name = $request->nombrearchivo;
        if($request->file('NOM_ARCH'))
        {
            $file = $request->file('url_recurso');
            $name = 'expdiente' . time() . "." . $file->getClientOriginalExtension();
            $nombre = $file->getClientOriginalName();
            $path = public_path().'/documentos/';
            $file->move($path, $name);
        }


        $respuesta=null;
        DB::beginTransaction();

        try {

            date_default_timezone_set('America/Bogota');
            $COD_USUA = Auth::user()->COD_USUA;
            $FEC_ACTU = strftime( "%Y-%m-%d", time() );
            $HOR_ACTU = strftime( "%H:%M:%S", time() );
            $fechai = substr($request->FEC_INIC,6,4) .'-'.substr($request->FEC_INIC,0,2) .'-'. substr($request->FEC_INIC,3,2) ;
            $fechaf = substr($request->FEC_FINA,6,4) .'-'.substr($request->FEC_FINA,0,2) .'-'. substr($request->FEC_FINA,3,2) ;
       
            $seri = SID_FUID::where('COD_ENTI', '=', $request->COD_ENTI)
                ->where('COD_TRD', '=', $request->COD_TRD)
                ->where('NUM_REGI', '=', $request->NUM_REGI)
                ->update([
                        'FEC_INIC' => $fechai,
                        'FEC_FINA' => $fechaf,
                        'NUM_CAJA' => $request->NUM_CAJA,
                        'NUM_CARP' => $request->NUM_CARP,
                        'NUM_TOMO' => $request->NUM_TOMO,
                        'NUM_INTE' => $request->NUM_INTE,
                        'NUM_FOLI' => $request->NUM_FOLI,
                        'OBS_GEN1' => $request->OBS_GEN1,
                        'FRE_CONS' => $request->FRE_CONS,
                        'NOM_ARCH' => $request->NOM_ARCH,
                        'NOM_ASUN' => $request->NOM_ASUN,
                        'CON_BODE' => $request->CON_BODE,
                        'GEN_SOPO' => $request->GEN_SOPO]);
                

            DB::commit();
           
        } catch(\Illuminate\Database\QueryException $ex){ 
            DB::rollback();
            $respuesta = $ex->getMessage(); 
        }
        
        if($respuesta !=null)
        {
            Flash::warning($respuesta);
            return redirect()->route('home.fuid');
        }
        else
        {
            Flash::success("Se actulizo correctamente el registro");
            return redirect()->route('home.fuid');
        }
    }

    public function update(Request $request, $id)
    {

    }    

    public function  etiquetas(Request $requesst)
    {
        return view('fuid.etiquetas');
    }  

    public function pdf(Request $request)
    {
	
	date_default_timezone_set('America/Bogota');
        $FEC_ACTU = strftime( "%Y-%m-%d", time() );


	$fuid = DB::table('V_SIS_FUID')
	    ->where('V_SIS_FUID.CON_BODE', '=', $request->CON_BODE)
            ->join('SID_ORGA', 'V_SIS_FUID.COD_ORGA', '=', 'SID_ORGA.COD_ORGA')
            ->select('V_SIS_FUID.*', 'SID_ORGA.NOM_ORGA')
            ->get();
	//dd($fuid);

        $view =  \View::make('pdf.etiquetas', compact('fuid', 'FEC_ACTU'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        $name = time();
        $filename =  public_path() ."/documentos/etiquetas". $name. ".pdf";
        file_put_contents($filename, $pdf->stream('etiquetas'));
        return $name;
    }

    public function datos(Request $request)
    {
        $fuid = DB::table('V_SIS_FUID')
        ->where('V_SIS_FUID.CON_BODE', '=', $request->CON_BODE)
            ->join('SID_ORGA', 'V_SIS_FUID.COD_ORGA', '=', 'SID_ORGA.COD_ORGA')
            ->select('V_SIS_FUID.*', 'SID_ORGA.NOM_ORGA')
            ->get();

        return json_encode($fuid);
    }
}
