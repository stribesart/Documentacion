<?php
 require_once("ObtieneInventarioSucursal.php");
	require_once("ObtienePromocionesSucursal.php");
	require_once("ObtieneTotalPromocionesSucursal.php");
	require_once("ObtieneTotalesSucursal.php");

function ObtieneSucursales($AIdPromocion, $AIdSucursal, $ACondicion){
 $result = ObtieneResulsetSqlServer("
  select distinct
    catalogolocaciones.id,
    catalogolocaciones.nombre
   from detallepromocionsucursal 
   inner join catalogolocaciones on (detallepromocionsucursal.det02 = catalogolocaciones.id)
   where detallepromocionsucursal.det01 = '$AIdPromocion' ".$ACondicion."
   order by catalogolocaciones.id
   ");
 $i = 0;
	$datos=[];
	while ($row = odbc_fetch_array($result)){
		$sucursales[$i] = array("Nombre" => utf8_encode($row["nombre"]));
		$idSucursal[$i] = $row["id"];
		$i++;
	}	
	if($i>0){
    $sucursales[$i] = array("Nombre" => "Totales");
    $datos["Sucursal"] = $sucursales;
    $datos = ObtieneInventarioSucursal($idSucursal,$datos,$AIdPromocion);
    $datos = ObtieneTotalesSucursal($idSucursal,$datos,$AIdPromocion);
	}
	return $datos;
} 
