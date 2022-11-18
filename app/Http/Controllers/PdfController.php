<?php

namespace App\Http\Controllers;

use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use App\Models\CasosPruebas;
use App\Models\Evidencias;
use App\Models\Variable;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use PDF;

class PdfController extends Controller
{
    protected $fpdf;

    public function __construct(\App\Models\Pdf $fpdf)
    {
        $this->fpdf = $fpdf;
    }

    public function index($cp_id)
    {
        $ola = Variable::where('variable', 'Ola')->first();
        $testCaseData = DB::table('casos_prueba')
                        ->join('olas', 'casos_prueba.id', '=', 'olas.cp_id')
                        ->join('requerimientos', 'casos_prueba.requerimiento_id', '=', 'requerimientos.id')
                        ->select('casos_prueba.*', 'olas.cp_id', 'olas.num_ola', 'olas.estado', 'olas.fecha_ejecucion', 'requerimientos.nombre')
                        ->where([['casos_prueba.id', '=', $cp_id],['olas.num_ola', '=', $ola->valor]])
                        ->get();
        
        $evidenciasTestCase = Evidencias::where([['cp_id', '=', $cp_id],['ola', '=', $ola->valor]])->get();
        $total = Evidencias::where([['cp_id', '=', $cp_id],['ola', '=', $ola->valor]])->count();
        
        return view('pdf_index', compact('testCaseData', 'evidenciasTestCase', 'total'));
    }

    public function reporte_usuario($user_id)
    {
        $ola = Variable::where('variable', 'Ola')->first();
        $testCaseData = DB::table('casos_prueba')
                        ->join('olas', 'casos_prueba.id', '=', 'olas.cp_id')
                        ->join('requerimientos', 'casos_prueba.requerimiento_id', '=', 'requerimientos.id')
                        ->select('casos_prueba.*', 'olas.cp_id', 'olas.num_ola', 'olas.estado', 'olas.fecha_ejecucion', 'requerimientos.nombre')
                        ->where([['casos_prueba.user_id', '=', $user_id],['olas.num_ola', '=', $ola->valor]])
                        ->get();
        
        $evidenciasTestCase = [];

        foreach ($testCaseData as $key => $value) {
            
            $query = Evidencias::where([['cp_id', '=', $value->id],['ola', '=', $ola->valor]])->get();
            array_push($evidenciasTestCase, $query);
        }

        $total = [];

        foreach ($testCaseData as $key => $value) {
            
            $query2 = Evidencias::where([['cp_id', '=', $value->id],['ola', '=', $ola->valor]])->count();
            array_push($total, $query2);
        }
        
        return view('pdf', compact('testCaseData', 'evidenciasTestCase', 'total'));
    }

    /*public function createPDF($cp_id)
    {
        $ola = Variable::where('variable', 'Ola')->first();
        //Recuperar todos los productos de la db
        $testCaseData = DB::table('casos_prueba')
                        ->join('olas', 'casos_prueba.id', '=', 'olas.cp_id')
                        ->join('requerimientos', 'casos_prueba.requerimiento_id', '=', 'requerimientos.id')
                        ->select('casos_prueba.*', 'olas.cp_id', 'olas.num_ola', 'olas.estado', 'olas.fecha_ejecucion', 'requerimientos.nombre')
                        ->where([['casos_prueba.id', '=', $cp_id],['olas.num_ola', '=', $ola->valor]])
                        ->get();
        
        $evidenciasTestCase = Evidencias::where([['cp_id', '=', $cp_id],['ola', '=', $ola->valor]])->get();
        $total = Evidencias::where([['cp_id', '=', $cp_id],['ola', '=', $ola->valor]])->count();
        view()->share('testCaseData', $testCaseData);
        view()->share('evidenciasTestCase', $evidenciasTestCase);
        view()->share('total', $total);
        //$pdf = PDF::loadView('pdf_index', $evidenciasTestCase->toArray());
        $pdf = PDF::loadView('pdf_index');
        return $pdf->stream('archivo-prueba.pdf');
    }*/

