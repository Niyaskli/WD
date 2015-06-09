<?php

require('fpdf.php');
require('makefont/makefont.php');  			//font editing

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
   $this->Image('C:\Documents and Settings\shifu\Desktop/logo.png',6,6,30);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(50,10,'STR SCREEN',1,0,'C');
    // Line break
    $this->Ln(20);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}

function ChapterTitle($num, $label)
{
    // Arial 12
    $this->SetFont('Arial','',14);
    // Background color
    $this->SetFillColor(200,220,255);
    // Title
	
    $this->Cell(0,8," $label",0,1,'L',true);
    // Line break
    $this->Ln();
}



function PrintChapter($num, $title)
{
   // $this->AddPage();
    $this->ChapterTitle($num,$title);
   
}

// Better table
function ImprovedTable($data, $head)
{
    // Column widths
    $w = array(70, 120);
  
    $this->Ln();
	$this->PrintChapter(1,$head);
    // Data
    foreach($data as $row => $key)
    {
		
					$this->SetFont('Arial','B',11);
					$this->SetDrawColor(100,120,120);
					$this->Cell($w[0],10,$row,1,0,'L');
					$this->Cell($w[1],10,$key,1,0,'d');
					 $this->Ln();
		   
		
    }
 $this->Ln();

    // Closing line
    $this->Cell(array_sum($w),0,'','T');
	
}
function attachemntView($data, $head)
{
    // Column widths
    $w = array(70, 120);
  
    $this->Ln();
	$this->PrintChapter(1,$head);
    // Data
    foreach($data as $row => $key)
    {
					
					$this->SetFont('Arial','B',11);
					$this->SetDrawColor(255,255,255);
					$this->Cell($w[0],10,$this->Image('C:\Documents and Settings\shifu\Desktop/logo.png'),1,0,'L');
					
				
					 $this->Ln();
		   
		
    }
 $this->Ln();

    // Closing line
    $this->Cell(array_sum($w),0,'','T');
	
}

}



$data = array(
	"ACCOUNT" =>array("REF NO"=>"adsadsa","DATE"=>"Asdsadsa","DEPARTMENT"=>"asdsadsa","ENTITY"=>"asdsadsa"),
	"PERSON" => array("Persons(s)"=>"asdsadsa","Clients Accounts"=>"asdsadsa"),
	"SUSPECION" => array("Date of Activity"=>"asdsadsa","Description Of Transaction"=>"asdsadsa", "Nature  Suspecion"=>"asdasd", "Exaplanation of connected person" => "asdasdsa"),
	"ATTACHMENT" => array("Persons(s)"=>"asdsadsa","Clients Accounts"=>"asdsadsa"),
);

//$pdf = new FPDF();
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddFont('courier','','courier.php');
$pdf->AddPage();
$pdf->SetFont('courier','',35);
//$pdf->SetFont('Arial','B',12);
$pdf->ImprovedTable($data["ACCOUNT"] ,"ACCOUNT INFORMATION");

$pdf->ImprovedTable($data["PERSON"] ,"CONNECTED INFORMATION");
$pdf->ImprovedTable($data["SUSPECION"] ,"SUSPECION INFORMATION");
$pdf->attachemntView($data["ATTACHMENT"] ,"ATTACHMENT INFORMATION");

$pdf->SetFont('Arial','B',16);
	
$pdf->Output();


?>