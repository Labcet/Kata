<?php

namespace App\Http\Controllers;

use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use App\Models\CasosPruebas;
use App\Models\Evidencias;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;
use Illuminate\Support\Facades\URL;

class PdfController extends Controller
{
    protected $fpdf;

    public function __construct(\App\Models\Pdf $fpdf)
    {
        $this->fpdf = $fpdf;
    }

    public function index($id) 
    {

        $testCaseData = CasosPruebas::find(decrypt($id));
        $evidenciasTestCase = Evidencias::where('cp_id', $testCaseData->id)->get();

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

        $this->fpdf->Cell(110,10,' RQ[000] Nombre de requerimiento ',1, 0 , 'L', $bander);
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
        $this->fpdf->Cell(15,10,utf8_decode('3.0'),1, 0 , 'C', $bander);

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
        if(strlen($testCaseData->funcionalidad) < 80){
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
        $this->fpdf->Cell(55, 6, utf8_decode('Aplicación/Módulo/Plataforma y/o'), 1, 1 , 'L', $bandera );
        $this->fpdf->SetXY(25, $yFuncionalidad+6);
        $this->fpdf->Cell(55, 6, utf8_decode('Funcionalidad: '), 'L,R,B', 1 , 'L', $bandera );
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
        $this->fpdf->Cell(105,7, utf8_decode(strtoupper($testCaseData->ola)). '   |    '.$testCaseData->fecha_certificacion,1, 0 , 'C', $bandera );

        $this->fpdf->Ln();
        $this->fpdf->SetX(25);
        $this->fpdf->SetFillColor(240,240,239);
        $this->fpdf->SetFont('helvetica','B',9);
        $this->fpdf->Cell(55,7,utf8_decode('Resultado de prueba  :'),1, 0 , 'L', $bandera );
           
        $this->fpdf->SetFillColor(255,255,255);//color de celda
        $this->fpdf->SetFont('helvetica','',9);
        $this->fpdf->Cell(105,7, utf8_decode(strtoupper($testCaseData->resultado_real)),1, 0 , 'C', $bandera );

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

        for($i=0; $i < count($evidenciasTestCase); $i++)
        {
            if($i == 0 && (count($pcond_cant) + count($pasos_cant)) > 10){
                
                $this->fpdf->AddPage();
                $flag = true;
            }

            else if($flag){

                if($i != 0 && $i % 2 == 0){

                    $this->fpdf->AddPage();
                }
            } else{
                if($i != 0 && $i % 2 != 0){

                    $this->fpdf->AddPage();
                }
            }

            //$this->fpdf->Cell(80,120, $this->fpdf->Image(URL::to('/public'.$evidenciasTestCase[$i]->path), $this->fpdf->GetX()+10, $this->fpdf->GetY()+5, 50, null), 1, 0, 'R');
            //$this->fpdf->Cell(80,120, $this->fpdf->Image('../public'.$evidenciasTestCase[$i]->path, $this->fpdf->GetX()+10, $this->fpdf->GetY()+5, 50, null), 1, 0, 'R');

            /* BASE 64 DECODE IMAGE */

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
            //$this->fpdf->Cell(90,120, utf8_decode($evidenciasTestCase[$i]->comentario), 1, 0, 'C', $bandera);
            $this->fpdf->Multicell(90,7, utf8_decode($evidenciasTestCase[$i]->comentario), 1, 0, 'C', $bandera);
            $this->fpdf->SetY(120);
            $this->fpdf->Ln();
        }

        //FOOTER

        $ban = false; //Para alternar el relleno
        $ban = !$ban;//Alterna el valor de la bandera


        $this->fpdf->Settextcolor(10, 10, 10);

        $this->fpdf->Ln(0);
        $this->fpdf->SetX(25);
        $this->fpdf->SetFillColor(240,240,239);
        $this->fpdf->SetFont('helvetica','B',9);
        $this->fpdf->Cell(70,7,utf8_decode('Decisión Product Owner '),1,0,'L', $ban);
        $this->fpdf->SetFillColor(255,255,255);
        $this->fpdf->SetFont('helvetica','',8);
        $this->fpdf->Cell(90,7,utf8_decode(strtoupper('<<Aprobado | Comentarios de criterios de aceptación>>')),1,0,'C','true');

        $this->fpdf->AliasNbPages();
        $this->fpdf->Output("I","CP[".$testCaseData->id."].pdf");
    }

    public function mergePDF($id)
    {

        $cps = CasosPruebas::where('user_id', decrypt($id))->get();

        // HEADER

        foreach ($cps as $testCaseData) {

            //$testCaseData = CasosPruebas::find($id);
            $evidenciasTestCase = Evidencias::where('cp_id', $testCaseData->id)->get();
        
            
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

            $this->fpdf->Cell(110,10,' RQ[000] Nombre de requerimiento ',1, 0 , 'L', $bander);
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
            $this->fpdf->Cell(15,10,utf8_decode('3.0'),1, 0 , 'C', $bander);

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
            if(strlen($testCaseData->funcionalidad) < 80){
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
            $this->fpdf->Cell(55, 6, utf8_decode('Aplicación/Módulo/Plataforma y/o'), 1, 1 , 'L', $bandera );
            $this->fpdf->SetXY(25, $yFuncionalidad+6);
            $this->fpdf->Cell(55, 6, utf8_decode('Funcionalidad: '), 'L,R,B', 1 , 'L', $bandera );
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
            $this->fpdf->Cell(105,7, utf8_decode(strtoupper($testCaseData->ola)). '   |    '.$testCaseData->fecha_certificacion,1, 0 , 'C', $bandera );

            $this->fpdf->Ln();
            $this->fpdf->SetX(25);
            $this->fpdf->SetFillColor(240,240,239);
            $this->fpdf->SetFont('helvetica','B',9);
            $this->fpdf->Cell(55,7,utf8_decode('Resultado de prueba  :'),1, 0 , 'L', $bandera );
               
            $this->fpdf->SetFillColor(255,255,255);//color de celda
            $this->fpdf->SetFont('helvetica','',9);
            $this->fpdf->Cell(105,7, utf8_decode(strtoupper($testCaseData->resultado_real)),1, 0 , 'C', $bandera );

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

            for($i=0; $i < count($evidenciasTestCase); $i++)
            {
                if($i == 0 && (count($pcond_cant) + count($pasos_cant)) > 10){
                    
                    $this->fpdf->AddPage();
                    $flag = true;
                }

                else if($flag){

                    if($i != 0 && $i % 2 == 0){

                        $this->fpdf->AddPage();
                    }
                } else{
                    if($i != 0 && $i % 2 != 0){

                        $this->fpdf->AddPage();
                    }
                }

                //$this->fpdf->Cell(80,120, $this->fpdf->Image(URL::to('/public'.$evidenciasTestCase[$i]->path), $this->fpdf->GetX()+10, $this->fpdf->GetY()+5, 50, null), 1, 0, 'R');
                //$this->fpdf->Cell(80,120, $this->fpdf->Image('../public'.$evidenciasTestCase[$i]->path, $this->fpdf->GetX()+10, $this->fpdf->GetY()+5, 50, null), 1, 0, 'R');

                /* BASE 64 DECODE IMAGE */

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
                $this->fpdf->Cell(90,120, utf8_decode($evidenciasTestCase[$i]->comentario), 1, 0, 'C', $bandera);
                $this->fpdf->Ln();
            }

            //FOOTER

            $ban = false; //Para alternar el relleno
            $ban = !$ban;//Alterna el valor de la bandera


            $this->fpdf->Settextcolor(10, 10, 10);

            $this->fpdf->Ln(0);
            $this->fpdf->SetX(25);
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

    public function generalPDF()
    {

        $cps = CasosPruebas::all();

        // HEADER

        foreach ($cps as $testCaseData) {

            //$testCaseData = CasosPruebas::find($id);
            $evidenciasTestCase = Evidencias::where('cp_id', $testCaseData->id)->get();
        
            
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

            $this->fpdf->Cell(110,10,' RQ[000] Nombre de requerimiento ',1, 0 , 'L', $bander);
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
            $this->fpdf->Cell(15,10,utf8_decode('3.0'),1, 0 , 'C', $bander);

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
            if(strlen($testCaseData->funcionalidad) < 80){
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
            $this->fpdf->Cell(55, 6, utf8_decode('Aplicación/Módulo/Plataforma y/o'), 1, 1 , 'L', $bandera );
            $this->fpdf->SetXY(25, $yFuncionalidad+6);
            $this->fpdf->Cell(55, 6, utf8_decode('Funcionalidad: '), 'L,R,B', 1 , 'L', $bandera );
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
            $this->fpdf->Cell(105,7, utf8_decode(strtoupper($testCaseData->ola)). '   |    '.$testCaseData->fecha_certificacion,1, 0 , 'C', $bandera );

            $this->fpdf->Ln();
            $this->fpdf->SetX(25);
            $this->fpdf->SetFillColor(240,240,239);
            $this->fpdf->SetFont('helvetica','B',9);
            $this->fpdf->Cell(55,7,utf8_decode('Resultado de prueba  :'),1, 0 , 'L', $bandera );
               
            $this->fpdf->SetFillColor(255,255,255);//color de celda
            $this->fpdf->SetFont('helvetica','',9);
            $this->fpdf->Cell(105,7, utf8_decode(strtoupper($testCaseData->resultado_real)),1, 0 , 'C', $bandera );

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

            for($i=0; $i < count($evidenciasTestCase); $i++)
            {
                if($i == 0 && (count($pcond_cant) + count($pasos_cant)) > 10){
                    
                    $this->fpdf->AddPage();
                    $flag = true;
                }

                else if($flag){

                    if($i != 0 && $i % 2 == 0){

                        $this->fpdf->AddPage();
                    }
                } else{
                    if($i != 0 && $i % 2 != 0){

                        $this->fpdf->AddPage();
                    }
                }

                //$this->fpdf->Cell(80,120, $this->fpdf->Image(URL::to('/public'.$evidenciasTestCase[$i]->path), $this->fpdf->GetX()+10, $this->fpdf->GetY()+5, 50, null), 1, 0, 'R');
                //$this->fpdf->Cell(80,120, $this->fpdf->Image('../public'.$evidenciasTestCase[$i]->path, $this->fpdf->GetX()+10, $this->fpdf->GetY()+5, 50, null), 1, 0, 'R');

                /* BASE 64 DECODE IMAGE */

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
                $this->fpdf->Cell(90,120, utf8_decode($evidenciasTestCase[$i]->comentario), 1, 0, 'C', $bandera);
                $this->fpdf->Ln();
            }

            //FOOTER

            $ban = false; //Para alternar el relleno
            $ban = !$ban;//Alterna el valor de la bandera


            $this->fpdf->Settextcolor(10, 10, 10);

            $this->fpdf->Ln(0);
            $this->fpdf->SetX(25);
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
