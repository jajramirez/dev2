<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\V_SID_TRD_DETA;
use App\SID_TRD;
use App\SID_ORGA;
use App\SID_TRD_DETA;
use App\SID_TMP_TRD;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
 
 
class ExcelController extends Controller {
 
 /**
 * Display a listing of the resource.
 *
 * @return Response
 */
 public function index($orga, $seri)
 {

        Excel::create('TRD_detalle', function($excel) use($orga, $seri) {
            

            $excel->sheet('Detalle TRD', function($sheet) use($orga, $seri) {

                $eliminar = SID_TMP_TRD::where('COD_USUA', '=', Auth::user()->COD_USUA)
                    ->delete();

                $trd = SID_TRD::select('COD_TRD', 'ARC_GEST', 'ARC_CENT', 'BAN_CT', 'BAN_E', 'BAN_M', 'BAN_S', 'TEX_OBSE', 'IND_ESTA');
                if($orga != "0")
                    $trd->where('COD_ORGA', '=', $orga);
                if($seri != "0")
                    $trd->where('COD_TRD', '=', $seri);

                $trd_res = $trd->get();

                

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
                        $valor = $deta->NUM_REGI .' - ' .$deta->NOM_DESC;
                        $datostrd ="'','','','','','','','".$valor."','','".Auth::user()->COD_USUA. "')";
                        DB::insert($insert.$datostrd);
                    }


                }

                $dataorga = SID_ORGA::where('COD_ORGA' , '=', $orga)->get();

                
               //$consulta = SID_TMP_TRD::select('TRD_TMP1 as Codigo', 'TRD_TMP2 as Gestion', 'TRD_TMP3 as Cent', 
                //        'TRD_TMP4 as CT', 'TRD_TMP5 as E', 'TRD_TMP6 as M',  'TRD_TMP6 as S',
                //        'TRD_TMP7 as Observaciones', 'TRD_TMP8 as Estado');

               $consulta = SID_TMP_TRD::select('TRD_TMP1', 'TRD_TMP2', 'TRD_TMP3', 
                        'TRD_TMP4', 'TRD_TMP5', 'TRD_TMP6', 'TRD_TMP7',
                        'TRD_TMP8', 'TRD_TMP9');
               $products= $consulta->where('COD_USUA', '=', Auth::user()->COD_USUA)->get();

               $sheet->row(1, array('', '', 'Tabla de Retención Documental'));

               $sheet->row(2, array('', ));
               $sheet->row(3, array('Entidad Productora','Escuela Administración Publica'));
               $sheet->row(4, array('Oficina Productora',$dataorga[0]->NOM_ORGA));
               $sheet->row(5, array('', ));
               $sheet->row(6, array('Código', 'Gestión', 'Cent', 'CT', 'E', 'M', 'S', 'Observaciones'));
               $i = 7   ;
               foreach ($products as $p) 
               {
                 $sheet->row($i, array($p->TRD_TMP1, $p->TRD_TMP2,$p->TRD_TMP3, $p->TRD_TMP4, $p->TRD_TMP5, $p->TRD_TMP6, $p->TRD_TMP7, $p->TRD_TMP8));
                 $i++;
               }
               $hoja = $i;
               

                $i++;
                $i++;
                $sheet->row($i, array('Conversiones'));
                $i++;
                $sheet->row($i, array('CT => Conservación Total'));
                $i++;
                $sheet->row($i, array('E => Eliminación','','','','Firma Responsable'));
                $i++;
                $sheet->row($i, array('M => Microfilmación'));
                $i++;
                $sheet->row($i, array('S => Selección'));
                  

               $sheet->setWidth('A', 12);
               $sheet->setWidth('D', 3);
               $sheet->setWidth('E', 3);
               $sheet->setWidth('F', 3);
               $sheet->setWidth('G', 3);
               $sheet->setWidth('H', 50);

               $sheet->setBorder('A6:H'.$hoja, 'thin');

               $sheet->setStyle(array(
                        'font' => array(
                        'name'      =>  'Arial',
                        'size'      =>  '10'
                    )
                ));

               $sheet->cells('A1:H6', function($cell) {
                    $cell->setFont(array(
                        'family'     => 'Arial',
                        'size'       => '10',
                        'bold'       =>  true
                    ));
               });                 
 
            });
        })->export('xls');
 
 }
}
