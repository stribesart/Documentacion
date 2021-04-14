<?php
 require_once("../conexion.php");
 require_once("ObtieneSucursales.php");
	require_once("../ObtieneTablaSqlServer.php");
	require_once("ObtieneZonas.php");

 $idPonderado = ObtieneRequest("idPonderado",0);
 $idPromocion = ObtieneRequest("idPromocion",0);
 $cbZonas = ObtieneRequest("cbZonas","off");
 $idZona = $cbZonas == "off" ? 0 : ObtieneRequest("idZonas",0);
 $tipoUsuario = ObtieneRequest("tipoUsuario",4);
 $cbSucural = ObtieneRequest("cbSucursales","off");
 $tipoUsuario = ObtieneRequest("tipoUsuario",10);

 if($tipoUsuario==3){
		$idSucursal = $idPonderado;
	}else{
		$idSucursal = $cbSucural == "off" ? 0 : ObtieneRequest("idSucursales",0);
	}

 $condicionZona = $idZona > 0 ? " and IDistrito = {$idZona}" :  "and IDistrito in (1,3)";
 $condicionScucursal = $idSucursal > 0 ? " and id = ".$idSucursal : "";
 $condicion = $condicionScucursal." ".$condicionZona;

 $datos = [];
 $zonas=[];
	$idZonas=[];
 if ($idPromocion == 0){
  $contenido[0] = array("No se localizo en id de promocion");
 }else{
  $contenido["Zonas"] = ObtieneZonas($idPromocion,$condicionZona);		
 	$contenido["Sucursales"] = ObtieneSucursales($idPromocion,$idSucursal,$condicion);
 }

	$contenido["request"] = $_REQUEST;
 header('Content-Type: application/json');
 echo json_encode($contenido);
