<?php
session_start();
	require_once('public/screen.class.php' );


$screen = new screen(); 

	require_once("public/pdfcreator.class.php");
	
	
		$pdf = new pdfcreator();
		 $str_data =  $screen->getall_screen($_GET["strno"]);
			//print_r($str_data);
$data = array(
	"ACCOUNT" =>array("REF NO"=>$str_data[0]['refno'],"DATE"=>$str_data[0]['date'],"DEPARTMENT"=>$str_data[0]['department'],"ENTITY"=>$str_data[0]['entity']),
	"PERSON" => array("Persons(s)"=>json_decode($str_data[0]['persons']),"Clients Accounts"=>json_decode($str_data[0]['clientac'])),
	"SUSPECION" => array("Date of Activity"=>$str_data[0]['dateact'],"Description Of Transaction"=>$str_data[0]['descrtrans'], "Nature  Suspecion"=>$str_data[0]['descrsuspecion'], "Exaplanation of connected person" => $str_data[0]['personexpl']),
	"ATTACHMENT" => array("attachment"=>json_decode($str_data[0]['attachment'])),
);

//$pdf = new FPDF();
//$pdf = new PDF();
$pdf->FPDF();
$pdf->AliasNbPages();

$pdf->AddPage();

$pdf->SetFont('Arial','B',12);
$pdf->ImprovedTable($data["ACCOUNT"] ,"ACCOUNT INFORMATION");

$pdf->personTable($data["PERSON"] ,"CONNECTED INFORMATION");
$pdf->ImprovedTable($data["SUSPECION"] ,"SUSPECION INFORMATION");
$pdf->attachemntView($data["ATTACHMENT"] ,"ATTACHMENT INFORMATION");

$pdf->SetFont('Arial','B',16);

	
$pdf->Output();
?>