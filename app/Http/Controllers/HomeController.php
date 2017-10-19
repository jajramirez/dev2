<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
use App\SID_TRD;
use App\SID_FUID;
use App\SID_ORGA;
use App\SID_SERI;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        set_time_limit(0);
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('home');
    }

    /**
     *   visualiza lista fuid
     */
    public function fuid(Request $request) {

        if ($request->data == "1") {


            $busqueda = '&COD_ORGA=' . $request->COD_ORGA . '&COD_SERI=' . $request->COD_SERI . '&Anio=' . $request->Anio .
                    '&OBS_GEN1=' . $request->OBS_GEN1 . '&OBS_GEN2=' . $request->OBS_GEN2 . '&OBS_GEN3=' . $request->OBS_GEN3 .
                    '&OBS_GEN4=' . $request->OBS_GEN4 . '&Asunto=' . $request->Asunto . '&data=1';

            $orga_d = $request->COD_ORGA . '';
            $consulta = DB::table('V_SIS_FUID');

            if ($request->COD_ORGA != null) {
                $consulta->where('V_SIS_FUID.COD_ORGA', '=', $orga_d);
            }

            if ($request->COD_SERI != null) {
                $consulta->where('V_SIS_FUID.COD_CCD', 'like', "$request->COD_SERI%");
            }
            if ($request->Anio != null) {
                $consulta->whereYear('V_SIS_FUID.FEC_INIC', $request->Anio);
            }
            if ($request->OBS_GEN1 != null) {
                $consulta->where('V_SIS_FUID.OBS_GEN1', 'like', "%$request->OBS_GEN1%");
            }

            if ($request->OBS_GEN2 != null) {
                $consulta->where('V_SIS_FUID.OBS_GEN2', 'like', "%$request->OBS_GEN2%");
            }
            if ($request->OBS_GEN3 != null) {
                $consulta->where('V_SIS_FUID.OBS_GEN3', 'like', "%$request->OBS_GEN3%");
            }

            if ($request->OBS_GEN4 != null) {
                $consulta->where('V_SIS_FUID.OBS_GEN4', 'like', "%$request->OBS_GEN4%");
            }

            if ($request->Asunto != null) {
                $consulta->where('V_SIS_FUID.NOM_ASUN', 'like', "%$request->Asunto%");
            }

            if ($request->CON_BODE != null) {
                $consulta->where('V_SIS_FUID.CON_BODE', 'like', "%$request->CON_BODE%");
            }
            if ($request->FEC_TRAN != null) {
                $consulta->where('V_SIS_FUID.FEC_TRAN', 'like', "%$request->FEC_TRAN%");
            }
            if ($request->NUM_TRAN != null) {
                $consulta->where('V_SIS_FUID.NUM_TRAN', 'like', "%$request->NUM_TRAN%");
            }


            $datos = $consulta->get();
            //dd($datos);
            $i = 0;

            $info = null;
            foreach ($datos as $d) {
                $vec = explode(".", $d->COD_CCD);
                if (count($vec) == 1) {
                    $vec[1] = '';
                }

                $info[$i] = DB::table('SID_CCD')
                        ->select('NOM_SUBS')
                        ->where('COD_SERI', '=', $vec[0])
                        ->where('COD_SUBS', '=', $vec[1])
                        ->get();
                $i++;
            }
        } else {
            $datos = null;
            $info = null;
            $busqueda = null;
        }

        $orga = SID_ORGA::all();
        $seri = SID_SERI::all();

        if ($request->COD_SERI == null) {
            $codseri = null;
        } else {
            $codseri = $request->COD_SERI;
        }


        if ($request->COD_ORGA == null) {
            $codorga = null;
        } else {
            $codorga = $request->COD_ORGA;
        }


        return view('fuid.fuid')
                        ->with('datos', $datos)
                        ->with('info', $info)
                        ->with('secuencia', 0)
                        ->with('orga', $orga)
                        ->with('seri', $seri)
                        ->with('codseri', $codseri)
                        ->with('codorga', $codorga)
                        ->with('busqueda', $busqueda);
    }

    public function carga() {


        $campos = array('COD_ENTI', 'COD_TRD', 'NUM_REGI', 'NOM_ASUN', 'NUM_DOCU', 'FEC_INIC', 'FEC_FINA', 'NUM_CARP', 'NUM_TOMO', 'NUM_CAJA', 'NUM_INTE',
            'NUM_FOLI', 'BAN_DIGI', 'FRE_CONS', 'NOM_DIGI', 'NOM_ARCH', 'FEC_CREA', 'NUM_PAGI', 'TAM_ARCH', 'SOF_CAPT', 'VER_ARCH',
            'RES_ARCH', 'IDI_ARCH', 'ENT_ARCH', 'OBS_GEN1', 'OBS_GEN2', 'OBS_GEN3', 'OBS_GEN4');
        $long = count($campos);
        return view('fuid.carga')
                        ->with('campos', $campos)
                        ->with('long', $long);
    }

    public function store(Request $request) 
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
        $insert = "INSERT INTO SIS_FUID (`COD_ENTI`,`NUM_REGI`,";

        $fec_inic = null;
        $fec_fina = null;
        $fec_tran = null;
        $num_folio = null;
        $num_pagi = null;
        $tam_arch = null;
        $num_tran = null;
        $num_orde = null;
        $cod_trd = null;
        $num_carp = null;
        $num_inte = null;
        //$num_tomo = null;
        $num_caja = null;
        $con_bode = null;
        $fec_crea = null;
        $ent_arch = null;
        for ($i = 0; $i < count($val); $i++) {
            $val[$i] = str_replace("'", "", $val[$i]);
            $val[$i] = str_replace('"', "", $val[$i]);
            if ($val[$i] == 'FEC_INIC') {
                $fec_inic = $i;
            }
            if ($val[$i] == 'FEC_FINA') {
                $fec_fina = $i;
            }
            if ($val[$i] == 'FEC_TRAN') {
                $fec_tran = $i;
            }
            if ($val[$i] == 'NUM_FOLI') {
                $num_folio = $i;
            }
            if ($val[$i] == 'NUM_PAGI') {
                $num_pagi = $i;
            }
            if ($val[$i] == 'TAM_ARCH') {
                $tam_arch = $i;
            }
            if ($val[$i] == 'NUM_TRAN') {
                $num_tran = $i;
            }
            if ($val[$i] == 'NUM_ORDE') {
                $num_orde = $i;
            }
            if ($val[$i] == 'COD_TRD') {
                $cod_trd = $i;
            }
            if ($val[$i] == 'NUM_CAJA') {
                $num_caja = $i;
            }
            //if($val[$i] == 'NUM_TOMO'){
            //    $num_tomo = $i;
            //}
            if ($val[$i] == 'NUM_INTE') {
                $num_inte = $i;
            }
            if ($val[$i] == 'NUM_CARP') {
                $num_carp = $i;
            }
            if ($val[$i] == 'CON_BODE') {
                $con_bode = $i;
            }
            if ($val[$i] == 'FEC_CREA') {
                $fec_crea = $i;
            }
            if ($val[$i] == 'ENT_ARCH') {
                $ent_arch = $i;
            }


            $insert = $insert . '`' . $val[$i] . '`';
            if ($i == count($val) - 1) {
                $insert = $insert . ',`COD_ORGA`,`COD_CCD`) VALUES ';
            } else {
                $insert = $insert . ',';
            }
        }

        //dd($insert);
        $cod_orga = null;
        $cod_ccd = null;
        $datosinsert = array(count($csv)-2);

        $max = DB::table('SIS_FUID')
                ->select(DB::raw('max(NUM_REGI) as max'))
                ->get();
        $num_regi = $max[0]->max;
        $data = null;
        $incremental = 2;
        $numerovecto = 0;
        for ($i = 2; $i < count($csv); $i++) {
            $num_regi++;
            $data = "('01'," . $num_regi . ',';
            $incremental++;
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
            
            for ($j = 0; $j < count($val); $j++) 
            {

                $val[$j] = str_replace("'", "", $val[$j]);
                $val[$j] = str_replace('"', "", $val[$j]);

                if ($val[$j] == '') {
                    if ($j == $cod_trd) {
                        $respuesta = $respuesta . "El campo Codigo TRD de la fila " . $incremental . " no puede estar en blanco</br>";
                    }
                    $val[$j] = 'null';
                } else {
                    if ($j == $cod_trd) {
                        //validar que el codigo TRD exista en la base de datos
                        $con_trd = DB::table('SID_TRD')
                                ->where('SID_TRD.COD_TRD', '=', $val[$j])
                                ->get();
                        if (count($con_trd) == 0) {
                            $val[$j] = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';
                            $respuesta = $respuesta . "El campo Codigo TRD de la fila " . $incremental . " no coincide con ningún registro TRD</br>";
                        } else {
                            $cod_orga = $con_trd[0]->COD_ORGA;
                            $cod_ccd = $con_trd[0]->COD_CCD;
                            
                        }
                    }
                    if ($j == $ent_arch) {
                        if (strlen($val[$j]) > 1) {
                            $respuesta = $respuesta . "El campo Ent. Archivo  de la fila " . $incremental . " debe ser de un solo caracter.</br>";
                        }
                    }
                    if ($j == $fec_fina || $j == $fec_inic || $j == $fec_tran || $j == $fec_crea) {
                        $text = $val[$j];
                        $procesarfecha = "Y";
                        if (strlen($text) > 7 && strlen($text) < 11) {
                            
                        } else {
                            $procesarfecha = "N";
                        }
                        $pos = strpos($text, "/");
                        if ($pos === false) {
                            $pos = strpos($text, "-");
                            if ($pos === false) {
                                $procesarfecha = "N";
                            } else {
                                $sp = substr_count($text, '-');
                                if ($sp != 2) {
                                    $procesarfecha = "N";
                                }
                            }
                        } else {
                            $sp = substr_count($text, '/');
                            if ($sp != 2) {
                                $procesarfecha = "N";
                            }
                        }
                        if ($procesarfecha == "Y") {
                            $text = str_replace('/', '-', $text);
                            $fecha = strtotime($text);
                            $fecha2 = date("Y-m-d", $fecha);
                            $val[$j] = $fecha2;
                        } else {
                            $fecha2 = "ERROR";
                            $val[$j] = $fecha2;
                            if ($j == $fec_tran) {
                                $respuesta = $respuesta . "El campo Fecha Transferencia de la fila " . $incremental . " no cumple con el formato indicado</br>";
                            }
                            if ($j == $fec_fina) {
                                $respuesta = $respuesta . "El campo Fecha Inicial de la fila " . $incremental . " no cumple con el formato indicado</br>";
                            }
                            if ($j == $fec_inic) {
                                $respuesta = $respuesta . "El campo Fecha Final de la fila " . $incremental . " no cumple con el formato indicado</br>";
                            }
                            if ($j == $fec_crea) {
                                $respuesta = $respuesta . "El campo Fecha Creación de la fila " . $incremental . " no cumple con el formato indicado</br>";
                            }
                        }
                    }

                    //Validar los campos numericos

                    if ($j == $num_folio || $j == $num_pagi || $j == $tam_arch || $j == $num_tran || $j == $num_orde) {
                        if (is_numeric($val[$j])) {
                            
                        } else {
                            $val[$j] = "ERROR";
                            if ($j == $num_pagi) {
                                $respuesta = $respuesta . "El campo No. Paginas de la fila " . $incremental . " debe ser numerico</br>";
                            }
                            if ($j == $tam_arch) {
                                $respuesta = $respuesta . "El campo Tamaño Archivo de la fila " . $incremental . " debe ser numerico</br>";
                            }
                            if ($j == $num_tran) {
                                $respuesta = $respuesta . "El campo No. Transferencia de la fila " . $incremental . " debe ser numerico</br>";
                            }
                            if ($j == $num_orde) {
                                $respuesta = $respuesta . "El campo No. Orden de la fila " . $incremental . " debe ser numerico</br>";
                            }
                            if ($j == $num_folio) {
                                $respuesta = $respuesta . "El campo No. Folios de la fila " . $incremental . " debe ser numerico</br>";
                            }
                        }
                    }
                }
                if ($val[$j] == 'null') {
                    $data = $data . "" . $val[$j] . "";
                } else {
                    $data = $data . "'" . utf8_encode($val[$j]) . "'";
                }
                if ($j == count($val) - 1) {
                    $data = $data . ",'" . $cod_orga . "','" . $cod_ccd . "')";
                } else {
                    $data = $data . ",";
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
                return redirect()->route('home.carga');
            } else {
                Flash::success("Se cargó correctamente el archivo");
                return redirect()->route('home');
            }
        }
        else
        {
            Flash::warning($respuesta);
            return redirect()->route('home.carga');
        }

  
    }

}
