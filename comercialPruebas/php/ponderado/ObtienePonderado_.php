<?php
 require_once("../conexion.php");
 require_once("ObtieneRangoSemana.php");
	require_once("ObtieneTotalMetaZona.php");
	require_once("ObtieneMetasZona.php");
	require_once("ObtieneMetasSucursal.php");
	require_once("ObtieneMetaMensualSucursal.php");

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

	$id = ObtieneRequest("id",0);
	$idSemana = ObtieneRequest("idSemana",0);
 $idSucursal = ObtieneRequest("idSucursal",0);
 $idZona = ObtieneIdZona(ObtieneRequest("idZona",0),$idSucursal);
	$tipoUsuario = ObtieneRequest("tipoUsuario",4); 
 $tipoVenta = ObtieneRequest("tipoVenta",0);

 $titulo = $idZona == 0 
	 ? "" 
	 :ObtieneValorCampoMySql("pradanomina.zonas","zonas.zon02","where (zonas.zon01 = $idZona)");
 $datos = [];
	$datos["parametros"] = array("zona" => $idZona,"sucursal" => $idSucursal);
	$datos["titulo"] = array("titulo" => "Meta Ponderados " . $titulo);
	$datos["rango"] = array(
		"rango" => ObtieneRangoSemana($idSemana),
		"Meta" => ObtieneTotalMetaZona($idSemana,$tipoVenta,$idZona)
	);
	$datos["metasZona"] = ObtieneMetasZona($idSemana,$tipoVenta,$idZona);
	$datos["metasSucursal"] = ObtieneMetasSucursal($idSemana,$tipoVenta,$idZona,$idSucursal);
	header('Content-Type: application/json');
	echo json_encode($datos);
