<?php
 require_once("../conexion.php");
	require_once("../ObtieneDatosTablaMySql.php");
 
	$idSucursal = ObtieneRequest("idSucursal",0);
	$condicion = "where ((sucursal.suc18=0)";
 $condicion .= $idSucursal == 0 ? ")" : " and (suc01 = {$idSucursal}))";

	$datos = ObtieneDatosTablaMySql(
		"sucursal",
		"sucursal.suc01,
		 sucursal.suc03",
		"",
		"{$condicion}",
		"order by suc03"	
	);
header('Content-Type: application/json');
echo json_encode($datos);
 
