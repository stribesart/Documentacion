<?php
 require_once("../conexion.php");
 require_once("../ObtieneDatosTablaMySql.php");
 require_once("ObtieneCondicionArticulos.php");
	require_once("ObtieneArticulos.php");


 function ObtieneFechaInicial(){
  $mes = date('m');
  $ano = date('Y');
  $fecha_actual = date('Y-m-d', mktime(0,0,0, $mes, 1, $ano));
  return date("Y-m-d",strtotime($fecha_actual."- 1 month"));
 }
 
 $parametros = [];
	$parametros["cbSucursales"]    = ObtieneRequest("cbSucursales","");
	$parametros["cbDepartamento"]  = ObtieneRequest("cbDepartamento","");
	$parametros["cbZonas"]         = ObtieneRequest("cbZonas","");
	$parametros["cbSeccion"]       = ObtieneRequest("cbSeccion","");
	$parametros["idTemporada"]     = ObtieneRequest("idTemporada",0);
 $parametros["idZona"]          = $parametros["cbZonas"] == "on" ? ObtieneRequest("idZonas",0) : 0;
	$parametros["idSucursal"]      = $parametros["cbSucursales"] == "on" ? ObtieneRequest("idSucursales",0) : 0;
 $parametros["idDepartamento"]  = $parametros["cbDepartamento"] == "on" ? ObtieneRequest("idDepartamento",0) : 0;
 $parametros["idSeccion"]       = $parametros["cbSeccion"] == "on" ? ObtieneRequest("idSeccion",0) : 0;
 $parametros["fechaInicial"]    = ObtieneRequest("fechaInicial",ObtieneFechaInicial());
 $parametros["fechaFinal"]      = ObtieneRequest("fechaFinal",date('Y-m-d'));
 $parametros["tipoConsulta"]    = ObtieneRequest("tipoConsulta",0);
 $parametros["tipoUsuario"]     = ObtieneRequest("tipoUsuario",0);
 $parametros["idPonderado"]     = ObtieneRequest("idPonderado",0);
 $parametros["verQuery"] = ObtieneRequest("verQuery",0);
 if($parametros["tipoUsuario"] == 4 || $parametros["idTemporada"] == 0){
		$datos["Error"] = array("error" => "Tiene que indicar Temporada y tipoUsuario ");
		$datos["parametros"] = $_REQUEST;
	}else{
  $datos = ObtieneArticulos($parametros);
	}	

 header('Content-Type: application/json');
 echo json_encode($datos);