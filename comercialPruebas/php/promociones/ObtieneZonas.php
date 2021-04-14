<?php
	require_once("ObtieneInventarioInicialSucursal.php");
	require_once("ObtieneInventarioInicialZona.php");
	require_once("ObtieneInventarioZona.php");
 require_once("ObtienePreciosPromocion.php");
	require_once("ObtienePromocionesZona.php");
	require_once("ObtieneTotalesZona.php");
	require_once("ObtieneTotalPromocionesZona.php");

function ObtieneZonas($AIdPromocion,$ACondicion){
 $query = "select distinct
   distrito.id,
   distrito.Nombre
  from detallepromocionsucursal 
   inner join catalogolocaciones on (detallepromocionsucursal.det02 = catalogolocaciones.id)
   inner join distrito on (catalogolocaciones.IDistrito = distrito.Id) 
   where detallepromocionsucursal.det01 = '{$AIdPromocion}' {$ACondicion}
    order by distrito.id
  ";
 $resultZonas = ObtieneResulsetSqlServer($query);
	$datos=[];
 $i = 0;
	while ($rowZonas = odbc_fetch_array($resultZonas)){
		$zonas[$i] = array("Nombre" => $rowZonas["Nombre"]);
		$idZonas[$i] = $rowZonas["id"];
		$i++;
	}	
	if($i>0){
  	$zonas[$i] = array("Nombre" => "Totales");
    $datos["Zona"] = $zonas;
		$datos = ObtieneInventarioZona($idZonas,$datos,$AIdPromocion);
  $datos = ObtieneTotalesZona($idZonas,$datos,$AIdPromocion);
	}
	return $datos;
}
