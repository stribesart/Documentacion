<?php
 require_once("../conexion.php");
 require_once("ObtieneRangoSemana.php");
	require_once("ObtieneTotalMetaZona.php");
	require_once("ObtieneMetasZona.php");
	require_once("ObtieneMetasZonasResumen.php");
	require_once("ObtieneMetasSucursal.php");
	require_once("ObtieneMetaMensualSucursal.php");
	require_once("ObtieneMetaMensualZona.php");
	require_once("ObtieneVentasSucursal.php");
	require_once("ObtieneVentasZona.php");
 require_once("ObtieneVentasWebSucursal.php");
 require_once("ObtieneVentasWebZona.php");

	function ObtieneIdZona($AIdZona, $AIdSucursal){
		if ($AIdSucursal>0){
			$idZona = ObtieneValorCampoMySql(
    "pradanomina.dzonas",
				"dzonas.dzo01",
				"where (dzonas.dzo02 = $AIdSucursal)"
			);	
		} else {
		 $idZona = $AIdZona; 
		}
		return $idZona;
	}

	function ObtieneTitulos($AColumna1,$ATotales){
  $titulos = array(
	 	"0" => $AColumna1,
	 	"1" =>	"Lunes",	
	 	"2" => "Martes",	
	 	"3" => "Miercoles",
	 	"4" => "Jueves",
	 	"5" => "Viernes",
	 	"6" => "Sabado",
	 	"7" => "Domingo",
	 	"8" => "Total",
		);
		if(strlen($ATotales)>0){
			$titulos["9"]=$ATotales;
		}
		return $titulos;
	}

	function ObtieneTitulosSucursal(){
  $titulos = array("0" => "Nombre");
		for ($i=1; $i <=19; $i+=2){
			$titulos[$i]='%'; 
			$titulos[$i+1]='META'; 
		}
		return $titulos;
	}

	$idPonderado   = ObtieneRequest("idPonderado",0);
	$cbSucursales  = ObtieneRequest("cbSucursales","");
	$cbZonas       = ObtieneRequest("cbZonas","");
 $idZona        = $cbZonas == "on" ? ObtieneRequest("idZonas",0) : 0;
	$idSucursal    = $cbSucursales == "on" ? ObtieneRequest("idSucursales",0) : 0;
	$idSemana      = ObtieneRequest("idSemana",0);
	$tipoUsuario   = ObtieneRequest("tipoUsuario",4); 
 $tipoVenta     = ObtieneRequest("tipoVenta",3);
	$tipoPonderado = ObtieneRequest("tipoPonderado",2);

$titulo = $idZona == 0 
	 ? "" 
	 :ObtieneValorCampoMySql("pradanomina.zonas","zonas.zon02","where (zonas.zon01 = $idZona)");

	$datos["titulo"] = array("titulo" => "Meta Ponderados " . $titulo);
	if($idSemana == 0 || $tipoUsuario == 4 || $tipoVenta == 3 || $tipoPonderado == 2){
		$datos["Error"] = array("error" => "Tiene que indicar idSemana, tipoUsuario, tipoPonderado y tipoVenta ");
		$datos["parametros"] = array(
	 	"idPonderado" => $idPonderado,
			"idSemana" => $idSemana,
			"tipoUsuario" =>$tipoUsuario, 
			"tipoVenta" => $tipoVenta,
				"zona" => $idZona,
 		"sucursal" => $idSucursal,
			"tipoPonderado" => $tipoPonderado
		); 
  $datos["request"] = $_REQUEST;
	}else{
 	$datos["rango"] = array(
	 	"rango" => ObtieneRangoSemana($idSemana),
	 	"Meta" => ObtieneTotalMetaZona($idSemana,$tipoVenta,$idZona)
	 );
  $fechaInicio = $datos["rango"]["rango"][0]["FechaInicio"];
	 $datos["metasZona"] = ObtieneMetasZona($idSemana,$tipoVenta,$idZona);

		if($tipoPonderado==0){
		 $datos["metasSucursal"] = ObtieneMetasSucursal($idSemana,$tipoVenta,$idZona,$idSucursal);
   $datos["ventasSucursal"] = ObtieneVentasSucursal($idSemana,$tipoVenta,$idZona,$idSucursal,$fechaInicio);
		}else{
			if($tipoUsuario)
		 $datos["metasSucursal"] = ObtieneMetasZonasResumen($idSemana,$tipoVenta,$idZona,$idSucursal);
   $datos["ventasSucursal"] =  ObtieneVentasZona($idSemana,$tipoVenta,$idZona,$idSucursal,$fechaInicio);;
		}	
	}
	header('Content-Type: application/json');
	echo json_encode($datos);
