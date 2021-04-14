<?php
$datos = [];
 require_once("../conexion.php");
 require_once("AgregaRegistroArreglo.php");
	require_once("AgregaRegistroPaseantes.php");
	require_once("CalculaPorcentaje.php");
	require_once("../ObtieneNumeroSemana.php");
	require_once("../ObtieneSemanasMes.php");
	require_once("ObtieneTablaEmpleado.php");
	require_once("ObtieneTablaPrada.php");
	require_once("ObtieneTablaSucursal.php");
	require_once("ObtieneTablaZona.php");

 $tipoUsuario = ObtieneRequest("tipoUsuario",4);
 $idPonderado = ObtieneRequest("idPonderado",0); 
 $anio = ObtieneRequest("idAnio",0);
 $cbSucursal = ObtieneRequest("cbSucursales","off");
 $cbZonas = ObtieneRequest("cbZonas","off");
 $tipoVenta = ObtieneRequest("tipoVenta",2); // 0=Semana 1=Mensual
 $idSucursal = ObtieneRequest("idSucursales",0);
 $tipoConsulta = ObtieneRequest("tipoConsulta",3);
 $idConsulta = $tipoVenta == 0 ? ObtieneRequest("idSemana",0) : ObtieneRequest("idMes",0);
 $idZona = $cbZonas == "off" ? 0:ObtieneRequest("idZonas",0);
	if($tipoUsuario == 3){
 	$idSucursal = $idPonderado;
	}else{
  $cbSucursal == "off" ? 0 : ObtieneRequest("idSucursales",0);
	}
	/*
	$php=array(
 'tipoUsuario'  => $tipoUsuario,
 'idPonderado'  => $idPonderado, 
 'anio'         => $anio,
 'idSemana'     => $idSemana,
 'cbSucursal'   => $cbSucursal,
 'cbZonas'      => $cbZonas,
 'tipoVenta'    => $tipoVenta,
 'idSucursal'   => $idSucursal,
 'tipoConsulta' => $tipoConsulta,
 'idZona'       => $idZona,
	'numeroSemana' => $numeroSemana
	);
*/	
	if($idConsulta == 0 || $tipoUsuario == 4 || $anio == 0 || $tipoConsulta == 3 || $tipoVenta==2){
		$datos["Error"] = array("error" => "Tiene que indicar anio, idSemana o Mes, tipoUsuario, tipo de Venta y TipoConsulta ");
	 $datos["request"] = $_REQUEST;
	}else{ 
  $numeroSemana = ObtieneNumeroSemana($idConsulta);
  switch ($tipoConsulta) {
   case 0:
		  $datos["zonas"] = ObtieneTablaZona($anio,$numeroSemana,$idSucursal,$idZona,$tipoVenta);
    $datos["sucursales"] = ObtieneTablaSucursal($anio,$numeroSemana,$idSucursal,$idZona,$tipoUsuario,$idPonderado,$tipoVenta);
	   break;
   case 2:
    $datos["empleados"] = ObtieneTablaEmpleado($anio,$numeroSemana,$idSucursal,$tipoVenta);
    $datos["sucursal"] = ObtieneTablaSucursal($anio,$numeroSemana,$idSucursal,$idZona,$tipoVenta);    
				break;
	 }

 }
/*
	 $datos["request"] = $_REQUEST;
		$datos['php'] = $php;
*/

 header('Content-Type: application/json');
 echo json_encode($datos);
  