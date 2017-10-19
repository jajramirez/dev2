<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
use App\SID_SERI;
use App\SID_CCD_META;
use App\SID_CCD;
use App\SID_ENTI;
use App\SID_FUID;

class MEtaController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');
    }

    public function index(Request $request)
    {
           
    	 	$ccd = DB::table('SID_CCD_META')
                ->select('SID_CCD_META.COD_ENTI', 'SID_CCD_META.NUM_REGI', 'SID_CCD_META.MET1'
                            , 'SID_CCD_META.MET2'
                            , 'SID_CCD_META.MET3'
                            , 'SID_CCD_META.MET4'
                            , 'SID_CCD_META.MET5'
                            , 'SID_CCD_META.MET6'
                            , 'SID_CCD_META.MET7'
                            , 'SID_CCD_META.MET8'
                            , 'SID_CCD_META.MET9'
                            , 'SID_CCD_META.MET10'
                            , 'SID_CCD_META.MET11'
                            , 'SID_CCD.COD_SERI'
                            , 'SID_CCD.COD_SUBS')
            ->join('SID_CCD', 'SID_CCD.NUM_REGI', '=', 'SID_CCD_META.NUM_REGI')
            ->get();

           return view('meta.index')
       		->with('ccds', $ccd);
    }

    public function create(Request $request)
    {
        $data = explode('_', $request->d);

    	$seri = SID_SERI::all();
    	$ccd = SID_CCD::all();

        $subserie = DB::table('SID_CCD')
            ->where('COD_ENTI', '=', $data[0])
            ->where('NUM_REGI', '=', $data[1])
            ->get();



           return view('meta.create')
            ->with('seris', $seri)
            ->with('ccds', $ccd)
            ->with('subserie', $subserie[0]);
    }

    public function store(Request $request)
    {   
        $respuesta=null;
       
        $ccd = DB::table('SID_CCD')
            ->where('COD_SERI', '=', $request->COD_SERI)
            ->where('COD_SUBS', '=', $request->COD_SUBS)
            ->get();

        $serir = $ccd[0]->NUM_REGI;

        

        $meta = DB::table('SID_CCD_META')
            ->where('NUM_REGI', '=', $serir)
            ->get();


        if(count($meta)==0)
        {
            DB::beginTransaction();
            try {
                $seri = SID_CCD_META::create([
                        'COD_ENTI'=> '01',
                        'NUM_REGI'=> $serir,
                        'MET1'=> $request->MET1,
                        'MET2'=> $request->MET2,
                        'MET3'=> $request->MET3,
                        'MET4'=> $request->MET4,
                        'MET5'=> $request->MET5,
                        'MET6'=> $request->MET6,
                        'MET7'=> $request->MET7,
                        'MET8'=> $request->MET8,
                        'MET9'=> $request->MET9,
                        'MET10'=> $request->MET10,
                        'MET11'=> $request->MET11,
                        ]);

                DB::commit();
               
            } catch(\Illuminate\Database\QueryException $ex){ 
                DB::rollback();
                $respuesta = $ex->getMessage(); 
            }
            
            if($respuesta !=null)
            {
                Flash::warning($respuesta);
                return redirect()->route('meta.create');
            }
            else
            {
                Flash::success("Se insertó correctamente el registro");
                return redirect()->route('meta.index');
            }
        }
        else
        {
            Flash::warning("Ya existe un registro para la serie y la subserie ingresada.");
            return redirect()->route('meta.create');
        }

    }


    public function destroy($id)
    {
        $seri = SID_CCD_META::where('NUM_REGI', '=', $id)
            ->where('COD_ENTI', '=', '01')
            ->delete();
    
            Flash::success("Se ha eliminado correctamente");
        return redirect()->route('meta.index');
        

    }

    public function edit($id)
    {   
        $data = explode('_', $id);
        if(count($data) == 3)
        {
             $val = SID_CCD::where('COD_SERI',  $data[2])
                ->get();

            if(count($val) == 0) 
            {

                $max = DB::table('SID_CCD')
                ->select(DB::raw('max(NUM_REGI) as max'))
                ->get();
            
                $num_regi = $max[0]->max + 1;
                DB::beginTransaction();
                date_default_timezone_set('America/Bogota');
                $COD_USUA = \Auth::user()->COD_USUA;
                $FEC_ACTU = strftime( "%Y-%m-%d", time() );
                $HOR_ACTU = strftime( "%H:%M:%S", time() );

                try {
                    $seri = SID_CCD::create([
                            'COD_ENTI'=> '01',
                            'NUM_REGI'=> $num_regi,
                            'COD_SERI'=> $data[2],
                            'IND_ESTA'=> 'A',
                            'COD_USUA'=> $COD_USUA,
                            'FEC_ACTU'=> $FEC_ACTU,
                            'HOR_ACTU'=> $HOR_ACTU,
                            ]);

                    DB::commit();
                   
                } catch(\Illuminate\Database\QueryException $ex){ 
                    DB::rollback();
                    $respuesta = $ex->getMessage(); 
                }

                $data[1] = $num_regi;
            }
            else
            {   
                $data[1] = $val[0]->NUM_REGI;
            }

        }
            
        $ccdF = SID_CCD::where('NUM_REGI',  $data[1] )
                ->get();


            $ccd = DB::table('SID_CCD_META')
                ->where('NUM_REGI', '=', $data[1])
                ->where('COD_ENTI', '=', $data[0])
                ->get();

            $res = null;

            if(count($ccd) > 0)
            {
                $res = $ccd[0];
            }
        
            $seri = SID_SERI::all();
            $ccdo = SID_CCD::all();
            return view('meta.edit')
                ->with('ccd', $res)
                ->with('ccdf', $ccdF[0])
                ->with('ccdo', $ccdo)
                ->with('seris', $seri)
                ->with('proces');
        

    }


    public function actualizar(Request $request)
    {

             $seri = SID_CCD_META::where('NUM_REGI', '=', $request->NUM_REGI)
                ->where('COD_ENTI', '=', '01')
                ->get();

            if(count($seri) == 0 )
            {
                $seri = SID_CCD_META::create([
                        'COD_ENTI'=> '01',
                        'NUM_REGI'=> $request->NUM_REGI,
                        'MET1'=> $request->MET1,
                        'MET2'=> $request->MET2,
                        'MET3'=> $request->MET3,
                        'MET4'=> $request->MET4,
                        'MET5'=> $request->MET5,
                        'MET6'=> $request->MET6,
                        'MET7'=> $request->MET7,
                        'MET8'=> $request->MET8,
                        'MET9'=> $request->MET9,
                        'MET10'=> $request->MET10,
                        'MET11'=> $request->MET11,
                        ]);

                DB::commit();

                 Flash::success("Se registró correctamente el registro");
                return redirect()->route('ccd.index');
            }
            else
            {
           
                $seri = SID_CCD_META::where('NUM_REGI', '=', $request->NUM_REGI)
                    ->where('COD_ENTI', '=', '01')
                    ->update(['MET1' => $request->MET1,
                            'MET2' => $request->MET2,
                            'MET3' => $request->MET3,
                            'MET4' => $request->MET4,
                            'MET5' => $request->MET5,
                            'MET6' => $request->MET6,
                            'MET7' => $request->MET7,
                            'MET8' => $request->MET8,
                            'MET9' => $request->MET9,
                            'MET10' => $request->MET10,
                            'MET11' => $request->MET11]);

                Flash::success("Se actualizó correctamente el registro");
                return redirect()->route('seris.index');
            }
        

    }

    public function update(Request $request, $id)
    {

    }   

    public function subserie(Request $request)
    {

        $ccd = SID_CCD::where('COD_SERI', '=', $request->COD_SERI)
                ->get(); 
        if(count($ccd) == 0)
        {
            return redirect()->route('meta.edit', array('COD_ENTI' => '01_0_'.$request->COD_SERI));
        }
        else
        {
            if(count($ccd) == 1)
            {
                if($ccd[0]->COD_SUBS == null || $ccd[0]->COD_SUBS == '0')
                {
                    return redirect()->route('meta.edit', array('COD_ENTI' => $ccd[0]->COD_ENTI.'_'.$ccd[0]->NUM_REGI ));
            
                }
     
            }
            else
            {

            return view('meta.subserie')
                ->with('ccds', $ccd);
            }
        }
    }  

    public function seleccion(Request $request)
    {
        return redirect()->route('meta.edit', array('COD_ENTI' => $request->COD_SUBS ));
    } 



}
