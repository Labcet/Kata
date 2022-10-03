<?php

namespace App\Http\Controllers;

use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use App\Models\CasosPruebas;
use App\Models\Evidencias;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;

class PdfController extends Controller
{
    protected $fpdf;

    public function __construct()
    {
        $this->fpdf = new Fpdf;
    }

    public function index($id) 
    {

        $testCaseData = CasosPruebas::find(decrypt($id));
        $evidenciasTestCase = Evidencias::where('cp_id', $testCaseData->id)->get();

        // HEADER
        $this->fpdf->AddPage('P', 'A4');

        $this->fpdf->SetFont('helvetica','B',12);
        $this->fpdf->SetTextColor(0, 52, 98);

        $this->fpdf->Image('../public/upload/andes.jpg',13,8,22);

        $bander = false; //Para alternar el relleno
        $bander = !$bander;//Alterna el valor de la bandera

        $this->fpdf->SetXY(37,8);
        $this->fpdf->SetDrawColor(0,203 ,255);
        $this->fpdf->SetFillColor(255,255,255);
        $this->fpdf->Cell(92,11, utf8_decode( 'Estándares de Buenas Practicas'),1, 0 , 'C', $bander );

        $this->fpdf->Cell(28,11,'FECHA ',1, 0 , 'C', $bander);
        $this->fpdf->SetFillColor(255,255,255);
        $this->fpdf->Cell(38,11, utf8_decode($testCaseData->fecha_certificacion),1, 0 , 'C', $bander );


        $this->fpdf->Ln();//Salto de línea para generar otra fila

        $this->fpdf->SetXY(37,19);   
        $this->fpdf->SetFillColor(224, 235, 255);
        $this->fpdf->Cell(30,12,utf8_decode( 'CODIGO'),1, 0 , 'C', $bander );
        $this->fpdf->SetFillColor(255, 255, 255);
        $this->fpdf->Cell(62,12, '',1, 0 , 'C', $bander );
        $this->fpdf->Cell(28,12,utf8_decode( 'PÁGINA'),1, 0 , 'C', $bander );
        $this->fpdf->SetFillColor(255,255,255);
        $this->fpdf->Cell(38,12,utf8_decode('Página'.$this->fpdf->PageNo().'/{nb}'),1, 0 , 'C', $bander);

        $this->fpdf->Ln();//Salto de línea para generar otra fila
        $this->fpdf->SetDrawColor(255,40 ,120);
        $this->fpdf->SetLineWidth(0.8);
        $this->fpdf->Line(11,33,197,33);

        $this->fpdf->SetLineWidth(0.4);
        $this->fpdf->SetDrawColor(255,208 ,0);
        $this->fpdf->Line(11,34,197,34);
        $this->fpdf->Ln();

        // BODY

        $this->fpdf->SetXY(15,37);
        $this->fpdf->SetFont('helvetica','B',12);
        $this->fpdf->SetFillColor(255, 255, 255);
        $this->fpdf->SetDrawColor(255, 255, 255);
        $this->fpdf->write(7,utf8_decode('Caso '.$testCaseData->id.': '.$testCaseData->nombre));
        $this->fpdf->SetXY(10,55);
        $this->fpdf->SetFont('Arial','B',10);
        $this->fpdf->SetDrawColor(155,155,155);
        $this->fpdf->SetLineWidth(.3); //Gris tenue de cada fila
        $this->fpdf->SetTextColor(3, 3, 3); //Color del texto: Neg55

        $bandera = false; //Para alternar el relleno
        $bandera = !$bandera;//Alterna el valor de la bandera

        /*$this->fpdf->SetFillColor(224,235,255);
        $this->fpdf->Cell(85,14, utf8_decode('Aplicación/Módulo/ Plataforma y/o Funcionalidad: '),1, 0 , 'C', $bandera );
        $this->fpdf->SetFillColor(255,255,255);//color de celda*/
        $this->fpdf->SetX(95);
        $this->fpdf->MultiCell(105,7, utf8_decode($testCaseData->funcionalidad),1, 0 , 'C', $bandera );
        $height_funcionalidad = $this->fpdf->GetY();

        $this->fpdf->SetFillColor(224,235,255);
        $this->fpdf->SetXY(10,55);
        $this->fpdf->Cell(85, $height_funcionalidad-55, utf8_decode('Aplicación/Módulo/ Plataforma y/o Funcionalidad: '),1, 0 , 'C', $bandera );
        $this->fpdf->SetFillColor(255,255,255);//color de celda

        $this->fpdf->Ln();
        $this->fpdf->SetFillColor(224, 235, 255);
        $this->fpdf->Cell(85,7,utf8_decode( 'TIPO DE PRUEBA'),1, 0 , 'C', $bandera );
        $this->fpdf->SetFillColor(255,255,255);//color de celda
        $this->fpdf->Cell(105,7, utf8_decode(strtoupper($testCaseData->tipo_prueba)),1, 0 , 'C', $bandera );

        $this->fpdf->Ln();
        
        $pcond = explode(',', $testCaseData->precondiciones);
        $height = 0;

        for ($i=0; $i < count($pcond); $i++) {
            
            $this->fpdf->SetX(95);
            //$this->fpdf->Ln();
            $this->fpdf->Multicell(105,7,utf8_decode($pcond[$i]),1,0,'C',$bandera);
            $height += 7;
        }
        $this->fpdf->SetY($height_funcionalidad+7);
        $this->fpdf->SetFillColor(224, 235, 255);
        $this->fpdf->Cell(85,$height,utf8_decode('PRECONDICIÓN'),1, 0 , 'C', $bandera);
        $this->fpdf->SetFillColor(255,255,255);//color de celda

        $this->fpdf->Ln();
        $this->fpdf->SetFillColor(224, 235, 255);
        $this->fpdf->Cell(42,7,utf8_decode( 'OLA '),1, 0 , 'C', $bandera );
        $this->fpdf->SetFillColor(255,255,255);//color de celda
        $this->fpdf->Cell(43,7, utf8_decode(strtoupper($testCaseData->ola)),1, 0 , 'C', $bandera );
        $this->fpdf->SetFillColor(224, 235, 255);
        $this->fpdf->Cell(54,7,utf8_decode( 'FECHA DE CERTIFICACION'),1, 0 , 'C', $bandera );
        $this->fpdf->SetFillColor(255,255,255);//color de celda
        $this->fpdf->Cell(51,5.5, date('d/m/Y'),1, 0 , 'C', $bandera );

        $this->fpdf->Ln();
        $this->fpdf->SetFillColor(224, 235, 255);
        $this->fpdf->Cell(85,7,utf8_decode( 'RESULTADO DE PRUEBA'),1, 0 , 'C', $bandera );
        $this->fpdf->SetFillColor(255,255,255);//color de celda
        $this->fpdf->Cell(105,7, utf8_decode(strtoupper($testCaseData->resultado)),1, 0 , 'C', $bandera );

        $this->fpdf->Ln();  
        $this->fpdf->SetFillColor(224, 235, 255);
        $this->fpdf->Cell(190,7,utf8_decode('SECUENCIA DE PASOS'),1, 0 , 'C', $bandera );

        $this->fpdf->Ln();
        $this->fpdf->SetFillColor(255, 255, 255);

        $pasos = explode(',', $testCaseData->pasos);
        $pasos_count = 0;

        for ($i=0; $i < count($pasos); $i++) {
            
            //$this->fpdf->SetX(95);
            $this->fpdf->Multicell(190,7,"Paso ".($i+1).": ".utf8_decode($pasos[$i]),1,0,'C',$bandera);
            $pasos_count += 7;
        }

        // EVIDENCIAS

        $flag = false;

        for($i=0; $i < count($evidenciasTestCase); $i++)
        {
            if($i == 0 && (count($pcond)+count($pasos)) > 10){
                
                $this->fpdf->AddPage();
                $flag = true;
            }

            if($flag){

                if($i != 0 && $i % 2 == 0){

                    $this->fpdf->AddPage();
                }
            } else{
                if ($i != 0 && $i % 2 != 0){

                    $this->fpdf->AddPage();
                }
            }

            $this->fpdf->Cell(80,120, $this->fpdf->Image('../public'.$evidenciasTestCase[$i]->path, $this->fpdf->GetX()+10, $this->fpdf->GetY()+5, 50, null), 1, 0, 'R');
            $this->fpdf->Cell(110,120, utf8_decode($evidenciasTestCase[$i]->comentario), 1, 0, 'C', $bandera);
            $this->fpdf->Ln();
        }

        //FOOTER

        $ban = false; //Para alternar el relleno
        $ban = !$ban;//Alterna el valor de la bandera


        $this->fpdf->Settextcolor(10, 10, 10);

        $this->fpdf->Ln(0);
        $this->fpdf->Cell(80,8,utf8_decode('Resultado de caso de prueba: '),1,0,'C', $ban);

        $this->fpdf->Cell(110,8,utf8_decode(strtoupper($testCaseData->resultado)),1,0,'C','true');

        // CONFIG

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
        
            $this->fpdf->AddPage('P', 'A4');

            $this->fpdf->SetFont('helvetica','B',12);
            $this->fpdf->SetTextColor(0, 52, 98);

            $this->fpdf->Image('../public/upload/andes.jpg',13,8,22);

            $bander = false; //Para alternar el relleno
            $bander = !$bander;//Alterna el valor de la bandera

            $this->fpdf->SetXY(37,8);
            $this->fpdf->SetDrawColor(0,203 ,255);
            $this->fpdf->SetFillColor(255,255,255);
            $this->fpdf->Cell(92,11, utf8_decode( 'Estándares de Buenas Practicas'),1, 0 , 'C', $bander );

            $this->fpdf->Cell(28,11,'FECHA ',1, 0 , 'C', $bander);
            $this->fpdf->SetFillColor(255,255,255);
            $this->fpdf->Cell(38,11, utf8_decode($testCaseData->fecha_certificacion),1, 0 , 'C', $bander );


            $this->fpdf->Ln();//Salto de línea para generar otra fila

            $this->fpdf->SetXY(37,19);   
            $this->fpdf->SetFillColor(224, 235, 255);
            $this->fpdf->Cell(30,12,utf8_decode( 'CODIGO'),1, 0 , 'C', $bander );
            $this->fpdf->SetFillColor(255, 255, 255);
            $this->fpdf->Cell(62,12, '',1, 0 , 'C', $bander );
            $this->fpdf->Cell(28,12,utf8_decode( 'PÁGINA'),1, 0 , 'C', $bander );
            $this->fpdf->SetFillColor(255,255,255);
            $this->fpdf->Cell(38,12,utf8_decode('Página'.$this->fpdf->PageNo().'/{nb}'),1, 0 , 'C', $bander);

            $this->fpdf->Ln();//Salto de línea para generar otra fila
            $this->fpdf->SetDrawColor(255,40 ,120);
            $this->fpdf->SetLineWidth(0.8);
            $this->fpdf->Line(11,33,197,33);

            $this->fpdf->SetLineWidth(0.4);
            $this->fpdf->SetDrawColor(255,208 ,0);
            $this->fpdf->Line(11,34,197,34);
            $this->fpdf->Ln();

            // BODY

            $this->fpdf->SetXY(15,37);
            $this->fpdf->SetFont('helvetica','B',12);
            $this->fpdf->SetFillColor(255, 255, 255);
            $this->fpdf->SetDrawColor(255, 255, 255);
            $this->fpdf->write(7,utf8_decode('Caso '.$testCaseData->id.': '.$testCaseData->nombre));
            $this->fpdf->SetXY(10,55);
            $this->fpdf->SetFont('Arial','B',10);
            $this->fpdf->SetDrawColor(155,155,155);
            $this->fpdf->SetLineWidth(.3); //Gris tenue de cada fila
            $this->fpdf->SetTextColor(3, 3, 3); //Color del texto: Neg55

            $bandera = false; //Para alternar el relleno
            $bandera = !$bandera;//Alterna el valor de la bandera

            $this->fpdf->SetX(95);
            $this->fpdf->MultiCell(105,7, utf8_decode($testCaseData->funcionalidad),1, 0 , 'C', $bandera );
            $height_funcionalidad = $this->fpdf->GetY();

            $this->fpdf->SetFillColor(224,235,255);
            $this->fpdf->SetXY(10,55);
            $this->fpdf->Cell(85, $height_funcionalidad-55, utf8_decode('Aplicación/Módulo/ Plataforma y/o Funcionalidad: '),1, 0 , 'C', $bandera );
            $this->fpdf->SetFillColor(255,255,255);//color de celda

            $this->fpdf->Ln();
            $this->fpdf->SetFillColor(224, 235, 255);
            $this->fpdf->Cell(85,7,utf8_decode( 'TIPO DE PRUEBA'),1, 0 , 'C', $bandera );
            $this->fpdf->SetFillColor(255,255,255);//color de celda
            $this->fpdf->Cell(105,7, utf8_decode(strtoupper($testCaseData->tipo_prueba)),1, 0 , 'C', $bandera );

            $this->fpdf->Ln();
            
            $pcond = explode(',', $testCaseData->precondiciones);
            $height = 0;

            for ($i=0; $i < count($pcond); $i++) {
                
                $this->fpdf->SetX(95);
                //$this->fpdf->Ln();
                $this->fpdf->Multicell(105,7,utf8_decode($pcond[$i]),1,0,'C',$bandera);
                $height += 7;
            }
            $this->fpdf->SetY($height_funcionalidad+7);
            $this->fpdf->SetFillColor(224, 235, 255);
            $this->fpdf->Cell(85,$height,utf8_decode('PRECONDICIÓN'),1, 0 , 'C', $bandera);
            $this->fpdf->SetFillColor(255,255,255);//color de celda

            $this->fpdf->Ln();
            $this->fpdf->SetFillColor(224, 235, 255);
            $this->fpdf->Cell(42,7,utf8_decode( 'OLA '),1, 0 , 'C', $bandera );
            $this->fpdf->SetFillColor(255,255,255);//color de celda
            $this->fpdf->Cell(43,7, utf8_decode(strtoupper($testCaseData->ola)),1, 0 , 'C', $bandera );
            $this->fpdf->SetFillColor(224, 235, 255);
            $this->fpdf->Cell(54,7,utf8_decode( 'FECHA DE CERTIFICACION'),1, 0 , 'C', $bandera );
            $this->fpdf->SetFillColor(255,255,255);//color de celda
            $this->fpdf->Cell(51,5.5, date('d/m/Y'),1, 0 , 'C', $bandera );

            $this->fpdf->Ln();
            $this->fpdf->SetFillColor(224, 235, 255);
            $this->fpdf->Cell(85,7,utf8_decode( 'RESULTADO DE PRUEBA'),1, 0 , 'C', $bandera );
            $this->fpdf->SetFillColor(255,255,255);//color de celda
            $this->fpdf->Cell(105,7, utf8_decode(strtoupper($testCaseData->resultado)),1, 0 , 'C', $bandera );

            $this->fpdf->Ln();  
            $this->fpdf->SetFillColor(224, 235, 255);
            $this->fpdf->Cell(190,7,utf8_decode('SECUENCIA DE PASOS'),1, 0 , 'C', $bandera );

            $this->fpdf->Ln();
            $this->fpdf->SetFillColor(255, 255, 255);

            $pasos = explode(',', $testCaseData->pasos);
            $pasos_count = 0;

            for ($i=0; $i < count($pasos); $i++) {
                
                //$this->fpdf->SetX(95);
                $this->fpdf->Multicell(190,7,"Paso ".($i+1).": ".utf8_decode($pasos[$i]),1,0,'C',$bandera);
                $pasos_count += 7;
            }

            // EVIDENCIAS

            $flag = false;

            for($i=0; $i < count($evidenciasTestCase); $i++)
            {
                if($i == 0 && (count($pcond)+count($pasos)) > 10){
                    
                    $this->fpdf->AddPage();
                    $flag = true;
                }

                if($flag){

                    if($i != 0 && $i % 2 == 0){

                        $this->fpdf->AddPage();
                    }
                } else{
                    if ($i != 0 && $i % 2 != 0){

                        $this->fpdf->AddPage();
                    }
                }

                $this->fpdf->Cell(80,120, $this->fpdf->Image('../public'.$evidenciasTestCase[$i]->path, $this->fpdf->GetX()+10, $this->fpdf->GetY()+5, 50, null), 1, 0, 'R');
                $this->fpdf->Cell(110,120, utf8_decode($evidenciasTestCase[$i]->comentario), 1, 0, 'C', $bandera);
                $this->fpdf->Ln();
            }

            //FOOTER

            $ban = false; //Para alternar el relleno
            $ban = !$ban;//Alterna el valor de la bandera


            $this->fpdf->Settextcolor(10, 10, 10);

            $this->fpdf->Ln(0);
            $this->fpdf->Cell(80,8,utf8_decode('Resultado de caso de prueba: '),1,0,'C', $ban);

            $this->fpdf->Cell(110,8,utf8_decode(strtoupper($testCaseData->resultado)),1,0,'C','true');

        }
        // CONFIG

        $this->fpdf->AliasNbPages();
        $this->fpdf->Output("I","REPORTE_GENERAL.pdf");
    }
}
