<?php

/*
function ObtieneLineaZona($AFila,$APorcentajeMensual,$AMetaMensual,$ANombre,$ATipoVenta){
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

function ObtieneSumatoriaZona($ADestino,$AOrigen,$AOperacion,$APorcentaje,$AMeta){
 for ($i=0; $i <16 ; $i++) { 
  if(strlen($ADestino[$i])>0 && strlen($AOrigen[$i])>0){ 
   $ADestino[$i] = $AOperacion == 0 
   ? $ADestino[$i] + $AOrigen[$i] 
   : $ADestino[$i] - $AOrigen[$i];
  } 
 }
 if(strlen($APorcentaje)>0){
  $ADestino[16] = $AOperacion == 0 ? $ADestino[16] + $APorcentaje: $ADestino[16] - $APorcentaje;
 }
 if(strlen($AMeta)>0){
  $ADestino[17] = $AOperacion == 0 ? $ADestino[17] + $AMeta: $ADestino[17] - $AMeta;
 } 
 return $ADestino;
}

*/
function ObtieneVentasZona($AIdSemana,$ATipoVenta,$AIdZona,$AIdSucursal,$AFechaInicio){
 $condicion = "";//$AIdZona == 0 ? "" : " and (vajusteponderadosucursal.zon01 = $AIdZona)";
 #$condicion .= $AIdSucursal == 0 ? "" : " and (vajusteponderadosucursal.aju03 = $AIdSucursal)";
	$datos=[];

 $MetaSucursal    =    array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
 $totalesMeta =        array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
 $totalesVenta =       array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
 $diferencia =         array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
 $totalesVentaWeb =    array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
 $totalMetaPorcentaje=0;
 $totalMetaVenta=0;
	$totalVentaPorcentaje=0;
	$totalVentaVenta=0;

 $metas = [];
// $metas["titulos"] = ObtieneTitulos("Sucursal","Totales Mensuales");
// $metas["titulosSucursal"] = ObtieneTitulosSucursal();
 $result = ObtieneResultPonderadoZona($AIdSemana,$ATipoVenta,$condicion);
 $idx=0;
 while ($fila = mysqli_fetch_array($result)){  
  $metasMensuales = ObtieneMetaMensualZona(
   $AIdSemana,
   $ATipoVenta,
   $fila['zon01'],
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
	
   $ventasWeb = ObtieneVentasWebZona(
				$AFechaInicio,
				$fila["zon01"],
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
/*     */
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


	/*

	 $metas[$idx] = ObtieneLinea($totalesMeta,$totalesMeta[16],$totalesMeta[17],"Total Meta",$ATipoVenta);
 $idx++;
 $metas[$idx] = ObtieneLinea($totalesVenta,$totalesVenta[16],$totalesVenta[17],"Total Venta",$ATipoVenta);
 $idx++;
 $diferencia = ObtieneSumatoria($totalesMeta,$totalesVenta,1,$metasMensuales["porcentaje"],$metasMensuales['meta']);
 $metas[$idx] = ObtieneLinea($diferencia,$diferencia[16],$diferencia[17],"Total Diferencia",$ATipoVenta);
	if($totalesVentaWeb[15]<>0){
  $idx++;
		$totalesVentaWeb = QuitarPorcentajesWeb($totalesVentaWeb);
  $metas[$idx] = ObtieneLinea($totalesVentaWeb,$totalesVentaWeb[16],$totalesVentaWeb[17],"Ventas Web",$ATipoVenta);
  $totalVentaGeneral = ObtieneSumatoria($totalesVentaWeb,$totalesVenta,0,"","");
  $idx++;
		$totalVentaGeneral = QuitarPorcentajesWeb($totalVentaGeneral);
  $metas[$idx] = ObtieneLinea($totalVentaGeneral,$totalVentaGeneral[16],$totalVentaGeneral[17],"Total Zona:",$ATipoVenta);
 }
*/	
	$nombreCampo = array("sucursal","aju05","aju12","aju06","aju13","aju07","aju14","aju08","aju15","aju09","aju16","aju10","aju17","aju11","aju18","aju19","aju20","porcentaje","meta");
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

function ObtieneResultPonderadoZona($AIdSemana,$ATipoVenta,$condicion){
	$nomina = BaseDatos("nomina");
	$rmetrics = BaseDatos("rmetrics");
 $query =
  "select
    round(avg(ajusteponderadosucursal.aju05),0) aju05,
    sum(ajusteponderadosucursal.aju12) aju12,
    round(avg(ajusteponderadosucursal.aju06),0) aju06,
    sum(ajusteponderadosucursal.aju13) aju13,
    round(avg(ajusteponderadosucursal.aju07),0) aju07, 
    sum(ajusteponderadosucursal.aju14) aju14,
    round(avg(ajusteponderadosucursal.aju08),0) aju08,
    sum(ajusteponderadosucursal.aju15) aju15,
	   round(avg(ajusteponderadosucursal.aju09),0) aju09,
   	sum(ajusteponderadosucursal.aju16) aju16,
    round(avg(ajusteponderadosucursal.aju10),0) aju10, 
    sum(ajusteponderadosucursal.aju17) aju17,
    round(avg(ajusteponderadosucursal.aju11),0) aju11, 
    sum(ajusteponderadosucursal.aju18) aju18,
    round(avg(ajusteponderadosucursal.aju19),0) aju19, 
    sum(ajusteponderadosucursal.aju20) aju20,
    periodossemanales.mes,
    periodossemanales.ano,
    zonas.zon01,
    zonas.zon02 Nombre,
    ajusteponderadosucursal.aju01,
    ajusteponderadosucursal.aju02,
    ajusteponderadosucursal.aju04
	 from ajusteponderadosucursal
	 join {$nomina}dzonas on (ajusteponderadosucursal.aju03 = dzonas.dzo02)
		join {$nomina}zonas on (dzonas.dzo01 = zonas.zon01)
		inner join {$rmetrics}prada.periodossemanales on (ajusteponderadosucursal.aju01 = periodossemanales.id)
	  where ((ajusteponderadosucursal.aju01 = $AIdSemana)
    and  (ajusteponderadosucursal.aju02 = $ATipoVenta)
    and  (ajusteponderadosucursal.aju04 in (1,2))
    $condicion)
		group by zonas.zon01, ajusteponderadosucursal.aju04		
  order by zonas.zon01, ajusteponderadosucursal.aju04 desc
 ";
 $result = ObtieneResulsetMySql($query);
 return $result;
}

