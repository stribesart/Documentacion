<?php

function ObtieneLinea($AFila,$APorcentajeMensual,$AMetaMensual,$ANombre,$ATipoVenta){
 $linea = array("0" => $ANombre);
 for ($i=0; $i <16 ; $i++) { 
  $decimales = $i  % 2 == 0 ? 0 : 2;
		$signo = $decimales == 0 ? "%" : "";
		if($ATipoVenta==1){$decimales=0;}
  $linea[$i+1] = strlen($AFila[$i]) > 0 
   ? number_format($AFila[$i],$decimales).$signo
   : '';
 }
 $linea[17] = strlen($APorcentajeMensual) > 0 
  ? number_format($APorcentajeMensual,0)."%" 
  : "";
 $linea[18] = strlen($AMetaMensual) > 0 
  ? number_format($AMetaMensual,2) 
  : "";
 return $linea; 
}

function ObtieneSumatoria($ADestino,$AOrigen,$AOperacion,$APorcentaje,$AMeta){
 for ($i=0; $i <16 ; $i++) { 
  if(strlen($ADestino[$i])>0 && strlen($AOrigen[$i])>0){ 
   $ADestino[$i] = $AOperacion == 0 
   ? $ADestino[$i] + $AOrigen[$i] 
   : $ADestino[$i] - $AOrigen[$i];
  } 
 }
	
 if(strlen($APorcentaje)>0){
  $ADestino[16] = $AOperacion == 0 
		? $ADestino[16] + $APorcentaje
		: $APorcentaje - $ADestino[16];
 }
 if(strlen($AMeta)>0){
  $ADestino[17] = $AOperacion == 0 
		? $ADestino[17] + $AMeta
		: $AMeta - $ADestino[17];
 } 
 return $ADestino;
}

