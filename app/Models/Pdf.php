<?php

namespace App\Models;

use Codedge\Fpdf\Fpdf\Fpdf;

class Pdf extends Fpdf
{
    public function Header()
    {
        /*$this->Image(storage_path() . '/logo.jpg',10,6,30);
        $this->SetFont('Arial','B',15);
        $this->Cell(80);
        $this->Cell(30,10,'Title',1,0,'C');
        $this->Ln(20);*/
    }

    public function Footer()
    {
        $bander = false; //Para alternar el relleno
        $bander = !$bander;//Alterna el valor de la bandera
        $this->SetxY(15,266.9);
        // Select Arial italic 8
        $this->SetFont('Arial','',8);
        // Print centered page number
        // $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
        // $this->fpdf->Cell(110,8,utf8_decode(strtoupper($testCaseData->resultado)),1,0,'C','true');

        $this->SetFont('helvetica','I',10);
        $this->Cell(40,10,utf8_decode('Información Confidencial'),0, 0 , 'C', $bander);

        $this->Cell(260,10,utf8_decode('Pág.'.$this->PageNo().'  de {nb}'),0, 0 , 'C', $bander);
    }
}