    /*public function index($id) 
    {
        
        $ola = Variable::where('variable', 'Ola')->first();
        //$testCaseData = CasosPruebas::find(decrypt($id));
        $testCaseData = DB::table('casos_prueba')
                        ->join('olas', 'casos_prueba.id', '=', 'olas.cp_id')
                        ->join('requerimientos', 'casos_prueba.requerimiento_id', '=', 'requerimientos.id')
                        ->select('casos_prueba.*', 'olas.cp_id', 'olas.num_ola', 'olas.estado', 'olas.fecha_ejecucion', 'requerimientos.nombre')
                        ->where([['casos_prueba.id', '=', decrypt($id)],['olas.num_ola', '=', $ola->valor]])
                        ->get();
                    
        $evidenciasTestCase = Evidencias::where([['cp_id', '=', decrypt($id)],['ola', '=', $ola->valor]])->get();

        $bander = false; //Para alternar el relleno
        $bander = !$bander;//Alterna el valor de la bandera

        $this->fpdf->SetFont('helvetica','B',9);
        $this->fpdf->SetTextColor(0, 0, 0);

        // HEADER
        $this->fpdf->AddPage('P', 'A4');

        //$this->fpdf->Image('../public/upload/andes.jpg',13,8,22);
        //$this->fpdf->Image(URL::to('/public/upload/andes.jpg'),13,8,22);

        $this->fpdf->SetXY(15,10);
        $this->fpdf->SetDrawColor(0,0 ,0);
        $this->fpdf->SetFillColor(255,255,255);
        $this->fpdf->Cell(15,10, utf8_decode( 'Req:'),1, 0 , 'C', $bander );

        $this->fpdf->Cell(110,10, ' '.utf8_decode($testCaseData[0]->nombre),1, 0 , 'L', $bander);
        $this->fpdf->SetFillColor(255,255,255);
        // $this->fpdf->Cell(38,10, utf8_decode($testCaseData->fecha_certificacion),1, 0 , 'C', $bander );
        $pico = '../public/upload/andes2.jpg';
        $this->fpdf->Cell(55,20,$this->fpdf->Image($pico, $this->fpdf->GetX()+2, $this->fpdf->GetY()+3, 50, null, 'jpg'), 1, 0, 'R');

        //$this->fpdf->Cell(80,120, $this->fpdf->Image($pic, $this->fpdf->GetX()+10, $this->fpdf->GetY()+5, 50, null, 'png'), 1, 0, 'R');

        $this->fpdf->Ln();//Salto de línea para generar otra fila

        $this->fpdf->SetXY(15,20);   
        $this->fpdf->SetFillColor(255, 255, 255);
        $this->fpdf->Cell(15,10,utf8_decode( 'Doc:'),1, 0 , 'C', $bander );
        $this->fpdf->SetFillColor(255, 255, 255);
        $this->fpdf->Cell(80,10, utf8_decode(' Evidencia Pruebas de Certificación QA'),1, 0 , 'L', $bander );
        $this->fpdf->Cell(15,10,utf8_decode( 'Ver.'),1, 0 , 'C', $bander );
        $this->fpdf->SetFillColor(255,255,255);
        $this->fpdf->Cell(15,10,utf8_decode($testCaseData[0]->num_ola),1, 0 , 'C', $bander);

        //$this->fpdf->Cell(20,10,utf8_decode('Página'.$this->fpdf->PageNo().'/{nb}'),1, 0 , 'C', $bander);

        $this->fpdf->Ln();//Salto de línea para generar otra fila
        
        // BODY

        $this->fpdf->SetXY(25,37);
        $this->fpdf->SetFont('helvetica','B',12);
        $this->fpdf->SetFillColor(255, 255, 255);
        $this->fpdf->SetDrawColor(255, 255, 255);
        $this->fpdf->MultiCell(160,7,utf8_decode('Caso '.$testCaseData[0]->id.': '.$testCaseData[0]->nombre_completo.'.'));
        $this->fpdf->Ln();

        $yFuncionalidad = $this->fpdf->GetY();

        $bandera = false; //Para alternar el relleno
        $bandera = !$bandera;//Alterna el valor de la bandera

        $height = 6;
        if(strlen($testCaseData[0]->proceso) < 80){
            $height = 12;
        }
        $this->fpdf->SetXY(80, $yFuncionalidad);
        $this->fpdf->SetFont('helvetica','',9);
        $this->fpdf->SetDrawColor(0,0,0);
        $this->fpdf->MultiCell(105,6, utf8_decode($testCaseData[0]->dato_prueba),1, 1, 'L', $bandera );
        $height_funcionalidad = $this->fpdf->GetY();
        $ytipo = $this->fpdf->GetY();

        $this->fpdf->SetFillColor(240,240,239);
        $this->fpdf->SetXY(25, $yFuncionalidad);
        $this->fpdf->SetFont('helvetica','B',9);
        $this->fpdf->Cell(55, $height_funcionalidad - $yFuncionalidad, utf8_decode('Elemento o Dato de Prueba: '), 1, 1 , 'L', $bandera );
        //$this->fpdf->SetXY(25, $yFuncionalidad+6);
        //$this->fpdf->Cell(55, 6, utf8_decode('Funcionalidad: '), 'L,R,B', 1 , 'L', $bandera );
        $this->fpdf->SetFillColor(255,255,255);//color de celda

        $this->fpdf->Ln(0);
        //$this->fpdf->SetXY(25,55);
        $this->fpdf->SetXY(25, $ytipo);
        $this->fpdf->SetFillColor(240,240,239);
        $this->fpdf->Cell(55,7,utf8_decode('Tipo de Prueba:'),1, 0 , 'L', $bandera );
        $this->fpdf->SetFillColor(255,255,255);//color de celda
        $this->fpdf->Cell(105,7, 'PRUEBA '.utf8_decode(strtoupper($testCaseData[0]->tipo_prueba)),1, 0 , 'C', $bandera );

        $this->fpdf->Ln();
        $yprecondiciones_before = $this->fpdf->GetY();
        
        $pcond = explode('\n', $testCaseData[0]->precondiciones);
        $pcond_cant = explode('.', $testCaseData[0]->precondiciones);
        //$yprecondiciones_after = 0;
        $this->fpdf->SetFont('helvetica','',9);
        $border_precond = 'R,T';
        for ($i=0; $i < count($pcond); $i++) {

            if($i!=0){
                $border_precond = 'R';
            }
            $this->fpdf->SetX(80);
            //$this->fpdf->Ln();
            $this->fpdf->Multicell(105,7,utf8_decode($pcond[$i]),$border_precond,1,'L',$bandera);
            //$height += 7;
            $yprecondiciones_after = $this->fpdf->GetY();
        }
        //$yprecondiciones = $this->fpdf->GetY();
        $this->fpdf->SetXY(25,$yprecondiciones_before);
        $this->fpdf->SetFillColor(240,240,239);
        $this->fpdf->SetFont('helvetica','B',9);
        $this->fpdf->Cell(55,$yprecondiciones_after-$yprecondiciones_before,utf8_decode('Precondición:'),1, 0 , 'L', $bandera);
        $this->fpdf->SetFillColor(255,255,255);//color de celda

        $this->fpdf->Ln();
        $this->fpdf->SetX(25);
        $this->fpdf->SetFillColor(240,240,239);
        $this->fpdf->Cell(55,7,utf8_decode('Ola y fecha de certificación real:'),1, 0 , 'L', $bandera );
        $this->fpdf->SetFillColor(255,255,255);//color de celda
        // $this->fpdf->Cell(43,7, utf8_decode(strtoupper($testCaseData->ola)),1, 0 , 'C', $bandera );
        $this->fpdf->SetFillColor(224, 235, 255);
        // $this->fpdf->Cell(54,7,utf8_decode( 'FECHA DE CERTIFICACION'),1, 0 , 'C', $bandera );
        $this->fpdf->SetFillColor(255,255,255);//color de celda
        $this->fpdf->SetFont('helvetica','',9);
        $this->fpdf->Cell(105,7, utf8_decode(strtoupper($testCaseData[0]->num_ola)). '   |    '.$testCaseData[0]->fecha_ejecucion,1, 0 , 'C', $bandera );

        $this->fpdf->Ln();
        $this->fpdf->SetX(25);
        $this->fpdf->SetFillColor(240,240,239);
        $this->fpdf->SetFont('helvetica','B',9);
        $this->fpdf->Cell(55,7,utf8_decode('Resultado de prueba  :'),1, 0 , 'L', $bandera );
            
        $this->fpdf->SetFillColor(255,255,255);//color de celda
        $this->fpdf->SetFont('helvetica','',9);
        $this->fpdf->Cell(105,7, utf8_decode(strtoupper($testCaseData[0]->estado)),1, 0 , 'C', $bandera );

        $this->fpdf->Ln();
        $this->fpdf->SetX(25);
        $this->fpdf->SetFillColor(240,240,239);
        $this->fpdf->SetFont('helvetica','B',9);
        $this->fpdf->Cell(160,7,utf8_decode('Secuencia (Pasos):'),1, 0 , 'L', $bandera );

        $this->fpdf->Ln();
        //
        $this->fpdf->SetFillColor(255, 255, 255);
        $this->fpdf->SetFont('helvetica','',9);
        $pasos = explode('\n', $testCaseData[0]->pasos);
        $pasos_cant = explode('.', $testCaseData[0]->pasos);
        $border_pasos = 'R,T,L';
        
        for ($i=0; $i < count($pasos); $i++) {
            
            if($i!=0){
                $border_pasos = 'R,L';
            }

            if($i == count($pasos)-1){
                $border_pasos = 'R,L,B';
            }
            $this->fpdf->SetX(25);
            $this->fpdf->Multicell(160,7,utf8_decode($pasos[$i]),$border_pasos,1,'L',$bandera);
            //$pasos_count += 7;
        }

        //$this->fpdf->SetxY(15,266.9);
        //$this->fpdf->Cell(260,10,utf8_decode('Pág.'.$this->fpdf->PageNo().'  de {nb}'),0, 0 , 'C', $bander);
        // EVIDENCIAS

        $flag = false;
        $iniY = $this->fpdf->GetY();
        $y_ref = $this->fpdf->GetY();
        $fin_evidencias_y = $this->fpdf->GetY();

        if(count($evidenciasTestCase) != 0){
        
            $finY = $this->fpdf->GetY() + 120;
        } else {

            $finY = $this->fpdf->GetY();
        }

        for($i=0; $i < count($evidenciasTestCase); $i++)
        {
            if($i == 0 && (count($pcond_cant) + count($pasos_cant)) > 10){
                
                $this->fpdf->AddPage();
                $finY = $this->fpdf->GetY();
                $flag = true;
            }

            else if($flag){

                if($i != 0 && $i % 2 == 0){

                    $this->fpdf->AddPage();
                    $finY = $this->fpdf->GetY() + 120;
                }
                else {

                    $finY = $this->fpdf->GetY();
                }
            } else{
                if($i != 0 && $i % 2 != 0){

                    $this->fpdf->AddPage();
                    $finY = $this->fpdf->GetY();


                } else {

                    if($i != 0){

                        $finY = $this->fpdf->GetY() + 120;
                    } else {

                        $finY = $y_ref;
                    }
                }
            }

            //$this->fpdf->Cell(80,120, $this->fpdf->Image(URL::to('/public'.$evidenciasTestCase[$i]->path), $this->fpdf->GetX()+10, $this->fpdf->GetY()+5, 50, null), 1, 0, 'R');
            //$this->fpdf->Cell(80,120, $this->fpdf->Image('../public'.$evidenciasTestCase[$i]->path, $this->fpdf->GetX()+10, $this->fpdf->GetY()+5, 50, null), 1, 0, 'R');

            // BASE 64 DECODE IMAGE //

            $dataURI = $evidenciasTestCase[$i]->imagen;

            $img = explode(',',$dataURI,2)[1];
            $pic = 'data://text/plain;base64,'. $img;

            $type = substr($dataURI, 11, 3);
            $this->fpdf->SetX(25);

            if($type == "png"){

                //$this->fpdf->Cell(70,120, $this->fpdf->Image($pic, $this->fpdf->GetX()+10, $this->fpdf->GetY()+5, 50, null, 'png'), 0, 0, 'R');
                $this->fpdf->Image($pic, $this->fpdf->GetX()+10, $finY+5, 50, null, 'png');
            } else {

                //$this->fpdf->Cell(50,120, $this->fpdf->Image($pic, $this->fpdf->GetX()+10, $this->fpdf->GetY()+5, 50, null, 'jpg'), 0, 0, 'R');
                $this->fpdf->Image($pic, $this->fpdf->GetX()+10, $finY+5, 50, null, 'jpg');
            }

            $fin_evidencias_y = $this->fpdf->GetY();

            //$iniY = $this->fpdf->GetY();
            //$finY = $this->fpdf->GetY() + 120;
            $y_ref = $this->fpdf->GetY();
            $this->fpdf->SetX(95);
            
            if($evidenciasTestCase[$i]->comentario != null){

                $this->fpdf->Multicell(90,7, utf8_decode($evidenciasTestCase[$i]->comentario), 0, 0, 'C', $bandera);
            }
            $this->fpdf->Rect(95,$iniY,90,130);
        }
        
        //FOOTER

        $ban = false; //Para alternar el relleno
        $ban = !$ban;//Alterna el valor de la bandera

        $this->fpdf->Settextcolor(10, 10, 10);

        //$this->fpdf->setY($this->fpdf->getY() + 120);
        $this->fpdf->Ln(0);
        $this->fpdf->SetXY(25, $finY + 120);
        $this->fpdf->SetFillColor(240,240,239);
        $this->fpdf->SetFont('helvetica','B',9);
        $this->fpdf->Cell(70,7,utf8_decode('Decisión Product Owner '),1,0,'C', $ban);
        $this->fpdf->SetFillColor(255,255,255);
        $this->fpdf->SetFont('helvetica','',8);
        $this->fpdf->Cell(90,7,utf8_decode(strtoupper('<<Aprobado | Comentarios de criterios de aceptación>>')),1,0,'C','true');

        // CONFIG

        $this->fpdf->AliasNbPages();
        $this->fpdf->Output("I","REPORTE_GENERAL.pdf");
    }*/