function ObtieneVentasSucursal($AIdSemana,$ATipoVenta,$AIdZona,$AIdSucursal,$AFechaInicio){
 $condicion = $AIdZona == 0 ? "" : " and (vajusteponderadosucursal.zon01 = $AIdZona)";
 $condicion .= $AIdSucursal == 0 ? "" : " and (vajusteponderadosucursal.aju03 = $AIdSucursal)";
 $MetaSucursal    =    array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
 $totalesMeta     =    array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
 $totalesVenta    =    array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
 $diferencia      =    array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
 $totalesVentaWeb =    array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
 $totalMetaPorcentaje=0;
 $totalMetaVenta=0;
	$totalVentaPorcentaje=0;
	$totalVentaVenta=0;
 $metas = [];
 $result = ObtieneResultPonderado($AIdSemana,$ATipoVenta,$condicion);
 $idx=0;
 while ($fila = mysqli_fetch_array($result)){  
  $metasMensuales = ObtieneMetaMensualSucursal(
   $AIdSemana,
   $ATipoVenta,
   $fila['aju03'],
   $fila['ano'],
   $fila['mes'], 
   $fila["aju04"] == 2 ? 0 : $fila["aju04"]
  ); 
  $ventaMeta = $fila["aju04"]==1 ? "Venta " : "Meta ";
	
  if($fila["aju04"]==1){
   $metasMensuales["porcentaje"] = $diferencia[17]<>0 ? ($metasMensuales["meta"]*100)/$diferencia[17] : 0;
  }
		
  $metas[$idx] = ObtieneLinea(
   $fila,
   $metasMensuales["porcentaje"],
   $metasMensuales['meta'],
   utf8_encode($ventaMeta.$fila["Nombre"]),
			$ATipoVenta
  );

  if($fila["aju04"]==2){
   $diferencia      =    array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
   $MetaSucursal     =    array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
   $totalesMeta = ObtieneSumatoria($totalesMeta,$fila,0,$metasMensuales["porcentaje"],$metasMensuales['meta']);
   $MetaSucursal = ObtieneSumatoria($MetaSucursal,$fila,0,$metasMensuales["porcentaje"],$metasMensuales['meta']);
   $diferencia = ObtieneSumatoria(
				 $diferencia,
					$fila,
					0,
					$metasMensuales["porcentaje"],
					$metasMensuales['meta']);
			$totalMetaPorcentaje =	$metasMensuales["porcentaje"];
			$totalMetaVenta = $metasMensuales['meta'];
  }else{
   $VentaSucursal    =    array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
   $totalesVenta = ObtieneSumatoria(
				$totalesVenta,
				$fila,
				0,
				$metasMensuales["porcentaje"],
				$metasMensuales['meta']
			);

   $VentaSucursal = ObtieneSumatoria(
				$VentaSucursal,
				$fila,
				0,
				$metasMensuales["porcentaje"],
				$metasMensuales['meta']
			);
			
			$totalVentaPorcentaje =	$metasMensuales["porcentaje"];
			$totalVentaVenta = $metasMensuales['meta'];
   
			$diferencia = ObtieneSumatoria(
				$VentaSucursal,
				$MetaSucursal,
				1,
				$metasMensuales["porcentaje"],
				$metasMensuales['meta']
			);
   
			$diferencia[16] = ($totalMetaPorcentaje - $totalVentaPorcentaje) * -1;
			$diferencia[17] = $totalVentaVenta - $totalMetaVenta;
   $idx++;
   
			$metas[$idx] = ObtieneLinea(
				$diferencia,
				$diferencia[16],
				$diferencia[17],
				utf8_encode("Diferencia {$fila['Nombre']}"),
				$ATipoVenta
			);
	
   $ventasWeb = ObtieneVentasWebSucursal(
				$AFechaInicio,
				$fila["aju03"],
				$fila["aju02"]
			);
 		if(!is_null($ventasWeb[1])){
    $idx++;
				$metas[$idx] = ObtieneLinea(
					$ventasWeb,
					$ventasWeb[16],
					$ventasWeb[17],
					utf8_encode("Venta Web ".$fila["Nombre"]),
					$ATipoVenta
				);

    $totalVentaSucursal = ObtieneSumatoria(
					$fila,
					$ventasWeb,
					0,
					"",
					"");
 
	   $totalesVentaWeb  = ObtieneSumatoria(
					$totalesVentaWeb,
					$ventasWeb,
					0,
					"",
					""
				);
    $idx++;
				$totalVentaSucursal = QuitarPorcentajesWeb($totalVentaSucursal);
    $metas[$idx] = ObtieneLinea(
					$totalVentaSucursal,
					$totalVentaSucursal[16],
					$totalVentaSucursal[17],
					utf8_encode("Total Ventas ".$fila["Nombre"]),
					$ATipoVenta
				);
   }
  }

  $idx++;
 }
	$totalesMeta = RecalculaPorcentajes(
	 $totalesMeta,
		$totalesMeta[15],
		$totalesMeta[17]
	);

	$totalesVenta = RecalculaPorcentajes(
		$totalesVenta,
		$totalesMeta[15],
		$totalesMeta[17]
	);

 $metas[$idx] = ObtieneLinea(
		$totalesMeta,
		$totalesMeta[16],
		$totalesMeta[17],
		"Total Meta",
		$ATipoVenta
	);
 $idx++;
 $metas[$idx] = ObtieneLinea(
		$totalesVenta,
		$totalesVenta[16],
		$totalesVenta[17],
		"Total Venta",
		$ATipoVenta);
 $idx++;
			if(!isset($metasMensuales)){
   $metasMensuales["porcentaje"]=0;
   $metasMensuales['meta']=0;
		}

 $diferencia = ObtieneSumatoria(
		$totalesVenta,
		$totalesMeta,
		1,
		$metasMensuales["porcentaje"],
		$metasMensuales['meta']);
 $metas[$idx] = ObtieneLinea(
		$diferencia,
		$totalesVenta[16] - $totalesMeta[16],
		$totalesVenta[17] - $totalesMeta[17],
		"Total Diferencia",
		$ATipoVenta
	);

 if($totalesVentaWeb[15]<>0){
  $idx++;
		$totalesVentaWeb = QuitarPorcentajesWeb($totalesVentaWeb);
  $metas[$idx] = ObtieneLinea($totalesVentaWeb,$totalesVentaWeb[16],$totalesVentaWeb[17],"Ventas Web",$ATipoVenta);
  $totalVentaGeneral = QuitarPorcentajesWeb(
		 ObtieneSumatoria($totalesVentaWeb,$totalesVenta,0,"",""));
  $idx++;
  $metas[$idx] = ObtieneLinea($totalVentaGeneral,$totalVentaGeneral[16],$totalVentaGeneral[17],"Total Ventas ",$ATipoVenta);
 }	
	$nombreCampo = array("sucursal","aju05","aju12","aju06","aju13","aju07","aju14","aju08","aju15","aju09","aju16","aju10","aju17","aju11","aju18","aju19","aju20","porcentaje","meta");
	$datos=[];
	$i=0;
	foreach ($metas as $registros => $registro) {
		$j = 0;
  foreach ($registro as $campos => $campo) {
			$datos[$i][$nombreCampo[$j]] = $campo;
			$j++;
		}
  $i++; 
	}
 return $datos;
}

