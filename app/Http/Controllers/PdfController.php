<?php

namespace App\Http\Controllers;

use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use App\Models\CasosPruebas;
use App\Models\Evidencias;

class PdfController extends Controller
{
    protected $fpdf;

    public function __construct()
    {
        $this->fpdf = new Fpdf;
    }

    public function index($id) 
    {

        $testCaseData = CasosPruebas::find($id);
        $evidenciasTestCase = Evidencias::where('cp_id', $testCaseData->id)->get();

        /*------------------- HEADER -----------------*/

        $this->fpdf->SetFont('Arial', 'B', 15);
        $this->fpdf->AddPage();

        $this->fpdf->SetFont('helvetica','B',12);
        $this->fpdf->SetTextColor(1, 46, 103);

        $this->fpdf->Image('../public/upload/andes.jpg',13,8,22);
        
        $bander = false; //Para alternar el relleno 
        $bander = !$bander;//Alterna el valor de la bandera
            //foreach($datos as $fila)
            //{
              // base datos $this->CellFitSpace(30,7, utf8_decode($fila['nombre']),1, 0 , 'L', $bandera );
                //$this->SetFillColor(255,255,255);
        $this->fpdf->SetXY(37,8);
        //$this->Cell(25,23, '',1, 0 , 'L', $bander );
        $this->fpdf->SetFillColor(255,255,255);
        $this->fpdf->Cell(92,11, utf8_decode( 'Estándares de Buenas Practicas'),1, 0 , 'C', $bander );
        //  $this->SetFillColor(229, 229, 229);
        //$this->SetFillColor(224,235,255);
        $this->fpdf->Cell(28,11,'FECHA ',1, 0 , 'C', $bander);
        $this->fpdf->SetFillColor(255,255,255);
        $this->fpdf->Cell(36,11, '',1, 0 , 'L', $bander );
        //$this->Cell(18,5.5, '',1, 0 , 'L', $bandera );
        //  $this->Cell(18,5.5, '',1, 0 , 'L', $bandera );

        $this->fpdf->Ln();//Salto de línea para generar otra fila

        $this->fpdf->SetXY(37,19);   
        $this->fpdf->SetFillColor(224, 235, 255);
        $this->fpdf->Cell(30,12,utf8_decode( 'CODIGO'),1, 0 , 'C', $bander );
        $this->fpdf->SetFillColor(255, 255, 255);
        $this->fpdf->Cell(62,12, '',1, 0 , 'C', $bander );
        $this->fpdf->Cell(28,12,utf8_decode( 'PÁGINA'),1, 0 , 'C', $bander );
        // $this->Cell(18,6, '',1, 0 , 'L', $bandera );
        $this->fpdf->SetFillColor(255,255,255);
        $this->fpdf->Cell(36,12, utf8_decode('Página').'1'.'/{nb}',1, 0 , 'C', $bander);

        $this->fpdf->Ln();//Salto de línea para generar otra fila
        $this->fpdf->SetDrawColor(188,188,188);
        $this->fpdf->SetLineWidth(1);
        $this->fpdf->Line(11,33,195,33);
        $this->fpdf->Ln(0);

        /*------------------- BODY -----------------*/

        $bandera = false; //Para alternar el relleno
        $bandera = !$bandera;//Alterna el valor de la bandera
        //foreach($datos as $fila)
        //{


          // Título /*
        $this->fpdf->SetFont('helvetica','B',12);
        $this->fpdf->SetTextColor(1, 46, 103);

        //
        //$this->SetXY(12,8);
        $this->fpdf->SetFont('Arial','B',10);
        // $this->SetFillColor(28, 229, 229);
        $this->fpdf->SetDrawColor(155,155,155);
        $this->fpdf->SetLineWidth(.3); //Gris tenue de cada fila
        //$this->SetTextColor(3, 3, 3); //Color del texto: Negro


        $this->fpdf->SetXY(15,37);
        $this->fpdf->SetFont('helvetica','B',12);
        $this->fpdf->SetFillColor(255, 255, 255);
        $this->fpdf->SetDrawColor(255, 255, 255);
        $this->fpdf->MultiCell(190,6.5,utf8_decode('Caso '.$testCaseData->id.': '.$testCaseData->nombre),1,1,'C');

        $this->fpdf->SetXY(13,60);
        $this->fpdf->SetFont('helvetica','B',11);
        $this->fpdf->SetFillColor(255, 255, 255);
        $this->fpdf->SetDrawColor(155,155,155);
        $this->fpdf->MultiCell(59,8,utf8_decode('Aplicación/Módulo/ Plataforma y/o Funcionalidad: '),1,1,'L', $bandera);
        $this->fpdf->SetXY(72,60);


        $this->fpdf->Multicell(125,8,utf8_decode($testCaseData->funcionalidad),1,1,'L','true');
        //  $this->MultiCell(120,5,utf8_decode(''),1,1,'L', $bandera);

        $this->fpdf->SetXY(13,76);
        $this->fpdf->SetFont('helvetica','B',11);
        $this->fpdf->SetFillColor(255, 255, 255);
        $this->fpdf->SetDrawColor(155,155,155);
        $this->fpdf->Cell(59,8,utf8_decode('Tipo de Prueba: '),1,1,'C', $bandera);
        $this->fpdf->SetXY(72,76);  
        $this->fpdf->cell(125,8,utf8_decode($testCaseData->tipo_prueba),1,1,'L','true');
        //  $this->MultiCell(120,5,utf8_decode(''),1,1,'L', $bandera);



        $this->fpdf->SetXY(13,84);
        $this->fpdf->Cell(59,16,utf8_decode('Precondición'),1,1,'C', $bandera);
        $this->fpdf->SetXY(72,84);


        $this->fpdf->Multicell(125,8,utf8_decode($testCaseData->precondiciones),1,1,'L','true');
        //  $this->MultiCell(120,5,utf8_decode(''),1,1,'L', $bandera);


        $this->fpdf->SetXY(13,100);
        $this->fpdf->Cell(59,16,utf8_decode('Ola y fecha de certificación'),1,1,'C', $bandera);
        $this->fpdf->SetXY(72,100);


        $this->fpdf->Multicell(125,8,utf8_decode($testCaseData->ola),1,1,'L','true');
        //  $this->MultiCell(120,5,utf8_decode(''),1,1,'L', $bandera);


        $this->fpdf->SetXY(13,116);
        $this->fpdf->Cell(59,8,utf8_decode('Resultado de caso de prueba: '),1,1,'C', $bandera);
        $this->fpdf->SetXY(72,116);


        $this->fpdf->Multicell(125,8,utf8_decode($testCaseData->resultado),1,1,'L','true');
        //  $this->MultiCell(120,5,utf8_decode(''),1,1,'L', $bandera);


        $this->fpdf->SetXY(13,124);
        $this->fpdf->MultiCell(184,8,utf8_decode('Secuencia (Pasos):  
        - Ingresar al Nuevo Aplicativo.  
        - Indicar el nombre de la organización "andes".  
        - Digitar el usuario y contraseña.  
        - Presionar el botón Continuar. 
        -Presionar en ordenes o filtrar por "nuevas asignadas" 
        -El aplicativo no precarga las ordenes asignadas. '),1,1,'C', $bandera);
        //$this->fpdf->SetXY(13,180);
        //$this->fpdf->Cell(184,50,utf8_decode(' '),1,1,'C', $bandera);
        $yPos = 200;

        foreach($evidenciasTestCase as $evidencia)
        {
            $this->fpdf->Cell(0,10,$this->fpdf->Image('../public'.$evidencia->path,20,null,100),0,1);
        }

        /*------------------- FOOTER -----------------*/

        // Posición: a 1,5 cm del final
        $this->fpdf->SetY(-15);
        // Arial italic 8
        $ban = false; //Para alternar el relleno
        $ban = !$ban;//Alterna el valor de la bandera
            //foreach($datos as $fila)
            //{

        $this->fpdf->Settextcolor(85, 85, 85);
        
        // Número de página
        //$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
        $this->fpdf->SetXY(13,276);
        $this->fpdf->Cell(59,8,utf8_decode('Aprobador: '),1,1,'C', $ban);
        $this->fpdf->SetXY(72,276);

        $this->fpdf->Multicell(125,8,utf8_decode($testCaseData->aprobador),1,1,'L','true'); 

        $this->fpdf->Output();
    }
}
