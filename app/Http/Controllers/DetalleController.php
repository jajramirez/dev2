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
use App\SID_ORGA;
use App\SID_FUID;
use App\SID_EXPE;
use App\SID_EXPE_DETA;
use App\SID_EXPE_DETA_ARCH;

class DetalleController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');
    }

    public function index(Request $request)
    {

    }

     public function expedientes(Request $request)
    {

        $detalles = DB::table('SID_EXPE_DETA')
            ->where('COD_EXPE', '=', $request->COD_EXPE)
            ->get();


            $detalleBuscar = $detalles[0];

            $CCDBuscar = DB::table('SID_CCD')
                    ->where('SID_CCD.COD_SERI', '=', $detalleBuscar->COD_TIPO)
                    ->where('SID_CCD.COD_SUBS','=', $detalleBuscar->COD_SUBS)
                    ->distinct()
                    ->get();

    
            if(count($CCDBuscar) > 0 )
            {
                $CCD= $CCDBuscar[0];
                  
                $encabezadosBucar = DB::table('SID_CCD_META')
                        ->where('SID_CCD_META.NUM_REGI', '=', $CCD->NUM_REGI)
                        ->where ('SID_CCD_META.COD_ENTI', '=', $CCD->COD_ENTI)
                        ->distinct()
                        -get();

                if(count($encabezadosBucar)>0)
                {        
                    $encabezado = $encabezadosBucar[0];
                }

                else
                {

                    $encabezado = null;
                }

            }
            else
            {
                $encabezado = null;
            }


           return view('detalles.index')
            ->with('detalles', $detalles)
            ->with('COD_EXPE', $request->COD_EXPE)
            ->with('encabezado', $encabezado);
    }

    public function nuevo(Request $request)
    {

        $series = SID_SERI::all();
        $orgas = SID_ORGA::all();
           return view('detalles.create')
            ->with('COD_EXPE', $request->COD_EXPE)
            ->with('series', $series)
            ->with('orgas', $orgas)
            ;
    }

    public function store(Request $request)
    {


        $respuesta=null;
        DB::beginTransaction();
        $max = $ccd = DB::table('SID_EXPE_DETA')
            ->select(DB::raw('max(NUM_REGI) as max'))
            ->get();
        
        $num_regi = $max[0]->max + 1;

        try {
            $seri = SID_EXPE_DETA::create([

                    'NUM_REGI'=> $num_regi, 
                    'COD_ORGA'=> $request->COD_ORGA, 
                    'COD_TIPO'=> $request->COD_SERI,  
                    'COD_EXPE'=> $request->COD_EXPE, 
                    'ANH_FINA'=> $request->ANH_FINA, 
                    'FEC_INGR'=> $request->FEC_INGR, 
                    'NOM_MODA'=> $request->NOM_MODA,
                    'NOM_PROG'=> $request->NOM_PROG,
                    'OBS_GENE'=> $request->OBS_GENE,
                    'TIP_NIVEL'=> $request->TIP_NIVEL,
                    'COD_SUBS' => $request->COD_SUBS
                    ]);

            DB::commit();
           
        } catch(\Illuminate\Database\QueryException $ex){ 
            DB::rollback();
            $respuesta = $ex->getMessage(); 
        }
        
        if($respuesta !=null)
        {
            Flash::warning($respuesta);
            return redirect()->route('detalles.nuevo', array('COD_EXPE' => $request->COD_EXPE));
        }
        else
        {
            Flash::success("Se insertó correctamente el registro");
            return redirect()->route('detalles.expediente', array('COD_EXPE' => $request->COD_EXPE));
        }

    }


    public function destroy($id)
    {
        $data = explode('_', $id);


        $fuid = SID_EXPE_DETA_ARCH::where('COD_EXPE', '=', $data[0])
        ->get();
        
        if(count($fuid)>0)
        {
            Flash::success("No se puede eliminar un registro con archivos");
            return redirect()->route('detalles.expediente', array('COD_EXPE' => $data[0]));
        }
        else
        {
            $seri = SID_EXPE::where('COD_EXPE', '=', $data[0])
            ->where('NUM_REGI', '=', $data[1])
            ->delete();
    
            Flash::success("Se ha eliminado correctamente");
            return redirect()->route('detalles.expediente', array('COD_EXPE' => $data[0]));
        }

    }

    public function edit($id)
    {   
        $data = explode('_', $id);
        $ccd = DB::table('SID_EXPE_DETA')
            ->where('COD_EXPE', '=', $data[0])
            ->where('NUM_REGI', '=', $data[1])
            ->get();

         $series = SID_SERI::all();
         $orgas = SID_ORGA::all();
    

        return view('detalles.edit')
            ->with('expe', $ccd[0])
            ->with('series', $series)
            ->with('orgas', $orgas);
    }


    public function actualiza(Request $request)
    {

        $seri = SID_EXPE_DETA::where('COD_EXPE', '=', $request->COD_EXPE)
            ->where('NUM_REGI', '=', $request->NUM_REGI)
            ->update(['COD_ORGA' => $request->COD_ORGA,'COD_TIPO'=>$request->COD_SERI, 'NOM_PROG'=> $request->NOM_PROG,
                     'NOM_MODA'=> $request->NOM_MODA, 'TIP_NIVEL'=> $request->TIP_NIVEL, 'FEC_INGR'=> $request->FEC_ING,
                     'ANH_FINA'=> $request->ANH_FINA, 'OBS_GENE'=> $request->OBS_GENE,'COD_SUBS' => $request->COD_SUBS]);

        Flash::warning("Se actualizó correctamente el registro");
        return redirect()->route('detalles.expediente', array('COD_EXPE' => $request->COD_EXPE));
    }

    public function update(Request $request, $id)
    {

    }      



}