    public function mergePDF($id)
    {
        $ola = Variable::where('variable', 'Ola')->first();

        $cps = DB::table('casos_prueba')
                ->join('olas', 'casos_prueba.id', '=', 'olas.cp_id')
                ->join('requerimientos', 'casos_prueba.requerimiento_id', '=', 'requerimientos.id')
                ->select('casos_prueba.*', 'num_ola', 'estado', 'fecha_ejecucion', 'requerimientos.nombre')
                ->where([['casos_prueba.user_id', '=', decrypt($id)],['olas.num_ola', '=', $ola->valor]])
                ->get();

        // HEADER

        foreach ($cps as $testCaseData) {

            //$testCaseData = CasosPruebas::find($id);
            $evidenciasTestCase = Evidencias::where([['cp_id', '=', $testCaseData->id],['ola', '=', $ola->valor]])->get(); 
            
            $bander = false; //Para alternar el relleno
            $bander = !$bander;//Alterna el valor de la bandera

            $this->fpdf->SetFont('helvetica','B',9);
            $this->fpdf->SetTextColor(0, 0, 0);

            // HEADER
            $this->fpdf->AddPage('P', 'A4');

            //$this->fpdf->Image('../public/upload/andes.jpg',13,8,22);
            //$this->fpdf->Image(URL::to('/public/upload/andes.jpg'),13,8,22);

            $this->fpdf->SetXY(15,10);
            $this->fpdf->SetDrawColor(0,0 ,0);
            $this->fpdf->SetFillColor(255,255,255);
            $this->fpdf->Cell(15,10, utf8_decode( 'Req:'),1, 0 , 'C', $bander );

            $this->fpdf->Cell(110,10, ' '.utf8_decode($testCaseData->nombre),1, 0 , 'L', $bander);
            $this->fpdf->SetFillColor(255,255,255);
            // $this->fpdf->Cell(38,10, utf8_decode($testCaseData->fecha_certificacion),1, 0 , 'C', $bander );
            $pico = '../public/upload/andes2.jpg';
            $this->fpdf->Cell(55,20,$this->fpdf->Image($pico, $this->fpdf->GetX()+2, $this->fpdf->GetY()+3, 50, null, 'jpg'), 1, 0, 'R');

            //$this->fpdf->Cell(80,120, $this->fpdf->Image($pic, $this->fpdf->GetX()+10, $this->fpdf->GetY()+5, 50, null, 'png'), 1, 0, 'R');

            $this->fpdf->Ln();//Salto de línea para generar otra fila

            $this->fpdf->SetXY(15,20);   
            $this->fpdf->SetFillColor(255, 255, 255);
            $this->fpdf->Cell(15,10,utf8_decode( 'Doc:'),1, 0 , 'C', $bander );
            $this->fpdf->SetFillColor(255, 255, 255);
            $this->fpdf->Cell(80,10, utf8_decode(' Evidencia Pruebas de Certificación QA'),1, 0 , 'L', $bander );
            $this->fpdf->Cell(15,10,utf8_decode( 'Ver.'),1, 0 , 'C', $bander );
            $this->fpdf->SetFillColor(255,255,255);
            $this->fpdf->Cell(15,10,utf8_decode($testCaseData->num_ola),1, 0 , 'C', $bander);

            //$this->fpdf->Cell(20,10,utf8_decode('Página'.$this->fpdf->PageNo().'/{nb}'),1, 0 , 'C', $bander);

            $this->fpdf->Ln();//Salto de línea para generar otra fila
          
            // BODY

            $this->fpdf->SetXY(25,37);
            $this->fpdf->SetFont('helvetica','B',12);
            $this->fpdf->SetFillColor(255, 255, 255);
            $this->fpdf->SetDrawColor(255, 255, 255);
            $this->fpdf->MultiCell(160,7,utf8_decode('Caso '.$testCaseData->id.': '.$testCaseData->nombre_completo.'.'));
            $this->fpdf->Ln();

            $yFuncionalidad = $this->fpdf->GetY();

            $bandera = false; //Para alternar el relleno
            $bandera = !$bandera;//Alterna el valor de la bandera

            $height = 6;
            if(strlen($testCaseData->proceso) < 80){
                $height = 12;
            }
            $this->fpdf->SetXY(80, $yFuncionalidad);
            $this->fpdf->SetFont('helvetica','',9);
            $this->fpdf->SetDrawColor(0,0,0);
            $this->fpdf->MultiCell(105,6, utf8_decode($testCaseData->dato_prueba),1, 1, 'L', $bandera );
            $height_funcionalidad = $this->fpdf->GetY();
            $ytipo = $this->fpdf->GetY();

            $this->fpdf->SetFillColor(240,240,239);
            $this->fpdf->SetXY(25, $yFuncionalidad);
            $this->fpdf->SetFont('helvetica','B',9);
            $this->fpdf->Cell(55, $height_funcionalidad - $yFuncionalidad, utf8_decode('Elemento o Dato de Prueba: '), 1, 1 , 'L', $bandera );
            //$this->fpdf->SetXY(25, $yFuncionalidad+6);
            //$this->fpdf->Cell(55, 6, utf8_decode('Funcionalidad: '), 'L,R,B', 1 , 'L', $bandera );
            $this->fpdf->SetFillColor(255,255,255);//color de celda

            $this->fpdf->Ln(0);
            //$this->fpdf->SetXY(25,55);
            $this->fpdf->SetXY(25, $ytipo);
            $this->fpdf->SetFillColor(240,240,239);
            $this->fpdf->Cell(55,7,utf8_decode('Tipo de Prueba:'),1, 0 , 'L', $bandera );
            $this->fpdf->SetFillColor(255,255,255);//color de celda
            $this->fpdf->Cell(105,7, 'PRUEBA '.utf8_decode(strtoupper($testCaseData->tipo_prueba)),1, 0 , 'C', $bandera );

            $this->fpdf->Ln();
            $yprecondiciones_before = $this->fpdf->GetY();
            
            $pcond = explode('\n', $testCaseData->precondiciones);
            $pcond_cant = explode('.', $testCaseData->precondiciones);
            //$yprecondiciones_after = 0;
            $this->fpdf->SetFont('helvetica','',9);
            $border_precond = 'R,T';
            for ($i=0; $i < count($pcond); $i++) {

                if($i!=0){
                    $border_precond = 'R';
                }
                $this->fpdf->SetX(80);
                //$this->fpdf->Ln();
                $this->fpdf->Multicell(105,7,utf8_decode($pcond[$i]),$border_precond,1,'L',$bandera);
                //$height += 7;
                $yprecondiciones_after = $this->fpdf->GetY();
            }
            //$yprecondiciones = $this->fpdf->GetY();
            $this->fpdf->SetXY(25,$yprecondiciones_before);
            $this->fpdf->SetFillColor(240,240,239);
            $this->fpdf->SetFont('helvetica','B',9);
            $this->fpdf->Cell(55,$yprecondiciones_after-$yprecondiciones_before,utf8_decode('Precondición:'),1, 0 , 'L', $bandera);
            $this->fpdf->SetFillColor(255,255,255);//color de celda

            $this->fpdf->Ln();
            $this->fpdf->SetX(25);
            $this->fpdf->SetFillColor(240,240,239);
            $this->fpdf->Cell(55,7,utf8_decode('Ola y fecha de certificación real:'),1, 0 , 'L', $bandera );
            $this->fpdf->SetFillColor(255,255,255);//color de celda
            // $this->fpdf->Cell(43,7, utf8_decode(strtoupper($testCaseData->ola)),1, 0 , 'C', $bandera );
            $this->fpdf->SetFillColor(224, 235, 255);
            // $this->fpdf->Cell(54,7,utf8_decode( 'FECHA DE CERTIFICACION'),1, 0 , 'C', $bandera );
            $this->fpdf->SetFillColor(255,255,255);//color de celda
            $this->fpdf->SetFont('helvetica','',9);
            $this->fpdf->Cell(105,7, utf8_decode(strtoupper($testCaseData->num_ola)). '   |    '.$testCaseData->fecha_ejecucion,1, 0 , 'C', $bandera );

            $this->fpdf->Ln();
            $this->fpdf->SetX(25);
            $this->fpdf->SetFillColor(240,240,239);
            $this->fpdf->SetFont('helvetica','B',9);
            $this->fpdf->Cell(55,7,utf8_decode('Resultado de prueba  :'),1, 0 , 'L', $bandera );
               
            $this->fpdf->SetFillColor(255,255,255);//color de celda
            $this->fpdf->SetFont('helvetica','',9);
            $this->fpdf->Cell(105,7, utf8_decode(strtoupper($testCaseData->estado)),1, 0 , 'C', $bandera );

            $this->fpdf->Ln();
            $this->fpdf->SetX(25);
            $this->fpdf->SetFillColor(240,240,239);
            $this->fpdf->SetFont('helvetica','B',9);
            $this->fpdf->Cell(160,7,utf8_decode('Secuencia (Pasos):'),1, 0 , 'L', $bandera );

            $this->fpdf->Ln();
            //
            $this->fpdf->SetFillColor(255, 255, 255);
            $this->fpdf->SetFont('helvetica','',9);
            $pasos = explode('\n', $testCaseData->pasos);
            $pasos_cant = explode('.', $testCaseData->pasos);
            $border_pasos = 'R,T,L';
            
            for ($i=0; $i < count($pasos); $i++) {
                
                if($i!=0){
                    $border_pasos = 'R,L';
                }

                if($i == count($pasos)-1){
                    $border_pasos = 'R,L,B';
                }
                $this->fpdf->SetX(25);
                $this->fpdf->Multicell(160,7,utf8_decode($pasos[$i]),$border_pasos,1,'L',$bandera);
                //$pasos_count += 7;
            }

            //$this->fpdf->SetxY(15,266.9);
            //$this->fpdf->Cell(260,10,utf8_decode('Pág.'.$this->fpdf->PageNo().'  de {nb}'),0, 0 , 'C', $bander);
            // EVIDENCIAS

            $flag = false;
            $iniY = $this->fpdf->GetY();

            if(count($evidenciasTestCase) != 0){
            
                $finY = $this->fpdf->GetY() + 120;
            } else {

                $finY = $this->fpdf->GetY();
            }

            for($i=0; $i < count($evidenciasTestCase); $i++)
            {
                if($i == 0 && (count($pcond_cant) + count($pasos_cant)) > 10){
                    
                    $this->fpdf->AddPage();
                    $finY = $this->fpdf->GetY() + 120;
                    $flag = true;
                }

                else if($flag){

                    if($i != 0 && $i % 2 == 0){

                        $this->fpdf->AddPage();
                        $finY = $this->fpdf->GetY() + 120;
                    }
                } else{
                    if($i != 0 && $i % 2 != 0){

                        $this->fpdf->AddPage();
                        $finY = $this->fpdf->GetY() + 120;
                    }
                }

                //$this->fpdf->Cell(80,120, $this->fpdf->Image(URL::to('/public'.$evidenciasTestCase[$i]->path), $this->fpdf->GetX()+10, $this->fpdf->GetY()+5, 50, null), 1, 0, 'R');
                //$this->fpdf->Cell(80,120, $this->fpdf->Image('../public'.$evidenciasTestCase[$i]->path, $this->fpdf->GetX()+10, $this->fpdf->GetY()+5, 50, null), 1, 0, 'R');

                // BASE 64 DECODE IMAGE //

                $dataURI = $evidenciasTestCase[$i]->imagen;

                $img = explode(',',$dataURI,2)[1];
                $pic = 'data://text/plain;base64,'. $img;

                $type = substr($dataURI, 11, 3);
                $this->fpdf->SetX(25);

                if($type == "png"){

                    $this->fpdf->Cell(70,120, $this->fpdf->Image($pic, $this->fpdf->GetX()+10, $this->fpdf->GetY()+5, 50, null, 'png'), 1, 0, 'R');
                } else {

                    $this->fpdf->Cell(50,120, $this->fpdf->Image($pic, $this->fpdf->GetX()+10, $this->fpdf->GetY()+5, 50, null, 'jpg'), 1, 0, 'R');
                }

                $iniY = $this->fpdf->GetY();
                //$finY = $this->fpdf->GetY() + 120;
                //$this->fpdf->Cell(90,120, utf8_decode($evidenciasTestCase[$i]->comentario), 1, 0, 'C', $bandera);
                $this->fpdf->Multicell(90,7, utf8_decode($evidenciasTestCase[$i]->comentario), 0, 0, 'C', $bandera);
                $this->fpdf->Rect(95,$iniY,90,120);
                //$this->fpdf->Ln();
                //$finY = $this->fpdf->GetY();
            }
            
            //FOOTER

            $ban = false; //Para alternar el relleno
            $ban = !$ban;//Alterna el valor de la bandera

            $this->fpdf->Settextcolor(10, 10, 10);

            $this->fpdf->Ln(0);
            $this->fpdf->SetXY(25, $finY);
            $this->fpdf->SetFillColor(240,240,239);
            $this->fpdf->SetFont('helvetica','B',9);
            $this->fpdf->Cell(70,7,utf8_decode('Decisión Product Owner '),1,0,'C', $ban);
            $this->fpdf->SetFillColor(255,255,255);
            $this->fpdf->SetFont('helvetica','',8);
            $this->fpdf->Cell(90,7,utf8_decode(strtoupper('<<Aprobado | Comentarios de criterios de aceptación>>')),1,0,'C','true');
        }
            // CONFIG

            $this->fpdf->AliasNbPages();
            $this->fpdf->Output("I","REPORTE_USUARIO.pdf");
    }

