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
use App\SID_TRD;
use App\SID_TRD_DETA;
use App\SID_FUID;
use App\SID_CCD;

class TrdController extends Controller
{
    
    public function __construct()
    {

        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        if($request->data=="1")
        {
    	  $consulta = DB::table('V_SID_TRD');

            if($request->COD_ORGA != null)
            {
                $consulta->where('V_SID_TRD.COD_ORGA' , '=', $request->COD_ORGA);
            }
            if($request->COD_SERI != null)
            {
                $consulta->where('V_SID_TRD.COD_CCD' , 'like', "$request->COD_SERI%");
            }
            $deps = $consulta->get();

            $i=0;
            $info = null;
            foreach ($deps as $d)
            {
                $vec = explode(".", $d->COD_CCD);
               if(count($vec) == 1 )
               {
                $vec[1] = '';
               }

                $info[$i] =  DB::table('SID_CCD')
                    ->select('NOM_SUBS')
                    ->where('COD_SERI' ,'=', $vec[0])
                    ->where('COD_SUBS' ,'=', $vec[1])
                    ->get();
               $i++;
            }

        }
        else
        {
            $info = null;
            $deps = null;
        }

        $orga = SID_ORGA::all();
        $seri = SID_SERI::all();
        $corga = 0;
        $cseri = 0;

        if($request->COD_SERI == null)
        {
            $codseri = null;
        }
        else
        {
            $codseri = $request->COD_SERI ;
            $cseri = $request->COD_SERI ;
        }


        if($request->COD_ORGA == null)
        {
            $codorga = null;
        }
        else
        {
            $codorga = $request->COD_ORGA ;
            $corga = $request->COD_ORGA;
        }


        return view('trd.index')
       		->with('deps', $deps)
            ->with('orga', $orga)
            ->with('seri', $seri)
            ->with('codseri', $codseri)
            ->with('codorga', $codorga)
            ->with('info', $info)
            ->with('secuencia', 0)
            ->with('cseri', $cseri)
            ->with('corga', $corga);
    }
    

    public function create()
    {   

      
        $ccds = SID_CCD::all();
        $enti = SID_ENTI::all();
        $orgs = SID_ORGA::all();
        $seri = SID_SERI::all();
        return view('trd.create')
            ->with('entis', $enti)
            ->with('orgas', $orgs)
        	->with('seris', $seri)
             ->with('ccds', $ccds);
                
    }   

