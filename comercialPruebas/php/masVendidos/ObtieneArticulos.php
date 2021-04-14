<?php
function ObtieneArticulos($AParametros){

	$orden       = $AParametros["tipoConsulta"] == 0 ? "desc" : "";
	$verQuery    = $AParametros["verQuery"] == 0 ? false : true;
 $condicion   = ObtieneCondicionArticulos($AParametros); 
 $facturacion = BaseDatos("facturacion");
 $compras     = BaseDatos("compras");
 $datos       = ObtieneDatosTablaMySql(
  "{$facturacion}dticketsmasvendidos",
  " modelo.mod01,
    codigoprada.cod10,
    codigoprada.cod03,
    colores.col02,
    left(departamentos.dep02,2) dep02,
    familias.fam02,
    proveedores.pro04,
    dticketsmasvendidos.dti18,
    sum(dticketsmasvendidos.dti06) as unidades,
    format(dticketsmasvendidos.dti08,2) dti08,
    codigoprada.cod01,
    format(sum(dticketsmasvendidos.dti06) * dticketsmasvendidos.dti08,2) as venta,
    {$compras}NombreImagen(modelo.mod01,codigoprada.cod10) imagen ",
  " inner join {$compras}modelo on (dticketsmasvendidos.dti18 = modelo.mod05)
    inner join {$compras}codigoprada on (modelo.mod07 = codigoprada.cod01)
    inner join {$compras}colores on (codigoprada.cod09 = colores.col01)
    inner join {$compras}proveedores on (codigoprada.cod02 = proveedores.pro01)
    inner join {$compras}departamentos on (codigoprada.cod04 = departamentos.dep01)
    inner join {$compras}familias on (codigoprada.cod05 = familias.fam01)",
  " where ( ((dticketsmasvendidos.dti09 - dticketsmasvendidos.dti14) <> 0) 
      and   (modelo.mod01 = {$AParametros["idTemporada"]}) 
      and   (dticketsmasvendidos.tic04 between '{$AParametros["fechaInicial"]}' and '{$AParametros["fechaFinal"]}')
            $condicion)",
  " group by modelo.mod01,cod10
    order by 9 {$orden} limit 20",$verQuery
 );
 return $datos;
}

/*
function ObtieneCondicionArticulos($AParametros){
 $idDepartamento = $AParametros["idDepartamento"];
 $idSeccion      = $AParametros["idSeccion"];
 $idZona         = $AParametros["idZona"]; 
 $nomina         = BaseDatos('nomina'); 
 $compras        = BaseDatos('nomina'); 
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
*/