<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
use App\SID_PRES;
use App\SID_PRES_DETA;
use App\SID_ORGA;
use App\SID_SERI;
use App\SID_CCD;
use Session;
use MBarryvdh\DomPDF\Facade;

class PrestamosController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	
        $prestamos = DB::table('SID_PRES')
            ->get();

           return view('prestamos.index')
            ->with('prestamos', $prestamos);
    }
    public function create()
    {

    }

    public function prestamo(Request $request)
    {
        $encabezado = null;

        $datos = null;
        if($request->proceso == "A")
        {
            date_default_timezone_set('America/Bogota');
            $HOR_ACTU = strftime( "%H:%M:%S", time() );
            Session::put('prestamo', $HOR_ACTU );
            Session::put('datos', null );
            Session::put('encabezado', null );
               
        }
        else
        {


            $datos = Session::get('datos');

            $encabezado = Session::get('encabezado');
            $desc_caja = null;
            if($request->SID_CAJA_C == "Completa")
            {   
                $desc_caja = "Caja Completa";
            }
            else
            {
                $desc_caja = $request->SID_CAJA;
            }
            $codtrd = null;
            if($request->COD_SUBS == null)
            {
                $codtrd = $request->COD_ORGA . '.' . $request->COD_SERI ;
            }
            else
            {
                $codtrd = $request->COD_ORGA . '.' . $request->COD_SERI . '.' . $request->COD_SUBS;
            }

            $array = array("COD_ORGA" => $request->COD_ORGA,
                          "COD_TRD" => $codtrd ,
                          "COD_SERI" => $request->COD_SERI,
                          "COD_SUBS" => $request->COD_SUBS,
                          "SID_CAJA" => $desc_caja,
                          "SID_CARP" => $request->SID_CARP,
                          "SID_CONT" => $request->SID_CONT,
                          "SID_TIPO" => $request->SID_TIPO,
                          "FEC_SOLI" => $request->FEC_SOLI,
                          "SID_OBSE" => $request->SID_OBSE);
            
            $secuencia = array($array);

            if($request->proceso == "D")
            {
                if($datos == null)
                {
                    $datoscompletos = $secuencia;   
                }
                else
                {
                    $datoscompletos = array_merge($datos, $secuencia);
                }
                
                Session::put('datos', $datoscompletos );
                $datos = Session::get('datos');
            }

             if($request->proceso == "E")
             {
       
                $datos = Session::get('datos');
                $i = intval($request->item);
                
                unset($datos[$i]);

                $datos[$i]= $array;

                Session::put('datos', $datos );

             }

        }
	   return view('prestamos.create')
	       ->with('encabezado', $encabezado)
           ->with('datos', $datos);

    }

    public function store(Request $request)
    {   
        

        $respuesta = null;
        $cod_expe = null;
        DB::beginTransaction();
        try {

            date_default_timezone_set('America/Bogota');
            $COD_USUA = Auth::user()->COD_USUA;
            $FEC_ACTU = strftime( "%Y-%m-%d", time() );
            $HOR_ACTU = strftime( "%H:%M:%S", time() );

            $fecha_solcitud = null;
            $fecha_entrega = null;
            $fecha_devolucion = null;
            
            if($request->FEC_ENTR !=  null )
            {
                $fecha_entrega =  substr($request->FEC_ENTR,6,4) .'-'.substr($request->FEC_ENTR,0,2) .'-'. substr($request->FEC_ENTR,3,2);
            }

            $max = $ccd = DB::table('SID_PRES')
            ->select(DB::raw('max(SID_PRES) as max'))
            ->get();
        
            $cod_expe = $max[0]->max + 1;



            $prestamo=SID_PRES::create([
                'SID_PRES'=> $cod_expe, 
                'FEC_ENTR'=> $fecha_entrega,
                'SID_OFCI'=> $request->SID_OFCI, 
                'NOM_SOLI'=> $request->NOM_SOLI,
                'DES_SOPO'=> $request->DES_SOPO, 
                'COD_USUA'=> $COD_USUA, 
                'FEC_ACTU'=> $FEC_ACTU, 
                'HOR_ACTU'=> $HOR_ACTU
            ]);

            $detalle = json_decode($request->detalle);
            $recorrer = $detalle->myRows;
            for($i = 0; $i < count($recorrer); $i++){
                $fecha_solcitud = null;
                if($recorrer[$i]->FEC_SOLI != null )
                {
                    $fecha_solcitud =  substr($recorrer[$i]->FEC_SOLI,6,4) .'-'.substr($recorrer[$i]->FEC_SOLI,0,2) .'-'. substr($recorrer[$i]->FEC_SOLI,3,2);
                }
                $inserta = SID_PRES_DETA::create([
                    'SID_PRES'=> $cod_expe, 
                    'COD_TRD' => $recorrer[$i]->COD_TDR, 
                    'SID_CAJA'=> $recorrer[$i]->SID_CAJA, 
                    'SID_CARP'=> $recorrer[$i]->SID_CARP,  
                    'SID_CONT'=> $recorrer[$i]->SID_CONT, 
                    'SID_TIPO'=> $recorrer[$i]->SID_TIPO,
                    'SID_OBSE'=> $recorrer[$i]->SID_OBSE, 
                    'FEC_SOLI'=> $fecha_solcitud
                    ]);

            }
            DB::commit();
           
        } catch(\Illuminate\Database\QueryException $ex){ 
            DB::rollback();
            $respuesta = $ex->getMessage(); 
        }
         

        if($respuesta ==null)
        {

            $respuesta = "OK";
            $deta = json_decode($request->detalle);
            $recorrer = $deta->myRows;        
            $view =  \View::make('pdf.prestamo', compact('request', 'recorrer', 'cod_expe'))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);
            $name = time();
            $filename =  public_path() ."/documentos/prestamo". $name. ".pdf";
            file_put_contents($filename, $pdf->stream('prestamo'));
            //$pdf->download('prestamo.pdf');
            return $name;
        }
        else
        {
            $respuesta = "error";
        }
       
        echo $respuesta;
    }


    public function destroy($id)
    {

    }

    public function edit($id)
    {   
        $prestamos = DB::table('SID_PRES')
            ->where('SID_PRES', '=', $id)
            ->get();

        $detalles = DB::table('SID_PRES_DETA')
            ->where('SID_PRES', '=', $id)
            ->get();

        return view('prestamos.view')
         ->with('prestamos', $prestamos[0])
         ->with('detalles', $detalles);

    }


    public function actualizar(Request $request)
    {

    }

    public function update(Request $request, $id)
    {

    }  
    public function detalle(Request $request)
    {
        $encabezado = array(   "SID_OFCI" => $request->SID_OFCI,
                "NOM_SOLI" => $request->NOM_SOLI,
                "DES_SOPO" => $request->DES_SOPO,
                "FEC_ENTR" => $request->FEC_ENTR);
        Session::put('encabezado', $encabezado );

        $series = SID_SERI::all();
        $orgas = SID_ORGA::all();
        return view('prestamos.detalle')
         ->with('series', $series)
         ->with('orgas', $orgas);
    }    

    public function editardetalle(Request $request)
    {
        $i = intval($request->item);
        $series = SID_SERI::all();
        $orgas = SID_ORGA::all();
        $datos = Session::get('datos');
        return view('prestamos.edit')
         ->with('series', $series)
         ->with('orgas', $orgas)
         ->with('datos', $datos[$i])
         ->with('item', $request->item);
    }

    public function actualizaritem(Request $request)
    {
         $i = intval($request->item);
         $datos = Session::get('datos');
         unset($datos[$i]);
         //$datos = array_values($datos); 
         Session::put('datos', $datos);
    }

    public function actualizaarray(Request $request)
    {

    }


}
