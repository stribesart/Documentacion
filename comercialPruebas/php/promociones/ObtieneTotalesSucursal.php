<?php
function ObtieneTotalesSucursal($AIdSucursales,$ASucursales,$AIdPromocion){
	$datos=[];
	$inicial = 0;
	$unidades = 0;
	$pesos = 0;
	for ($i=0; $i < count($AIdSucursales) ; $i++) { 
  $result = ObtieneTotalPromocionesSucursal($AIdPromocion,$AIdSucursales[$i]);
  $linea = odbc_fetch_array($result);
  $porcentaje =  $linea['inicial'] <> 0 ? number_format(($linea['unidades'] * 100) / $linea['inicial'],2)."%" : 0;
		$datos = array(
		 "Inventario" => number_format($linea['inicial'],0),
   "Unidades" => number_format($linea['unidades'],0),
   "Pesos" => number_format($linea['pesos'],2),
   "%" => $porcentaje
		);
  $renglon[$i] = $datos;
	 $inicial += $linea["inicial"];
		$unidades += $linea["unidades"];
		$pesos += $linea["pesos"];
 }	
 $porcentaje =  $inicial <> 0 ? number_format(($unidades * 100) / $inicial,2)."%" : 0;
	$datos = array(
	 "Inventario" => number_format($inicial,0),
  "Unidades" => number_format($unidades,0),
  "Pesos" => number_format($pesos,2),
  "%" => $porcentaje
	);
 $renglon[$i] = $datos;
 $ASucursales["Total General"] = $renglon;
 return $ASucursales;
}
