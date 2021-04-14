<?php
function ObtieneInventarioZona($AIdZonas,$AZonas,$AIdPromocion){
	$resultPrecios = ObtienePreciosPromocion($AIdPromocion);
	$datos=[];
	while($rowPrecios = odbc_fetch_array($resultPrecios)){
		$inicial = 0;
		$inventarioInicial = 0;
		$unidades = 0;
		$pesos = 0;
		for ($i=0; $i < count($AIdZonas) ; $i++) { 
   $result = ObtienePromocionesZona($AIdPromocion,$AIdZonas[$i],$rowPrecios["pre02"]);
			$inventarioInicialZona = ObtieneInventarioInicialZona($AIdZonas[$i],$AIdPromocion);
		 $linea = odbc_fetch_array($result);
   $porcentaje =  $linea['inicial'] != 0 ? number_format(($linea['unidades'] * 100) / $linea['inicial'],2)."%" : 0;
			$porcentajeParticipacion = $inventarioInicialZona != 0 ? number_format(($linea["inicial"] * 100) / $inventarioInicialZona,2)."%" : 0;
			$datos = array(
					 "Inventario" => number_format($linea['inicial'],0),
						"% Participacion" => $porcentajeParticipacion,
      "Unidades" => number_format($linea['unidades'],0),
      "Pesos" => number_format($linea['pesos'],2),
      "% Venta" => $porcentaje
					);
 	 $renglon[$i] = $datos;
	  $inicial += $linea["inicial"];
			$unidades += $linea["unidades"];
			$pesos += $linea["pesos"];
 		$inventarioInicial += $inventarioInicialZona;
 	}	

  $porcentaje =  $inicial != 0 ? number_format(($unidades * 100) / $inicial,2)."%" : 0;
		$porcentajeParticipacion = $inventarioInicial != 0 ? number_format(($inicial * 100) / $inventarioInicial,2)."%" : 0;
		$datos = array(
		 "Inventario" => number_format($inicial,0),
			"% Participacion" => $porcentajeParticipacion,
   "Unidades" => number_format($unidades,0),
   "Pesos" => number_format($pesos,2),
   "%" => $porcentaje
		);
  $renglon[$i] = $datos;
  $AZonas[$rowPrecios["pre03"]] = $renglon;
	}
	return $AZonas;
}
