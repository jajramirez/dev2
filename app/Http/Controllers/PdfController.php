<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\V_SID_TRD_DETA;
use App\SID_TRD;
use App\SID_TRD_DETA;
use App\SID_TMP_TRD;
use App\SID_ORGA;
use App\SID_SERI;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use MBarryvdh\DomPDF\Facade;
 
 
class PdfController extends Controller {
 
    public function index()
    {
    $text = "2008-1-6";
    //$text = "1/9/2008";
    //$text = "13-12-2008";
    $procesarfecha = "Y";
    if(strlen($text) > 7 && strlen($text) <11  )
    {

    }
    else
    {
        $procesarfecha = "N";
    }

    $pos = strpos($text, "/");
    if($pos === false )
    {
        $pos = strpos($text, "-");
        if($pos === false )
        {
            $procesarfecha = "N";
        }
        else{
            $sp = substr_count($text, '-');
            if($sp != 2)
            {
                $procesarfecha = "N";
            }
        }
    }
    else
    { 
        $sp = substr_count($text, '-');
        if($sp != 2)
        {
            $procesarfecha = "N";
        }
    }
    if($procesarfecha == "Y")
    {
        $text = str_replace('/', '-', $text);
        $fecha=strtotime($text);
        $fecha2 = date("Y-m-d",$fecha);
    }
    else
    {
        $fecha2 = "ERROR";
    }
    

        $orga = SID_ORGA::all();
        $seri = SID_SERI::all();
        return view('pdf.generate')
            ->with('orga', $orga)
            ->with('seri', $seri);
    }
    public function trd($id, $id2)
    {


      $eliminar = SID_TMP_TRD::where('COD_USUA', '=', Auth::user()->COD_USUA)
                 ->delete();

        $trd = SID_TRD::select('COD_TRD', 'ARC_GEST', 'ARC_CENT', 'BAN_CT', 'BAN_E', 'BAN_M', 'BAN_S', 'TEX_OBSE', 'IND_ESTA');
        if($id != "0")
            $trd->where('COD_ORGA', '=', $id);
        if($id2 != "0")
            $trd->where('COD_TRD', '=', $id2);

        $trd_res = $trd->get();

	$orga = SID_ORGA::where('COD_ORGA' , '=', $id)->get();

        foreach ($trd_res as $reg) {

            if($reg->BAN_CT == '1')
                {
                    $reg->BAN_CT = 'SI';
                }
                else
                {
                    $reg->BAN_CT = '';
                }
                if($reg->BAN_E == '1')
                {
                    $reg->BAN_E = 'SI';
                }
                else
                {
                    $reg->BAN_E = '';
                }
                if($reg->BAN_M == '1')
                {
                    $reg->BAN_M = 'SI';
                }
                else
                {
                    $reg->BAN_M = '';
                }
                if($reg->BAN_S == '1')
                {
                    $reg->BAN_S = 'SI';
                }
                else
                {
                    $reg->BAN_S = '';
                }   
                $insert = 'INSERT INTO `SID_TMP_TRD`(`TRD_TMP1`, `TRD_TMP2`, `TRD_TMP3`, `TRD_TMP4`, `TRD_TMP5`, 
                        `TRD_TMP6`, `TRD_TMP7`, `TRD_TMP8`, `TRD_TMP9`, `COD_USUA`) VALUES (';
            
                $datostrd ="'".$reg->COD_TRD."','".$reg->ARC_GEST."','".$reg->ARC_CENT."','"
                        .$reg->BAN_CT."','".$reg->BAN_E."','".$reg->BAN_M."','"
                        .$reg->BAN_S."','".$reg->TEX_OBSE."','".$reg->IND_ESTA."','".Auth::user()->COD_USUA. "')";

                DB::insert($insert.$datostrd);                  
                $trddeta  = SID_TRD_DETA::select('NOM_DESC', 'NUM_REGI')
                        ->where('COD_TRD', '=', $reg->COD_TRD)
                        ->get();

                foreach ($trddeta as $deta) {
                    $insert = 'INSERT INTO `SID_TMP_TRD`(`TRD_TMP1`, `TRD_TMP2`, `TRD_TMP3`, `TRD_TMP4`, `TRD_TMP5`, 
                    `TRD_TMP6`, `TRD_TMP7`, `TRD_TMP8`, `TRD_TMP9`,`COD_USUA`) VALUES (';
                    $valor = $deta->NOM_DESC;
                    $datostrd ="'','','','','','','','".$valor."','','".Auth::user()->COD_USUA. "')";
                    DB::insert($insert.$datostrd);
                }
            }

                
            //$consulta = SID_TMP_TRD::select('TRD_TMP1 as Codigo', 'TRD_TMP2 as Gestion', 'TRD_TMP3 as Cent', 
            //           'TRD_TMP4 as CT', 'TRD_TMP4 as E', 'TRD_TMP5 as M', 'TRD_TMP6 as M', 'TRD_TMP7 as S',
            //            'TRD_TMP8 as Observaciones', 'TRD_TMP9 as Estado');

            $consulta = SID_TMP_TRD::select('TRD_TMP1', 'TRD_TMP2', 'TRD_TMP3', 
                        'TRD_TMP4', 'TRD_TMP5', 'TRD_TMP6', 'TRD_TMP7',
                        'TRD_TMP8', 'TRD_TMP9');
            $products= $consulta->where('COD_USUA', '=', Auth::user()->COD_USUA)->get();



        //dd($products);

        $view =  \View::make('pdf.invoice', compact('products', 'orga'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        //return $pdf->stream('invoice');

        //return view('pdf.invoice')->with('products', $products);
        return $pdf->download('trd.pdf');
    }


}
