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

class ArchivoController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');
    }

     public function index(Request $request)
    {

        $detalles = DB::table('SID_EXPE_DETA_ARCH')
            ->where('COD_EXPE', '=', $request->COD_EXPE)
            ->where('NUM_REGI', '=', $request->NUM_REGI)
            ->get();

           return view('archivo.index')
            ->with('detalles', $detalles)
            ->with('COD_EXPE', $request->COD_EXPE)
            ->with('NUM_REGI', $request->NUM_REGI);
    }

    public function create(Request $request)
    {

           return view('archivo.create')
            ->with('COD_EXPE', $request->COD_EXPE)
            ->with('NUM_REGI', $request->NUM_REGI);
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
        $max = DB::table('SID_EXPE_DETA_ARCH')
            ->select(DB::raw('max(NUM_ARCH) as max'))
            ->get();
        
        $num_arch = $max[0]->max + 1;
        $fechaf = null;
        if($request->FEC_ARCH != null)
        {
            $fechaf = substr($request->FEC_ARCH,6,4) .'-'.substr($request->FEC_ARCH,0,2) .'-'. substr($request->FEC_ARCH,3,2);
        }

        try {
            $seri = SID_EXPE_DETA_ARCH::create([

                    'NUM_ARCH'=> $num_arch, 
                    'COD_EXPE'=> $request->COD_EXPE, 
                    'NUM_REGI'=> $request->NUM_REGI,  
                    'NOM_ARCH'=> $name, 
                    'FEC_ARCH'=> $fechaf,
                    'NUM_PAGI'=> $request->NUM_PAGI, 
                    'NUM_TAMA'=> $request->NUM_TAMA,
                    'NOM_SOFT'=> $request->NOM_SOFT,
                    'NOM_VERS'=> $request->NOM_VERS,
                    'NOM_RESO'=> $request->NOM_RESO,
                    'NOM_IDIO'=> $request->NOM_IDIO,
                    ]);

            DB::commit();
           
        } catch(\Illuminate\Database\QueryException $ex){ 
            DB::rollback();
            $respuesta = $ex->getMessage(); 
        }
        
        if($respuesta !=null)
        {
            Flash::warning($respuesta);
            return redirect()->route('archivo.create', array('COD_EXPE' => $request->COD_EXPE, 'NUM_REGI' => $request->NUM_REGI));
        }
        else
        {
            Flash::success("Se insertó correctamente el registro");
            return redirect()->route('archivo.index', array('COD_EXPE' => $request->COD_EXPE, 'NUM_REGI' => $request->NUM_REGI));
        }

    }


    public function destroy($id)
    {
        $data = explode('_', $id);
            $seri = SID_EXPE_DETA_ARCH::where('COD_EXPE', '=', $data[0])
            ->where('NUM_REGI', '=', $data[1])
            ->where('NUM_ARCH', '=', $data[2])
            ->delete();
    
            Flash::success("Se ha eliminado correctamente");
            return redirect()->route('archivo.index', array('COD_EXPE' => $data[0], 'NUM_REGI' => $data[1]));
        

    }

    public function edit($id)
    {   
        $data = explode('_', $id);
        $ccd = DB::table('SID_EXPE_DETA_ARCH')
            ->where('COD_EXPE', '=', $data[0])
            ->where('NUM_REGI', '=', $data[1])
            ->where('NUM_ARCH', '=', $data[2])
            ->get();


        return view('archivo.edit')
            ->with('expe', $ccd[0]);
    }


    public function actualiza(Request $request)
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

        $fechaf = null;
        if($request->FEC_ARCH != null)
        {
            $fechaf = substr($request->FEC_ARCH,6,4) .'-'.substr($request->FEC_ARCH,0,2) .'-'. substr($request->FEC_ARCH,3,2);
        }


        if($name == null){
        $seri = SID_EXPE_DETA_ARCH::where('COD_EXPE', '=', $request->COD_EXPE)
            ->where('NUM_REGI', '=', $request->NUM_REGI)
            ->where('NUM_ARCH', '=', $request->NUM_ARCH)
            ->update([ 
                    'FEC_ARCH'=>  $fechaf, 
                    'NUM_PAGI'=> $request->NUM_PAGI, 
                    'NUM_TAMA'=> $request->NUM_TAMA,
                    'NOM_SOFT'=> $request->NOM_SOFT,
                    'NOM_VERS'=> $request->NOM_VERS,
                    'NOM_RESO'=> $request->NOM_RESO,
                    'NOM_IDIO'=> $request->NOM_IDIO
                     ]);

        }

        else{
            $seri = SID_EXPE_DETA_ARCH::where('COD_EXPE', '=', $request->COD_EXPE)
            ->where('NUM_REGI', '=', $request->NUM_REGI)
            ->where('NUM_ARCH', '=', $request->NUM_ARCH)
            ->update([ 
                    'FEC_ARCH'=>  $fechaf, 
                    'NOM_ARCH'=> $name, 
                    'NUM_PAGI'=> $request->NUM_PAGI, 
                    'NUM_TAMA'=> $request->NUM_TAMA,
                    'NOM_SOFT'=> $request->NOM_SOFT,
                    'NOM_VERS'=> $request->NOM_VERS,
                    'NOM_RESO'=> $request->NOM_RESO,
                    'NOM_IDIO'=> $request->NOM_IDIO
                     ]);
        }





        Flash::warning("Se actualizó  correctamente el registro");
        return redirect()->route('archivo.index', array('COD_EXPE' => $request->COD_EXPE, 'NUM_REGI' => $request->NUM_REGI));

    }

    public function update(Request $request, $id)
    {

    }      



}
