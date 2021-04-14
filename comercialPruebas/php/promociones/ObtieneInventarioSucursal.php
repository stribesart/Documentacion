<?php

function ObtieneInventarioSucursal($AIdSucursales,$ASucursales,$AIdPromocion){
	$resultPrecios = ObtienePreciosPromocion($AIdPromocion);
	$datos=[];
	while($rowPrecios = odbc_fetch_array($resultPrecios)){
	 $inventarioInicial = 0;
  $inicial = 0;
		$unidades = 0;
		$pesos = 0;
		for ($i=0; $i < count($AIdSucursales) ; $i++) { 
   $result = ObtienePromocionesSucursal($AIdPromocion,$AIdSucursales[$i],$rowPrecios["pre02"]);
 		$inventarioInicialSucursal = ObtieneInventarioInicialSucursal($AIdSucursales[$i],$AIdPromocion);
   $linea = odbc_fetch_array($result);
      $porcentaje =  $linea['inicial'] <> 0 ? number_format(($linea['unidades'] * 100) / $linea['inicial'],2)."%" : 0;
  $porcentajeParticipacion =  $inventarioInicialSucursal != 0 ? number_format(($linea["inicial"] * 100) / $inventarioInicialSucursal,2)."%" : 0;
			$datos = array(
        "Inventario" => number_format($linea['inicial'],0),
     			"% Participacion" => $porcentajeParticipacion,
        "Unidades" => number_format($linea['unidades'],0),
        "Pesos" => number_format($linea['pesos'],2),
        "%" => $porcentaje
      );
      $renglon[$i] = $datos;
      $inicial += $linea["inicial"];
			$unidades += $linea["unidades"];
			$pesos += $linea["pesos"];
		$inventarioInicial += $inventarioInicialSucursal;
    }	
    $porcentaje =  $inicial <> 0 ? number_format(($unidades * 100) / $inicial,2)."%" : 0;
  $porcentajeParticipacion =  $inicial != 0 ? number_format(($inventarioInicial * 100) / $inicial,2)."%" : 0;
		$datos = array(
      "Inventario" => number_format($inicial,0),
								"% Participacion" => $porcentajeParticipacion,
      "Unidades" => number_format($unidades,0),
      "Pesos" => number_format($pesos,2),
      "%" => $porcentaje
		);
    $renglon[$i] = $datos;
  $ASucursales[$rowPrecios["pre03"]] = $renglon;
	}
 return $ASucursales;
}