    public function store(Request $request)
    {  
        $respuesta=null;
        DB::beginTransaction();
        date_default_timezone_set('America/Bogota');
        $COD_USUA = Auth::user()->COD_USUA;
        $FEC_ACTU = strftime( "%Y-%m-%d", time() );
        $HOR_ACTU = strftime( "%H:%M:%S", time() );
        $trdcode = null;
        $ccdcode = null;
        if($request->COD_SUBS == null)
        {
            $trdcode = $request->COD_ORGA . '.' . $request->COD_SERI;
            $ccdcode = $request->COD_SERI;
        }
        else
        {
            $trdcode = $request->COD_ORGA . '.' . $request->COD_SERI . '.' .$request->COD_SUBS;
            $ccdcode = $request->COD_SERI . '.' .$request->COD_SUBS;
        }
        

       

        $trd = DB::table('SID_TRD')
            ->where('COD_TRD', '=', $trdcode)
            ->where('COD_ENTI', '=', '01')
            ->get();
        $res = $trd->toArray();

        if(count($res) != 0)
        {
            Flash::warning("No se puede ingresar el registro, el código TRD ".$trdcode." ya existe.");
            return redirect()->route('trd.index');
        }
        else
        {
            try {


          
                
                $trd = SID_TRD::create([
             		'COD_ENTI'=> '01',
    				'ARC_GEST'=> $request->ARC_GEST,  
                    'COD_ORGA'=> $request->COD_ORGA, 
    				'ARC_CENT'=> $request->ARC_CENT, 
    				'BAN_CT'=> $request->BAN_CT, 
    				'BAN_E'=> $request->BAN_E, 
    				'BAN_M'=> $request->BAN_M,
    				'BAN_S'=> $request->BAN_S,
    				'TEX_OBSE'=> $request->TEX_OBSE,
    				'IND_ESTA'=> $request->IND_ESTA,
                    'COD_USUA'=> $COD_USUA,
                    'FEC_ACTU'=> $FEC_ACTU,
                    'HOR_ACTU'=> $HOR_ACTU,
                    'COD_TRD'=> $trdcode, 
                    'COD_CCD' => $ccdcode ]);


                $datos = explode('^', $request->deta);
                $id_det = 1 ;
                 for($i=0; $i<=count($datos)-2; $i++)
                 {
                    $deta = SID_TRD_DETA::create([
                        'COD_ENTI'=> '01',
                        'NUM_REGI'=> $id_det++ ,
                        'NOM_DESC'=> $datos[$i],
                        'COD_TRD'=> $trdcode, 
                        'COD_USUA'=> $COD_USUA,
                        'FEC_ACTU'=> $FEC_ACTU,
                        'HOR_ACTU'=> $HOR_ACTU 
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
                return redirect()->route('trd.index');
            }
            else
            {
                Flash::success("Se insertó correctamente el registro");
                return redirect()->route('trd.index');
            }
        }

    }

    public function destroy($id)
    {

        $data = explode('_', $id);
    	$trd = SID_FUID::where('COD_TRD', '=', $data[1])->get();
        if(count($trd)>0)
    	{
    	   Flash::success("No se puede eliminar un registro con uso en lista FUID.");
            return redirect()->route('trd.index');
    	}
    	else{
    	   $seri = SID_TRD::where('COD_TRD', '=', $data[1])
                ->where('COD_ENTI', '=', $data[0])
                ->delete();
            Flash::success("Se ha eliminado correctamente");
            return redirect()->route('trd.index');
    	}
    }

    public function edit($id)
    {   
        $data = explode('_', $id);
        $enti = SID_ENTI::all();
        $orgs = SID_ORGA::all();
        $seri = SID_SERI::all();
        $trd = DB::table('SID_TRD')
            ->where('COD_TRD', '=', $data[1])
            ->where('COD_ENTI', '=', $data[0])
            ->get();
        $res = $trd->toArray();

        $codigo = $res[0]->COD_TRD;
		$pos = strpos($codigo, '.');
		$cod_enti = substr($codigo ,0, $pos);
		$cod_seri = substr($codigo ,$pos+1, strlen($codigo));

        $detalle = DB::table('SID_TRD_DETA')
            ->where('COD_TRD' ,'=', $res[0]->COD_TRD)
            ->where('COD_ENTI' ,'=', $res[0]->COD_ENTI)
            ->get();


        $descripciondetalle = null;
        foreach ($detalle as $d) {
            $descripciondetalle = $descripciondetalle . $d->NOM_DESC . '^';
        }
       return view('trd.edit')
            ->with('trd', $res[0])
            ->with('enti', $enti)
            ->with('orga', $orgs)
            ->with('seri', $seri)
     		->with('codorga', $cod_enti)
            ->with('codseri', $cod_seri)
            ->with('detalle', $detalle)
            ->with('des_deta', $descripciondetalle);
    }


    public function actualizar(Request $request)
    {

        DB::beginTransaction();
        date_default_timezone_set('America/Bogota');
        $COD_USUA = Auth::user()->COD_USUA;
        $FEC_ACTU = strftime( "%Y-%m-%d", time() );
        $HOR_ACTU = strftime( "%H:%M:%S", time() );
        $respuesta = null;

          $datos = explode('^', $request->deta);
          
        try {

            $seri = SID_TRD::where('COD_TRD', '=', $request->COD_TRD)
                ->where('COD_ENTI', '=', $request->COD_ENTI)
                ->update(['ARC_GEST' => $request->ARC_GEST,'ARC_CENT' => $request->ARC_CENT, 'IND_ESTA'=> $request->IND_ESTA,'COD_USUA'=> $COD_USUA,
                'FEC_ACTU'=> $FEC_ACTU, 'HOR_ACTU'=> $HOR_ACTU, 'BAN_CT'=> $request->BAN_CT, 'BAN_E'=> $request->BAN_E , 'BAN_M'=> $request->BAN_M,
                'BAN_S'=> $request->BAN_S, 'TEX_OBSE'=> $request->TEX_OBSE ]);



            if($request->deta != $request->original)
            {
                if($request->original != null)
                {
                    $seri = SID_TRD_DETA::where('COD_TRD', '=', $request->COD_TRD)
                        ->where('COD_ENTI', '=', $request->COD_ENTI )
                        ->delete();
                }

                $datos = explode('^', $request->deta);

                $id_det = 1 ;
                 for($i=0; $i<=count($datos)-2; $i++)
                 {
                    $deta = SID_TRD_DETA::create([
                        'COD_ENTI'=> $request->COD_ENTI,
                        'NUM_REGI'=> $id_det++ ,
                        'NOM_DESC'=> $datos[$i],
                        'COD_TRD'=> $request->COD_TRD,
                        'COD_USUA'=> $COD_USUA,
                        'FEC_ACTU'=> $FEC_ACTU,
                        'HOR_ACTU'=> $HOR_ACTU 
                        ]);
                 }


            }   

            DB::commit();
           
        } catch(\Illuminate\Database\QueryException $ex){ 
            DB::rollback();
            $respuesta = $ex->getMessage(); 
        }
        
        if($respuesta !=null)
        {
            Flash::warning($respuesta);
            return redirect()->route('trd.index');
        }
        else
        {

        Flash::warning("Se actualizó correctamente el registro");
        return redirect()->route('trd.index');
        }
    }

    public function update(Request $request, $id)
    {

    }

    public function cargararchivo()
    {
        return view('trd.carga');
    }   

    public function cargartrd(Request $request)
    {
         //dd("prueba");
        $respuesta = null;
        $errorSQl = null;
        //Subir archivo a servidor
        if ($request->file('url_recurso')) {
            $file = $request->file('url_recurso');
            $name = 'flr' . time() . "." . $file->getClientOriginalExtension();
            $nombre = $file->getClientOriginalName();
            $path = public_path() . '/cargar/';
            $file->move($path, $name);
        }

        $csv = array_map('str_getcsv', file(public_path() . '/cargar/' . $name));
        $val = $csv[0];
   
        if (is_array($val[0])) {
            //dd($val);
        } else {
            $dat = strpos($val[0], ";");
            if ($dat === false) {
                $dat = strpos($val[0], ",");
                if ($dat === false) {
                    
                } else {
                    $val = explode(",", $val[0]);
                }
            } else {
                $val = explode(";", $val[0]);
                $dat = strpos($val[0], ",");
                if ($dat === true) {
                    $val = explode(",", $val[0]);
                }
            }
        }
        $insert = "INSERT INTO SID_TRD (`COD_ENTI`,";


        $cod_trd = null;
        $cod_orga = null;
        $cod_seri = null;
        $cod_subs = null;
        $ban_ct = null;
        $ban_e = null;
        $ban_m = null;
        $ban_s = null;
        $arc_gest = null;
        $arc_cent = null;
        $text_obse = null;

        for ($i = 0; $i < count($val); $i++) {
            $val[$i] = str_replace("'", "", $val[$i]);
            $val[$i] = str_replace('"', "", $val[$i]);
            if ($val[$i] == 'COD_ORGA') {
                $cod_orga = $i;
            }
            if ($val[$i] == 'COD_TRD') {
                $cod_trd = $i;
            }
            if ($val[$i] == 'COD_SERI') {
                $cod_seri = $i;
            }
            if ($val[$i] == 'COD_SUBS') {
                $cod_subs = $i;
            }
            if ($val[$i] == 'BAN_CT') {
                $ban_ct = $i;
            }
            if ($val[$i] == 'BAN_E') {
                $ban_e = $i;
            }
            if ($val[$i] == 'BAN_M') {
                $ban_m = $i;
            }
            if ($val[$i] == 'BAN_S') {
                $ban_s = $i;
            }
            if ($val[$i] == 'ARC_GEST') {
                $arc_gest = $i;
            }
            if ($val[$i] == 'ARC_CENT') {
                $arc_cent = $i;
            }
             if ($val[$i] == 'TEX_OBSE') {
                $text_obse = $i;
            }

            if($val[$i] != 'COD_SUBS' && $val[$i] != 'COD_SERI' )
            {
                $insert = $insert . '`' . $val[$i] . '`';
            }
            if ($i == count($val) - 1) {
                $insert = $insert . ', `COD_CCD`,`IND_ESTA`, `COD_USUA`, `FEC_ACTU`, `HOR_ACTU`) VALUES ';
            } else {
                if($val[$i] != 'COD_SUBS' && $val[$i] != 'COD_SERI' )
                {
                    $insert = $insert . ',';
                }
            }
        }


        $datosinsert = array(count($csv)-2);

        $data = null;
        $incremental = 2;
        $numerovecto = 0;
        for ($i = 2; $i < count($csv); $i++) {
            $incremental++;
            $data = "('01',";
            $val = $csv[$i];
            if (count($val) > 1) {
                for ($ih = 1; $ih < count($val); $ih++) {
                    $val[0] = $val[0] . ', ' . $val[$ih];
                }
            }

            if (is_array($val[0])) {
                
            } 
            else 
            {
                $dat = strpos($val[0], ";");
                if ($dat === false) {
                    $dat = strpos($val[0], ",");
                    if ($dat === false) {
                        
                    } else {
                        $val = explode(",", $val[0]);
                    }
                } else {
                    $val = explode(";", $val[0]);
                    $dat = strpos($val[0], ",");
                    if ($dat === true) {
                        $val = explode(",", $val[0]);
                    }
                }
            }
            
            $seriebuscar = null;
            $subseriebuscar = null;
            for ($j = 0; $j < count($val); $j++) 
            {

                $val[$j] = str_replace("'", "", $val[$j]);
                $val[$j] = str_replace('"', "", $val[$j]);

                if ($val[$j] == '') {
                    if ($j == $cod_trd) {
                        $respuesta = $respuesta . "El campo Codigo TRD de la fila " . $incremental . " no puede estar en blanco</br>";
                        $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                    }
                    else{
                        if ($j == $cod_seri) {
                            $respuesta = $respuesta . "El campo Codigo Serie de la fila " . $incremental . " no puede estar en blanco</br>";
                            $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                        }
                        else{
                            if ($j == $cod_subs) {
                                $respuesta = $respuesta . "El campo Codigo Subserie de la fila " . $incremental . " no puede estar en blanco</br>";
                                $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                            }
                            
                                else{
                                    if ($j == $cod_orga) {
                                        $respuesta = $respuesta . "El campo Codigo oficina productora de la fila " . $incremental . " no puede estar en blanco</br>";
                                        $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                                    }
                                    else
                                    {
                                        if($j == $ban_ct)
                                        {
                                            $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                                            $respuesta = $respuesta . "El campo Conservación Total  de la fila " . $incremental . " debe ser '0' o '1'</br>";
                                        }
                                        else
                                        {
                                            if($j == $ban_e)
                                            {
                                                $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                                                $respuesta = $respuesta . "El campo Eliminación   de la fila " . $incremental . " debe ser '0' o '1'</br>";
                                            }
                                            else
                                            {
                                                if($j == $ban_m)
                                                {
                                                    $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                                                    $respuesta = $respuesta . "El campo Microfilmación de la fila " . $incremental . " debe ser '0' o '1'</br>";
                                                }
                                                else
                                                {
                                                    if($j == $ban_s)
                                                    {
                                                        $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                                                        $respuesta = $respuesta . "El campo Selección de la fila " . $incremental . " debe ser '0' o '1'</br>";     
                                                    }
                                                    else
                                                    {
                                                        if($j == $arc_cent)
                                                        {
                                                            $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                                                            $respuesta = $respuesta . "El campo Central de la fila " . $incremental . " no puede estar en blanco</br>";     
                                                        }
                                                        else
                                                        {
                                                            if($j == $arc_gest)
                                                            {
                                                                $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                                                                $respuesta = $respuesta . "El campo Gestión de la fila " . $incremental . " no puede estar en blanco</br>";     
                                                            }
                                                            else
                                                            {
                                                                if($j == $text_obse)
                                                                {
                                                                    $val[$j] = ' ';
                                                                    $respuesta = $respuesta . "El campo Observaciones de la fila " . $incremental . " no puede estar en blanco</br>";     
                                                                }
                                                                else
                                                                {
                                                                    $val[$j] = 'null';
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }

                                        }
                                        
                                    }
                                }
                            
                        }
                    }

                   
                } else {
                    if ($j == $cod_trd) {
                        //validar que el codigo TRD no exista en la base de datos
                        //dd($val[$j]);
                        $con_trd = DB::table('SID_TRD')
                                ->where('SID_TRD.COD_TRD', '=', $val[$j])
                                ->get();
                        
                        if (count($con_trd) == 0) {
                       
                         } else {
                            $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                            $respuesta = $respuesta . "El campo Codigo TRD de la fila " . $incremental . " ya existe</br>";
                        }
                    }

                    if ($j == $cod_orga) {

                         $con_orga = DB::table('SID_ORGA')
                                ->where('SID_ORGA.COD_ORGA', '=', $val[$j])
                                ->get();

                        if (count($con_orga) > 0) {
                       
                         } else {
                            $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                            $respuesta = $respuesta . "El campo Codigo Oficina Productora de la fila " . $incremental . " no coincide </br>";
                        }
                        
                    }
                    if ($j == $cod_seri) {

                        $con_seri = DB::table('SID_SERI')
                                ->where('SID_SERI.COD_SERI', '=', $val[$j])
                                ->get();
                       
                        if (count($con_seri) > 0) {
                            $seriebuscar  = $val[$j];
                       
                         } else {
                            $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                            $seriebuscar  = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                            $respuesta = $respuesta . "El campo Codigo Serie de la fila " . $incremental . " no coincide</br>";
                        }

                    }
                    if ($j == $cod_subs) {

                        $con_ccd = DB::table('SID_CCD')
                                ->where('SID_CCD.COD_SERI', '=', $seriebuscar)
                                ->where('SID_CCD.COD_SUBS', '=', $val[$j])
                                ->get();
                        if (count($con_ccd)> 0) {
                            $subseriebuscar = $val[$j];
                         } else {
                            $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                            $subseriebuscar = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                            $respuesta = $respuesta . "El campo Codigo Subserie de la fila " . $incremental . " no coincide</br>";
                        }
                        
                    }

                    if($j == $ban_ct)
                    {
                        if($val[$j] == '0' || $val[$j] == '1')
                        {

                        }
                        else
                        {
                            $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                            $respuesta = $respuesta . "El campo Conservación Total  de la fila " . $incremental . " debe ser '0' o '1'</br>";
                        }

                    }
                    if($j == $ban_e)
                    {
                        if($val[$j] == '0' || $val[$j] == '1')
                        {

                        }
                        else
                        {
                            $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                            $respuesta = $respuesta . "El campo Eliminación   de la fila " . $incremental . " debe ser '0' o '1'</br>";
                        }
                        
                    }
                    if($j == $ban_m)
                    {
                        if($val[$j] == '0' || $val[$j] == '1')
                        {

                        }
                        else
                        {
                            $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                            $respuesta = $respuesta . "El campo Microfilmación de la fila " . $incremental . " debe ser '0' o '1'</br>";
                        }
                        
                    }
                    if($j == $ban_s)
                    {
                        if($val[$j] == '0' || $val[$j] == '1')
                        {

                        }
                        else
                        {
                            $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                            $respuesta = $respuesta . "El campo Selección de la fila " . $incremental . " debe ser '0' o '1'</br>";
                        }
                        
                    }
                    if($j == $arc_gest)
                    {
                        if (is_numeric($val[$j])) {
                        }
                        else
                        {
                            $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                            $respuesta = $respuesta . "El campo Gestión de la fila " . $incremental . " no puede estar en blanco</br>";
                        }
                    }
                    if($j == $arc_cent)
                    {
                        if (is_numeric($val[$j])) {
                        }
                        else
                        {
                            $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                            $respuesta = $respuesta . "El campo Central de la fila " . $incremental . " no puede estar en blanco</br>";
                        }

                    }

                }
                if($j != $cod_seri && $j != $cod_subs)
                {
                    if ($val[$j] == 'null') {
                        $data = $data . "" . $val[$j] . "";
                    } else {
                        $data = $data . "'" . utf8_encode($val[$j]) . "'";
                    }
                }
                if ($j == count($val) - 1) {
                    $ccd = $seriebuscar .'.'. $subseriebuscar;
                    $usuario = Auth::user()->COD_USUA;
                    $fecha = strftime( "%Y-%m-%d", time() );
                    $hora = strftime( "%H:%M:%S", time() );
                    $data = $data . ",'".$ccd."', 'A', '".$usuario."', '".$fecha."', '".$hora."')";
                } else {
                    if($j != $cod_seri && $j != $cod_subs)
                    {
                        $data =  $data . ",";
                    }
                }
            }
            $datosinsert[$numerovecto] = $data;
           
            $numerovecto++;
        }
       
   
        if($respuesta == null)
        {
            //insertar datos del archivo.
            DB::beginTransaction();
            try {
                    for($id=0; $id < count($datosinsert); $id++)
                    {
                        $sql = $insert . $datosinsert[$id] . ';';
                        DB::insert($sql);
                    }
                DB::commit();
            } catch (\Illuminate\Database\QueryException $ex) {
                DB::rollback();
                $errorSQl = $ex->getMessage();
            }

            //dd($errorSQl);
            if ($errorSQl != null) {
                if ($respuesta == null) {
                    $respuesta = "Error desconocido, el archivo no cumple con el formato";
                }
                Flash::warning($errorSQl);
                return redirect()->route('trd.cargararchivo');
            } else {
                Flash::success("Se cargó correctamente el archivo");
                return redirect()->route('trd.index');
            }
        }
        else
        {
            Flash::warning($respuesta);
            return redirect()->route('trd.cargararchivo');
        }


    } 

    public function buscarfuid(Request $request)
    {
        $trd = SID_FUID::where('COD_TRD', '=', $request->COD_TRD)->get(); 
        echo '<option value="" selected>Seleccione una opcion</option>'; 
        foreach ($trd as $c ){
             echo '<option value="'.$c->NUM_REGI.'" >'.$c->NUM_ORDE.' - ' .$c->NOM_ASUN. '</option>';
        }
    }

    public function datostrd(Request $request)
    {
       $trd = SID_FUID::where('NUM_REGI', '=', $request->NUM_REGI)->get();  
       return json_encode($trd[0]);
    }
}
