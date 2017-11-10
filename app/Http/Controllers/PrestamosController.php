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
        //dd($request);
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

            if($request->proceso == "D")
            {
                if($request->SID_CAJA_C == "Completa")
                {   
                    $array= array("CON_BODE" => $request->CON_BODE,
                              "SID_CARP" => "caja Completa",
                              "SID_TIPO" => $request->SID_TIPO,
                              "FEC_SOLI" => $request->FEC_SOLI,
                              "SID_OBSE" => $request->SID_OBSE);

                    $secuencia= array($array);

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
                else
                {

                    $cajas = $request->cajas;
                
                    for($i=0; $i < count($cajas); $i++)
                    {
                        $array[$i] = array("CON_BODE" => $request->CON_BODE,
                              "SID_CARP" => $cajas[$i],
                              "SID_TIPO" => $request->SID_TIPO,
                              "FEC_SOLI" => $request->FEC_SOLI,
                              "SID_OBSE" => $request->SID_OBSE);

                        $secuencia= array($array[$i]);

                       if($datos == null)
                        {
                            if($i == 0)
                            {
                                $datos = $secuencia;
                            } 
                            else
                            {
                                $datoscompletos = array_merge($datos, $secuencia);
                            }
                        }
                        else
                        {
                            $datoscompletos = array_merge($datos, $secuencia);
                            $datos = $datoscompletos;
                         
                        }

                    } 

                    Session::put('datos', $datoscompletos );
                    $datos = Session::get('datos');               
                }
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
                    'SID_CAJA'=> $recorrer[$i]->SID_CAJA, 
                    'SID_CARP'=> $recorrer[$i]->SID_CARP,  
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
            //$respuesta = "error";
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

    public function entrega($id)
    {
        $prestamos = DB::table('SID_PRES')
            ->where('SID_PRES', '=', $id)
            ->get();

        $detalles = DB::table('SID_PRES_DETA')
            ->where('SID_PRES', '=', $id)
            ->get();

        return view('prestamos.entrega')
         ->with('prestamos', $prestamos[0])
         ->with('detalles', $detalles)
         ->with('id', $id);
    }

    public function devolver(Request $request)
    {
        $fecha_entrega =  substr($request->FEC_DEV,6,4) .'-'.substr($request->FEC_DEV,0,2) .'-'. substr($request->FEC_DEV,3,2);
        $seri = SID_PRES::where('SID_PRES', '=', $request->id)
            ->update(['FEC_DEVOL' => $fecha_entrega]);

        //Flash::success("Se proceso  correctamente la devolución");
        //return redirect()->route('prestamo.index');

        $prestamos = DB::table('SID_PRES')
            ->where('SID_PRES', '=', $request->id)
            ->get();
        $detalles = DB::table('SID_PRES_DETA')
            ->where('SID_PRES', '=', $request->id)
            ->get();

        $prestamo = $prestamos[0];

        $recorrer = $detalles;   

       
        $view =  \View::make('pdf.devolucion', compact('prestamo', 'recorrer', 'fecha_entrega'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        $name = time();
        $filename =  public_path() ."/documentos/devolucion". $name. ".pdf";
        file_put_contents($filename, $pdf->stream('devolucion'));
        //$pdf->download('prestamo.pdf');
        return $name;
        
    }


}
