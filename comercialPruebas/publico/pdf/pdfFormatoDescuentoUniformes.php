<?php
/*
$x=(int)$atot[2];
$d=substr($atot[2],-2);
 include ('numerosALetras.class.php');
 $n=new numerosALetras ((int)$atot[2]) ;
 $letras="Con un Costo total por $".number_format($atot[2],2);
 $letras.=" (".$n->resultado." PESOS ".$d."/100 MXN) ";

*/

	require('fpdf/fpdf.php');
	require_once("../php/conexion.php");
	require_once("../../session.php");
	require_once "../php/conversor.php";
	$formato = $_GET['idFormato'];
	$pdf=new FPDF();
	$pdf->AddPage();
	for($i=0;$i<2;$i++){ 
 	$total = 0;
 	$costoTotal = 0;
 	$query1 = "select * from pradacompras.vdformatouniformes where dfo01=".$formato;
 	$result1 = mysqli_query($con,$query1) or die(header("Location: ../php/noexiste.php?mensaje='ERROR DE CONEXION A LA BASE DE DATOS '$query1 "));

	
	
	
 	$query = "select * from pradacompras.vformatouniformes where for01=".$formato;
 	$result = mysqli_query($con,$query) or die(header("Location: ../php/noexiste.php?mensaje='ERROR DE CONEXION A LA BASE DE DATOS '$query "));
	
	
 	while ($row = mysqli_fetch_array($result)){ 
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,8,'SERVICIOS ADMINISTRATIVOS SOLARES, SA DE CV',0,1,'C');
	$pdf->Cell(0,8,'RECIBO DE UNIFORME',0,1,'C');
	$pdf->SetFont('Arial','',10);
	$pdf->Ln();
	$pdf->Cell(25,10,'NOMBRE:',0,0,'L');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(65,10,$row['empleado'],0,0,'L');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(28,10,'SUCURSAL:',0,0,'L');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(65,10,$row['nombre'],0,0,'L');
	$pdf->SetFont('Arial','',9);
	$pdf->Ln();
	$pdf->Multicell(0,4,'RECIBI DE SERVICIOS ADMINISTRATIVOS SOLARES, SA DE CV LAS SIGUIENTES PRENDAS PARA CONFORMAR MI UNIFORME', 0, 'L', 0);
	$pdf->Ln();
// Colores, ancho de línea y fuente en negrita
	$pdf->SetFillColor(0,0,0);
	$pdf->SetTextColor(255);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetLineWidth(.3);
	$pdf->SetFont('','B',7);
// Cabecera
	$pdf->Cell(30,5,'CANTIDAD',1,0,'C',1);
	$pdf->Cell(70,5,'DESCRIPCION',1,0,'C',1);
	$pdf->Cell(30,5,'IMPORTE UNITARIO',1,0,'C',1);
	$pdf->Cell(30,5,'TOTAL',1,0,'C',1);
	$pdf->Ln();
// Restauración de colores y fuentes
	$pdf->SetFillColor(224,235,255);
	$pdf->SetTextColor(0);
	$pdf->SetFont('');
// Datos
	$lineas = 0;
	 while ($row1 = mysqli_fetch_array($result1)){
	 $aux = $row1['dfo04']*$row1['dfo03'];
	 $descuento = $row1['uni02']-$row1['dfo04'];
	 
	 $pdf->Cell(30,5,$row1['dfo03'],1,0,'C');
	 $pdf->Cell(70,5,$row1['fam04'],1,0,'C');
	 if($row1['uni05']==0){
	 	$pdf->Cell(30,5,'$'.number_format($row1['uni02'],2),1,0,'R');
	 	$pdf->Cell(30,5,'$'.number_format($row1['uni02']*$row1['dfo03'],2),1,0,'R');
	 	$costoTotal += ($row1['uni02']*$row1['dfo03']);
	 }else{
	 	$pdf->Cell(30,5,'Obsequio',1,0,'R');
	 	$pdf->Cell(30,5,'$'.number_format(0,2),1,0,'R');
	 } 
	
	 $pdf->Ln();
		
		
	 	$total += $aux;
	 	$lineas ++;
	 }
	 
	 
	$totalSinPunto = truncateFloat($costoTotal,0);
	$totalSinComa= str_replace(',','',$totalSinPunto);
	$letras = convertir($totalSinComa);
	$semanas = convertir($row['for08']);
	$d=substr(number_format($costoTotal,2),-2);
	$pdf->Cell(30,5,'',1,0,'C');
	$pdf->Cell(70,5,'',1,0,'C');
	$pdf->Cell(30,5,'',1,0,'C');
	$pdf->Cell(30,5,'$'.number_format($costoTotal,2),1,1,'R');
	
	$pdf->SetFont('','',9);
	$pdf->Ln();
	$pdf->Multicell(0, 4,'CON UN COSTO TOTAL DE $'.number_format($costoTotal,2).' ( '.$letras.' PESOS CON '.$d.'/100 MNX ), DEL CUAL ACEPTO QUE SE ME DESCUENTE EL 50% DE DICHO IMPORTE EN '.$semanas.' SEMANAS, VIA NOMINA, ES APLICABLE A PARTIR DE LA ACEPTACION EN SISTEMA Y LA FIRMA DEL FORMATO DE DESCUENTO.', 0, 'L', 0);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Cell(100,10,'NOMBRE COMPLETO Y FIRMA DEL EMPLEADO','T',0,'C');
	$pdf->Cell(20,10,'  ',0,0,'C');
	$pdf->Cell(60,10,'FECHA','T',1,'C');
	$pdf->Ln();
	
	for($j=$lineas; $j<7; $j++){
	$pdf->Ln();
	 }
 	}
	}
	
	
	$pdf->Output();
?>