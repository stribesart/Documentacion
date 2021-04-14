<?php
 require_once("../conexion.php");
 require_once("../ObtieneDatosTablaMySql.php");

function ObtieneCondicionArticulos($AParametros){
 $idDepartamento = $AParametros["idDepartamento"];
 $idSeccion      = $AParametros["idSeccion"];
 $idZona         = $AParametros["idZona"]; 
 $nomina         = BaseDatos('nomina'); 
 $compras        = BaseDatos('compras'); 
	$condicion = "";
	$condicion = ObtieneCondicionSucursal(
	 $AParametros["idSucursal"],
		$AParametros["tipoUsuario"],
		$AParametros["idPonderado"]
	);
 
	$condicion .= $idZona == 0 ? "" : " and (dticketsmasvendidos.dti01 in 
  (select dzonas.dzo05 
	  from {$nomina}dzonas 
	  where dzonas.dzo01 = {$idZona}))";
	
	$condicion .= $idDepartamento == 0 ? "" : " and (codigoprada.cod04 = {$idDepartamento})";
 
	$condicion .= $idSeccion == 0 ? "" : " and (codigoprada.cod05 in  
  (select familias.fam01 
			from {$compras}familias 
   where (familias.fam08 = {$idSeccion})))";  
	return $condicion;		
}

function ObtieneCondicionSucursal($AIdSucursal,$ATipoUsuario,$AIdPonderado){
 $idSucursal = $ATipoUsuario == 3 ? $AIdPonderado : $AIdSucursal;
	if($idSucursal > 0){
 	$idSucursal = ObtieneValorCampoMySql(
			"sucursal",
			"sucursal.suc01",
			"where (sucursal.suc22 = {$idSucursal})"
		);
	 $condicion = $idSucursal == 0 ? "" : " and (dticketsmasvendidos.dti01 = $idSucursal)";
	}else{
  $condicion = "";
	}
	return $condicion;	
}