function ObtieneResultPonderado($AIdSemana,$ATipoVenta,$condicion){
 $query =
  "select
    vajusteponderadosucursal.aju05,
    vajusteponderadosucursal.aju12,
    vajusteponderadosucursal.aju06,
    vajusteponderadosucursal.aju13,
    vajusteponderadosucursal.aju07, 
    vajusteponderadosucursal.aju14,
    vajusteponderadosucursal.aju08,
    vajusteponderadosucursal.aju15,
	   vajusteponderadosucursal.aju09,
   	vajusteponderadosucursal.aju16,
    vajusteponderadosucursal.aju10, 
    vajusteponderadosucursal.aju17,
    vajusteponderadosucursal.aju11, 
    vajusteponderadosucursal.aju18,
    vajusteponderadosucursal.aju19, 
    vajusteponderadosucursal.aju20,
    vajusteponderadosucursal.mes,
    vajusteponderadosucursal.ano,
    Nombre,
    vajusteponderadosucursal.aju01,
    vajusteponderadosucursal.aju02,
    vajusteponderadosucursal.aju03,
    vajusteponderadosucursal.aju04
	 from vajusteponderadosucursal
  where ((vajusteponderadosucursal.aju01 = $AIdSemana)
    and  (vajusteponderadosucursal.aju02 = $ATipoVenta)
    and  (vajusteponderadosucursal.aju04 in (1,2))
    $condicion)
  order by vajusteponderadosucursal.aju03, vajusteponderadosucursal.aju04 desc
 ";
 $result = ObtieneResulsetMySql($query);
 return $result;
}

function RecalculaPorcentajes($AArreglo,$AMetaSemanal,$AMetaMensual){
# 0 2 4 6 8 10 12 14
#	1 3 5 7 9 11 13 15
 for ($i=0; $i < 9; $i++) { 
		$j = $i*2;
		$AArreglo[$j] = $AMetaSemanal == 0 ? 0 : ($AArreglo[$j+1]*100)/$AMetaSemanal;
	}
	$AArreglo[16] = $AMetaSemanal == 0 ? 0 : ($AArreglo[17]*100)/$AMetaMensual;
 return $AArreglo;
}

function QuitarPorcentajesWeb($AArreglo){
# 0 2 4 6 8 10 12 14
#	1 3 5 7 9 11 13 15
 for ($i=0; $i < 9; $i++) { 
		$j = $i*2;
		$AArreglo[$j] = "";
	}
	$AArreglo[17] = "";
 return $AArreglo;
}