    public function generatePDF(Request $request)
    {
        if($request->user == 0){

            $cps = DB::table('casos_prueba')
                    ->join('olas', 'casos_prueba.id', '=', 'olas.cp_id')
                    ->join('requerimientos', 'casos_prueba.requerimiento_id', '=', 'requerimientos.id')
                    ->select('casos_prueba.*', 'olas.num_ola', 'olas.estado', 'fecha_ejecucion', 'requerimientos.nombre')
                    ->where([['olas.num_ola', '=', $request->ola]])
                    ->get();
        } else {

            $cps = DB::table('casos_prueba')
                    ->join('olas', 'casos_prueba.id', '=', 'olas.cp_id')
                    ->join('requerimientos', 'casos_prueba.requerimiento_id', '=', 'requerimientos.id')
                    ->select('casos_prueba.*', 'olas.num_ola', 'olas.estado', 'fecha_ejecucion', 'requerimientos.nombre')
                    ->where([['casos_prueba.user_id', '=', $request->user],['olas.num_ola', '=', $request->ola]])
                    ->get();
        }

        // HEADER

        foreach ($cps as $testCaseData) {

            //$testCaseData = CasosPruebas::find($id);
            $evidenciasTestCase = Evidencias::where([['cp_id', '=', $testCaseData->id],['ola', '=', $request->ola]])->get();
        
            
            $bander = false; //Para alternar el relleno
            $bander = !$bander;//Alterna el valor de la bandera

            $this->fpdf->SetFont('helvetica','B',9);
            $this->fpdf->SetTextColor(0, 0, 0);

            // HEADER
            $this->fpdf->AddPage('P', 'A4');

            //$this->fpdf->Image('../public/upload/andes.jpg',13,8,22);
            //$this->fpdf->Image(URL::to('/public/upload/andes.jpg'),13,8,22);

            $this->fpdf->SetXY(15,10);
            $this->fpdf->SetDrawColor(0,0 ,0);
            $this->fpdf->SetFillColor(255,255,255);
            $this->fpdf->Cell(15,10, utf8_decode( 'Req:'),1, 0 , 'C', $bander );

            $this->fpdf->Cell(110,10, ' '.utf8_decode($testCaseData->nombre),1, 0 , 'L', $bander);
            $this->fpdf->SetFillColor(255,255,255);
            // $this->fpdf->Cell(38,10, utf8_decode($testCaseData->fecha_certificacion),1, 0 , 'C', $bander );
            $pico = '../public/upload/andes2.jpg';
            $this->fpdf->Cell(55,20,$this->fpdf->Image($pico, $this->fpdf->GetX()+2, $this->fpdf->GetY()+3, 50, null, 'jpg'), 1, 0, 'R');

            //$this->fpdf->Cell(80,120, $this->fpdf->Image($pic, $this->fpdf->GetX()+10, $this->fpdf->GetY()+5, 50, null, 'png'), 1, 0, 'R');

            $this->fpdf->Ln();//Salto de línea para generar otra fila

            $this->fpdf->SetXY(15,20);   
            $this->fpdf->SetFillColor(255, 255, 255);
            $this->fpdf->Cell(15,10,utf8_decode( 'Doc:'),1, 0 , 'C', $bander );
            $this->fpdf->SetFillColor(255, 255, 255);
            $this->fpdf->Cell(80,10, utf8_decode(' Evidencia Pruebas de Certificación QA'),1, 0 , 'L', $bander );
            $this->fpdf->Cell(15,10,utf8_decode( 'Ver.'),1, 0 , 'C', $bander );
            $this->fpdf->SetFillColor(255,255,255);
            $this->fpdf->Cell(15,10,utf8_decode($testCaseData->num_ola),1, 0 , 'C', $bander);

            //$this->fpdf->Cell(20,10,utf8_decode('Página'.$this->fpdf->PageNo().'/{nb}'),1, 0 , 'C', $bander);

            $this->fpdf->Ln();//Salto de línea para generar otra fila
          
            // BODY

            $this->fpdf->SetXY(25,37);
            $this->fpdf->SetFont('helvetica','B',12);
            $this->fpdf->SetFillColor(255, 255, 255);
            $this->fpdf->SetDrawColor(255, 255, 255);
            $this->fpdf->MultiCell(160,7,utf8_decode('Caso '.$testCaseData->id.': '.$testCaseData->nombre_completo.'.'));
            $this->fpdf->Ln();

            $yFuncionalidad = $this->fpdf->GetY();

            $bandera = false; //Para alternar el relleno
            $bandera = !$bandera;//Alterna el valor de la bandera

            $height = 6;
            if(strlen($testCaseData->proceso) < 80){
                $height = 12;
            }
            $this->fpdf->SetXY(80, $yFuncionalidad);
            $this->fpdf->SetFont('helvetica','',9);
            $this->fpdf->SetDrawColor(0,0,0);
            $this->fpdf->MultiCell(105,6, utf8_decode($testCaseData->dato_prueba),1, 1, 'L', $bandera );
            $height_funcionalidad = $this->fpdf->GetY();
            $ytipo = $this->fpdf->GetY();

            $this->fpdf->SetFillColor(240,240,239);
            $this->fpdf->SetXY(25, $yFuncionalidad);
            $this->fpdf->SetFont('helvetica','B',9);
            $this->fpdf->Cell(55, $height_funcionalidad - $yFuncionalidad, utf8_decode('Elemento o Dato de Prueba: '), 1, 1 , 'L', $bandera );
            //$this->fpdf->SetXY(25, $yFuncionalidad+6);
            //$this->fpdf->Cell(55, 6, utf8_decode('Funcionalidad: '), 'L,R,B', 1 , 'L', $bandera );
            $this->fpdf->SetFillColor(255,255,255);//color de celda

            $this->fpdf->Ln(0);
            //$this->fpdf->SetXY(25,55);
            $this->fpdf->SetXY(25, $ytipo);
            $this->fpdf->SetFillColor(240,240,239);
            $this->fpdf->Cell(55,7,utf8_decode('Tipo de Prueba:'),1, 0 , 'L', $bandera );
            $this->fpdf->SetFillColor(255,255,255);//color de celda
            $this->fpdf->Cell(105,7, 'PRUEBA '.utf8_decode(strtoupper($testCaseData->tipo_prueba)),1, 0 , 'C', $bandera );

            $this->fpdf->Ln();
            $yprecondiciones_before = $this->fpdf->GetY();
            
            $pcond = explode('\n', $testCaseData->precondiciones);
            $pcond_cant = explode('.', $testCaseData->precondiciones);
            //$yprecondiciones_after = 0;
            $this->fpdf->SetFont('helvetica','',9);
            $border_precond = 'R,T';
            for ($i=0; $i < count($pcond); $i++) {

                if($i!=0){
                    $border_precond = 'R';
                }
                $this->fpdf->SetX(80);
                //$this->fpdf->Ln();
                $this->fpdf->Multicell(105,7,utf8_decode($pcond[$i]),$border_precond,1,'L',$bandera);
                //$height += 7;
                $yprecondiciones_after = $this->fpdf->GetY();
            }
            //$yprecondiciones = $this->fpdf->GetY();
            $this->fpdf->SetXY(25,$yprecondiciones_before);
            $this->fpdf->SetFillColor(240,240,239);
            $this->fpdf->SetFont('helvetica','B',9);
            $this->fpdf->Cell(55,$yprecondiciones_after-$yprecondiciones_before,utf8_decode('Precondición:'),1, 0 , 'L', $bandera);
            $this->fpdf->SetFillColor(255,255,255);//color de celda

            $this->fpdf->Ln();
            $this->fpdf->SetX(25);
            $this->fpdf->SetFillColor(240,240,239);
            $this->fpdf->Cell(55,7,utf8_decode('Ola y fecha de certificación real:'),1, 0 , 'L', $bandera );
            $this->fpdf->SetFillColor(255,255,255);//color de celda
            // $this->fpdf->Cell(43,7, utf8_decode(strtoupper($testCaseData->ola)),1, 0 , 'C', $bandera );
            $this->fpdf->SetFillColor(224, 235, 255);
            // $this->fpdf->Cell(54,7,utf8_decode( 'FECHA DE CERTIFICACION'),1, 0 , 'C', $bandera );
            $this->fpdf->SetFillColor(255,255,255);//color de celda
            $this->fpdf->SetFont('helvetica','',9);
            $this->fpdf->Cell(105,7, utf8_decode(strtoupper($testCaseData->num_ola)). '   |    '.$testCaseData->fecha_ejecucion,1, 0 , 'C', $bandera );

            $this->fpdf->Ln();
            $this->fpdf->SetX(25);
            $this->fpdf->SetFillColor(240,240,239);
            $this->fpdf->SetFont('helvetica','B',9);
            $this->fpdf->Cell(55,7,utf8_decode('Resultado de prueba  :'),1, 0 , 'L', $bandera );
               
            $this->fpdf->SetFillColor(255,255,255);//color de celda
            $this->fpdf->SetFont('helvetica','',9);
            $this->fpdf->Cell(105,7, utf8_decode(strtoupper($testCaseData->estado)),1, 0 , 'C', $bandera );

            $this->fpdf->Ln();
            $this->fpdf->SetX(25);
            $this->fpdf->SetFillColor(240,240,239);
            $this->fpdf->SetFont('helvetica','B',9);
            $this->fpdf->Cell(160,7,utf8_decode('Secuencia (Pasos):'),1, 0 , 'L', $bandera );

            $this->fpdf->Ln();
            //
            $this->fpdf->SetFillColor(255, 255, 255);
            $this->fpdf->SetFont('helvetica','',9);
            $pasos = explode('\n', $testCaseData->pasos);
            $pasos_cant = explode('.', $testCaseData->pasos);
            $border_pasos = 'R,T,L';
            
            for ($i=0; $i < count($pasos); $i++) {
                
                if($i!=0){
                    $border_pasos = 'R,L';
                }

                if($i == count($pasos)-1){
                    $border_pasos = 'R,L,B';
                }
                $this->fpdf->SetX(25);
                $this->fpdf->Multicell(160,7,utf8_decode($pasos[$i]),$border_pasos,1,'L',$bandera);
                //$pasos_count += 7;
            }

            //$this->fpdf->SetxY(15,266.9);
            //$this->fpdf->Cell(260,10,utf8_decode('Pág.'.$this->fpdf->PageNo().'  de {nb}'),0, 0 , 'C', $bander);
            // EVIDENCIAS

            $flag = false;
            $iniY = $this->fpdf->GetY();

            if(count($evidenciasTestCase) != 0){
            
                $finY = $this->fpdf->GetY() + 120;
            } else {

                $finY = $this->fpdf->GetY();
            }

            for($i=0; $i < count($evidenciasTestCase); $i++)
            {
                if($i == 0 && (count($pcond_cant) + count($pasos_cant)) > 10){
                    
                    $this->fpdf->AddPage();
                    $finY = $this->fpdf->GetY() + 120;
                    $flag = true;
                }

                else if($flag){

                    if($i != 0 && $i % 2 == 0){

                        $this->fpdf->AddPage();
                        $finY = $this->fpdf->GetY() + 120;
                    }
                } else{
                    if($i != 0 && $i % 2 != 0){

                        $this->fpdf->AddPage();
                        $finY = $this->fpdf->GetY() + 120;
                    }
                }

                //$this->fpdf->Cell(80,120, $this->fpdf->Image(URL::to('/public'.$evidenciasTestCase[$i]->path), $this->fpdf->GetX()+10, $this->fpdf->GetY()+5, 50, null), 1, 0, 'R');
                //$this->fpdf->Cell(80,120, $this->fpdf->Image('../public'.$evidenciasTestCase[$i]->path, $this->fpdf->GetX()+10, $this->fpdf->GetY()+5, 50, null), 1, 0, 'R');

                // BASE 64 DECODE IMAGE //

                $dataURI = $evidenciasTestCase[$i]->imagen;

                $img = explode(',',$dataURI,2)[1];
                $pic = 'data://text/plain;base64,'. $img;

                $type = substr($dataURI, 11, 3);
                $this->fpdf->SetX(25);

                if($type == "png"){

                    $this->fpdf->Cell(70,120, $this->fpdf->Image($pic, $this->fpdf->GetX()+10, $this->fpdf->GetY()+5, 50, null, 'png'), 1, 0, 'R');
                } else {

                    $this->fpdf->Cell(50,120, $this->fpdf->Image($pic, $this->fpdf->GetX()+10, $this->fpdf->GetY()+5, 50, null, 'jpg'), 1, 0, 'R');
                }

                $iniY = $this->fpdf->GetY();
                //$finY = $this->fpdf->GetY() + 120;
                //$this->fpdf->Cell(90,120, utf8_decode($evidenciasTestCase[$i]->comentario), 1, 0, 'C', $bandera);
                $this->fpdf->Multicell(90,7, utf8_decode($evidenciasTestCase[$i]->comentario), 0, 0, 'C', $bandera);
                $this->fpdf->Rect(95,$iniY,90,120);
                //$this->fpdf->Ln();
                //$finY = $this->fpdf->GetY();
            }
            
            //FOOTER

            $ban = false; //Para alternar el relleno
            $ban = !$ban;//Alterna el valor de la bandera


            $this->fpdf->Settextcolor(10, 10, 10);

            $this->fpdf->Ln(0);
            $this->fpdf->SetXY(25, $finY);
            $this->fpdf->SetFillColor(240,240,239);
            $this->fpdf->SetFont('helvetica','B',9);
            $this->fpdf->Cell(70,7,utf8_decode('Decisión Product Owner '),1,0,'C', $ban);
            $this->fpdf->SetFillColor(255,255,255);
            $this->fpdf->SetFont('helvetica','',8);
            $this->fpdf->Cell(90,7,utf8_decode(strtoupper('<<Aprobado | Comentarios de criterios de aceptación>>')),1,0,'C','true');
        }
            // CONFIG

            $this->fpdf->AliasNbPages();
            $this->fpdf->Output("I","REPORTE_GENERAL.pdf");
    }
}
