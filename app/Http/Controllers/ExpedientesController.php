<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
use App\SID_SERI;
use App\SID_CCD;
use App\SID_ORGA;
use App\SID_ENTI;
use App\SID_FUID;
use App\SID_EXPE;
use App\SID_EXPE_DETA;
use App\SID_EXPE_DETA_ARCH;

class ExpedientesController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        $datos = null;
        $encabezado = null;

    	if($request->data == "1")
        {
            $expedientes  = DB::table('V_SID_EXPE');

            if($request->NUM_DOCU != null)
            {

                $expedientes->where('V_SID_EXPE.NUM_DOCU' , '=',   $request->NUM_DOCU);
            }
            if($request->NOM_COM != null)
            {
                $expedientes->where('V_SID_EXPE.NOM_COM' , 'like',   "%$request->NOM_COM%");
            }
            if($request->NOM_MODA != null)
            {
                $expedientes->where('V_SID_EXPE.NOM_MODA' , 'like',   "%$request->NOM_MODA%");
            }
            if($request->NOM_PROG != null)
            {
                $expedientes->where('V_SID_EXPE.NOM_PROG' , 'like',   "%$request->NOM_PROG%");
            }
             if($request->TIP_NIVE != null)
            {
                $expedientes->where('V_SID_EXPE.TIP_NIVEL' , 'like',   "%$request->TIP_NIVE%");
            }
             if($request->NOM_ARCH != null)
            {
                $expedientes->where('V_SID_EXPE.NOM_ARCH' , 'like',   "%$request->NOM_ARCH%");
            }

            if($request->COD_ORGA != null)
            {
                $expedientes->where('V_SID_EXPE.COD_ORGA' , '=',   $request->COD_ORGA);
            }

             if($request->COD_SERI != null)
            {
                $expedientes->where('V_SID_EXPE.COD_TIPO'  , 'like', "$request->COD_SERI%" );
            }

            $datos = $expedientes->get();





           if($request->COD_SERI != null && $request->COD_SUBS != null)
            {


                if(count($datos) > 0 )
                {
                    $CCDBuscar = DB::table('SID_CCD')
                        ->where('SID_CCD.COD_SERI', '=', $request->COD_SERI)
                        ->where('SID_CCD.COD_SUBS','=', $request->COD_SUBS)
                        ->distinct()
                        ->get();

                    $CCD= $CCDBuscar[0];
                    
                    $encabezadosBucar = DB::table('SID_CCD_META')
                        ->where('SID_CCD_META.NUM_REGI', '=', $CCD->NUM_REGI)
                        ->where ('SID_CCD_META.COD_ENTI', '=', $CCD->COD_ENTI)
                        ->distinct()
                        ->get();

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

            }
            else
            {   
                $encabezado = null;
            }




        }
        else
        {
            $datos = null;
        }

        $orga = SID_ORGA::all();
        $seri = SID_SERI::all();
        $subs = SID_CCD::all();

        if($request->COD_SERI == null)
        {
            $codseri = null;
        }
        else
        {
            $codseri = $request->COD_SERI ;
        }


        if($request->COD_ORGA == null)
        {
            $codorga = null;
        }
        else
        {
            $codorga = $request->COD_ORGA ;
        }

        if($request->COD_SUBS == null)
        {
            $codsubs = null;
        }
        else
        {
            $codsubs = $request->COD_SUBS ;
        }

        
           return view('expedientes.index')
       		->with('expedientes', $datos)
            ->with('orga', $orga)
            ->with('seri', $seri)
            ->with('subs', $subs)
            ->with('codseri', $codseri)
            ->with('codorga', $codorga)
            ->with('codsubs', $codsubs)
            ->with('encabezado', $encabezado);
    }

    public function create()
    {

        $series = SID_SERI::all();
        $orgas = SID_ORGA::all();

        return view('expedientes.create_expe')
            ->with('series', $series)
            ->with('orgas', $orgas);
    }

    public function store(Request $request)
    {
        $name = null;
        $nombre = null;
        if($request->file('NOM_ARCH'))
        {
            $file = $request->file('NOM_ARCH');
            $name = 'expediente' . time() . "." . $file->getClientOriginalExtension();
            $nombre = $file->getClientOriginalName();
            $path = public_path().'/documentos/';
            $file->move($path, $name);

           
        }
        

      
        $respuesta=null;
        DB::beginTransaction();
        $max = $ccd = DB::table('SID_EXPE')
            ->select(DB::raw('max(COD_EXPE) as max'))
            ->get();
        
        $cod_expe = $max[0]->max + 1;

        $max = $ccd = DB::table('SID_EXPE_DETA')
            ->select(DB::raw('max(NUM_REGI) as max'))
            ->get();
        
        $num_regi = $max[0]->max + 1;

        $max = DB::table('SID_EXPE_DETA_ARCH')
            ->select(DB::raw('max(NUM_ARCH) as max'))
            ->get();
        
        $num_arch = $max[0]->max + 1;

        $fechai = null;
        $fechaf = null;

        if($request->FEC_INGR != null)
        {
            $fechai = substr($request->FEC_INGR,6,4) .'-'.substr($request->FEC_INGR,0,2) .'-'. substr($request->FEC_INGR,3,2) ;
        }
        if($request->FEC_ARCH != null)
        {
            $fechaf = substr($request->FEC_ARCH,6,4) .'-'.substr($request->FEC_ARCH,0,2) .'-'. substr($request->FEC_ARCH,3,2);
        }

        //dd($request);
        try {
            $expe = SID_EXPE::create([

                    'COD_EXPE'=> $cod_expe, 
                    'NUM_DOCU'=> $request->NUM_DOCU, 
                    'TIP_DOCU'=> $request->TIP_DOCU,  
                    'PRI_NOMB'=> $request->PRI_NOMB, 
                    'SEG_NOMB'=> $request->SEG_NOMB, 
                    'PRI_APEL'=> $request->PRI_APEL, 
                    'SEG_APEL'=> $request->SEG_APEL
                    ]);

            $deta= SID_EXPE_DETA::create([

                    'NUM_REGI'=> $num_regi, 
                    'COD_ORGA'=> $request->COD_ORGA, 
                    'COD_TIPO'=> $request->COD_SERI,  
                    'COD_EXPE'=> $expe->COD_EXPE, 
                    'ANH_FINA'=> $request->ANH_FINA, 
                    'FEC_INGR'=> $fechai, 
                    'NOM_MODA'=> $request->NOM_MODA,
                    'NOM_PROG'=> $request->NOM_PROG,
                    'OBS_GENE'=> $request->OBS_GENE,
                    'TIP_NIVEL'=> $request->TIP_NIVEL,
                    'COD_SUBS'=> $request->COD_SUBS
                    ]);

            if($name != null)
            {

                $archivo = SID_EXPE_DETA_ARCH::create([

                        'NUM_ARCH'=> $num_arch, 
                        'COD_EXPE'=> $expe->COD_EXPE, 
                        'NUM_REGI'=> $deta->NUM_REGI,  
                        'NOM_ARCH'=> $name, 
                        'FEC_ARCH'=> $fechaf, 
                        'NUM_PAGI'=> $request->NUM_PAGI, 
                        'NUM_TAMA'=> $request->NUM_TAMA,
                        'NOM_SOFT'=> $request->NOM_SOFT,
                        'NOM_VERS'=> $request->NOM_VERS,
                        'NOM_RESO'=> $request->NOM_RESO,
                        'NOM_IDIO'=> $request->NOM_IDIO,
                        ]);
            }

            DB::commit();
           
        } catch(\Illuminate\Database\QueryException $ex){ 
            DB::rollback();
            $respuesta = $ex->getMessage(); 
        }
        
        if($respuesta !=null)
        {
            Flash::warning($respuesta);
            return redirect()->route('expedientes.create');
        }
        else
        {
            Flash::success("Se insertó correctamente el registro");
            return redirect()->route('expedientes.index');
        }

    }


    public function destroy($id)
    {
        $data = explode('_', $id);
        //dd($data);

        $fuid = SID_EXPE_DETA::where('COD_EXPE', '=', $data[0])
        ->get();

        //dd(count($fuid));
        
        //if(count($fuid)>0)
        //{
        //    Flash::success("No se puede eliminar un registro con detalles");
        //    return redirect()->route('expedientes.index');
        //}
        //else
        //{
            $seri = SID_EXPE::where('COD_EXPE', '=', $data[0])
            ->where('NUM_DOCU', '=', $data[1])
            ->delete();

            $deta = SID_EXPE_DETA::where('COD_EXPE', '=', $data[0])
            ->delete();

            $arch = SID_EXPE_DETA_ARCH::where('COD_EXPE', '=', $data[0])
            ->delete();
    
            Flash::success("Se ha eliminado correctamente");
        return redirect()->route('expedientes.index');
       // }

    }

    public function edit($id)
    {   
        $data = explode('_', $id);
        $ccd = DB::table('SID_EXPE')
            ->select(
                'COD_EXPE', 
                'NUM_DOCU', 
                'TIP_DOCU',  
                'PRI_NOMB', 
                'SEG_NOMB', 
                'PRI_APEL', 
                'SEG_APEL')
            ->where('COD_EXPE', '=', $data[0])
            ->where('NUM_DOCU', '=', $data[1])
            ->get();

        $detalle = DB::table('SID_EXPE_DETA')
            ->where('COD_EXPE', '=', $data[0])
            ->where('NUM_REGI', '=', $data[2])
            ->get();

        

        $arch = DB::table('SID_EXPE_DETA_ARCH')
            ->where('COD_EXPE', '=', $data[0])
            ->where('NUM_REGI', '=', $data[2])
            ->where('NUM_ARCH', '=', $data[3])
            ->get();




        $data = array('','','','','');
        if($ccd[0]->TIP_DOCU == "CC")
        {
            $data[0] = "selected";
        }
        if($ccd[0]->TIP_DOCU == "CE")
        {
            $data[1] = "selected";
        }
        if($ccd[0]->TIP_DOCU == "RC")
        {
            $data[2] = "selected";
        }
        if($ccd[0]->TIP_DOCU == "TI")
        {
            $data[3] = "selected";
        }
        if($ccd[0]->TIP_DOCU == "NIT")
        {
            $data[4] = "selected";
        }


        $series = SID_SERI::all();
        $orgas = SID_ORGA::all();


        $arraycode = explode('.', $detalle[0]->COD_TIPO);

        
        $cod_seris= null;
        $cod_subs = null;

        $encabezado = null;
        if(count($arraycode) == 2)
        {
            $cod_seris= $arraycode[0];
            $cod_subs = $arraycode[1];
           
            $CCDBuscar = DB::table('SID_CCD')
                ->where('SID_CCD.COD_SERI', '=', $arraycode[0])
                ->where('SID_CCD.COD_SUBS','=', $arraycode[1])
                ->distinct()
                ->get();

           $CCD= $CCDBuscar[0];
                 
            $encabezadosBucar = DB::table('SID_CCD_META')
                ->where('SID_CCD_META.NUM_REGI', '=', $CCD->NUM_REGI)
                ->where ('SID_CCD_META.COD_ENTI', '=', $CCD->COD_ENTI)
                ->distinct()
                ->get();

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
            $cod_seris= $arraycode[0];
	       $cod_subs = $detalle[0]->COD_SUBS;


            $CCDBuscar = DB::table('SID_CCD')
                ->where('SID_CCD.COD_SERI', '=', $cod_seris)
                ->where('SID_CCD.COD_SUBS','=', $cod_subs)
                ->distinct()
                ->get();

           $CCD= $CCDBuscar[0];

            $encabezadosBucar = DB::table('SID_CCD_META')
                ->where('SID_CCD_META.NUM_REGI', '=', $CCD->NUM_REGI)
                ->where ('SID_CCD_META.COD_ENTI', '=', $CCD->COD_ENTI)
                ->distinct()
                ->get();

           if(count($encabezadosBucar)>0)
            {
                $encabezado = $encabezadosBucar[0];
            }
            else
            {
                $encabezado = null;
            }



        }

        return view('expedientes.edit_expe')
            ->with('expe', $ccd[0])
            ->with('detalle', $detalle[0])
            ->with('arch', $arch[0])
            ->with('data', $data)
            ->with('series', $series)
            ->with('orgas', $orgas)
            ->with('enc', $encabezado)
            ->with('codse', $cod_seris)
            ->with('codsu', $cod_subs)
            ;
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


        $respuesta = null;
        DB::beginTransaction();

        try {


            $expe = SID_EXPE::where('COD_EXPE', '=', $request->COD_EXPE)
                ->where('NUM_DOCU', '=', $request->NUM_DOCU)
                ->update(['PRI_NOMB' => $request->PRI_NOMB,
                        'SEG_NOMB'=>$request->SEG_NOMB, 
                        'PRI_APEL'=> $request->PRI_APEL,
                        'SEG_APEL'=> $request->SEG_APEL]);


            $deta = SID_EXPE_DETA::where('COD_EXPE', '=', $request->COD_EXPE)
                ->where('NUM_REGI', '=', $request->NUM_REGI)
                ->update(['COD_ORGA' => $request->COD_ORGA,
                        'COD_TIPO'=>$request->COD_SERI, 
                        'NOM_PROG'=> $request->NOM_PROG,
                        'NOM_MODA'=> $request->NOM_MODA, 
                        'TIP_NIVEL'=> $request->TIP_NIVEL, 
                        'FEC_INGR'=> $request->FEC_ING,
                        'ANH_FINA'=> $request->ANH_FINA, 
                        'OBS_GENE'=> $request->OBS_GENE,
                        'COD_SUBS' => $request->COD_SUBS]);

	if($request->file('NOM_ARCH'))
        {
            $seri = SID_EXPE_DETA_ARCH::where('COD_EXPE', '=', $request->COD_EXPE)
                ->where('NUM_REGI', '=', $request->NUM_REGI)
                ->where('NUM_ARCH', '=', $request->NUM_ARCH)
                ->update([

                       'COD_EXPE'=> $request->COD_EXPE, 
                        'NUM_REGI'=> $request->NUM_REGI,  
                        'NOM_ARCH'=> $name, 
                        'FEC_ARCH'=> $request->FEC_ARCH, 
                        'NUM_PAGI'=> $request->NUM_PAGI, 
                        'NUM_TAMA'=> $request->NUM_TAMA,
                        'NOM_SOFT'=> $request->NOM_SOFT,
                        'NOM_VERS'=> $request->NOM_VERS,
                        'NOM_RESO'=> $request->NOM_RESO,
                        'NOM_IDIO'=> $request->NOM_IDIO
                     ]);
	}


            DB::commit();
           
        } catch(\Illuminate\Database\QueryException $ex){ 
            DB::rollback();
            $respuesta = $ex->getMessage(); 
        }
        
        if($respuesta !=null)
        {
            Flash::warning($respuesta);
            return redirect()->route('expedientes.edit');
        }
        else
        {
            Flash::warning("Se actualizó correctamente el registro");
            return redirect()->route('expedientes.index');
        }
    }

    public function update(Request $request, $id)
    {

    }      

    public function buscarencabezado(Request $request)
    {
           $encabezado = null;
           $cod_seris= $request->COD_SERI;
           $cod_subs = $request->COD_SUBS;


            $CCDBuscar = DB::table('SID_CCD')
                ->where('SID_CCD.COD_SERI', '=', $cod_seris)
                ->where('SID_CCD.COD_SUBS','=', $cod_subs)
                ->distinct()
                ->get();

           $CCD= $CCDBuscar[0];

            $encabezadosBucar = DB::table('SID_CCD_META')
                ->where('SID_CCD_META.NUM_REGI', '=', $CCD->NUM_REGI)
                ->where ('SID_CCD_META.COD_ENTI', '=', $CCD->COD_ENTI)
                ->distinct()
                ->get();

           if(count($encabezadosBucar)>0)
            {
                $encabezado = $encabezadosBucar[0];
            }
            else
            {
                $encabezado = null;
            }
            return json_encode($encabezado);
    }



}
