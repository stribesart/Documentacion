<?php
	require_once("conexion.php");
 require_once("ObtieneDatosTablaMySql.php");
	$anio = ObtieneRequest("anio",0);
	$mes = ObtieneRequest("mes",0);
	$condicon = $mes > 0 ? " and mes = {$mes}" : "";
 $datos = ObtieneDatosTablaMysql(
  "vperiodossemanales",
		"	vperiodossemanales.nsemana as `Numero de Semana`, 
  		vperiodossemanales.periodo, 
				vperiodossemanales.id ",
		"",
		"where ano ={$anio} {$condicon}",
		"order by id"
	);	
	header('Content-Type: application/json');
	echo json_encode($datos);
?>