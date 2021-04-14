<?php
function ObtieneMetasZonasResumen($AIdSemana,$ATipoVenta,$AIdZona,$AIdSucursal){
 $condicion = ""; //$AIdZona == 0 ? "" : " and (vajusteponderadosucursal.zon01 = $AIdZona)";
 #$condicion .= $AIdSucursal == 0 ? "" : " and (vajusteponderadosucursal.aju03 = $AIdSucursal)";
	$nomina = BaseDatos("nomina");
	$rmetrics = BaseDatos("rmetrics");
 $totalesMeta = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
 $metas = [];
// $metas["titulos"] = ObtieneTitulos("Sucursal","Totales Mensuales");
// $metas["titulosSucursal"] = ObtieneTitulosSucursal();
 $query =
  "select
    zonas.zon02 Nombre,
    ajusteponderadosucursal.aju01,
    ajusteponderadosucursal.aju02,
    ajusteponderadosucursal.aju03,
    ajusteponderadosucursal.aju04,
    round(avg(ajusteponderadosucursal.aju05),0) aju05,
    round(avg(ajusteponderadosucursal.aju06),0) aju06,
    round(avg(ajusteponderadosucursal.aju07),0) aju07, 
    round(avg(ajusteponderadosucursal.aju08),0) aju08,
	   round(avg(ajusteponderadosucursal.aju09),0) aju09,
    round(avg(ajusteponderadosucursal.aju10),0) aju10, 
    round(avg(ajusteponderadosucursal.aju11),0) aju11, 
    sum(ajusteponderadosucursal.aju12) aju12,
    sum(ajusteponderadosucursal.aju13) aju13,
    sum(ajusteponderadosucursal.aju14) aju14,
    sum(ajusteponderadosucursal.aju15) aju15,
   	sum(ajusteponderadosucursal.aju16) aju16,
    sum(ajusteponderadosucursal.aju17) aju17,
    sum(ajusteponderadosucursal.aju18) aju18,
    round(avg(ajusteponderadosucursal.aju19),0) aju19, 
    sum(ajusteponderadosucursal.aju20) aju20,
    round(avg(ajusteponderadosucursal.aju21),0) aju21, 
    round(avg(ajusteponderadosucursal.aju22),0) aju22, 
    periodossemanales.mes,
    periodossemanales.ano,
				zonas.zon01
	 from ajusteponderadosucursal
 	join {$nomina}dzonas on (ajusteponderadosucursal.aju03 = dzonas.dzo02)
		join {$nomina}zonas on (dzonas.dzo01 = zonas.zon01)
		inner join {$rmetrics}prada.periodossemanales on (ajusteponderadosucursal.aju01 = periodossemanales.id)
		where ((ajusteponderadosucursal.aju01 = $AIdSemana)
     and  (ajusteponderadosucursal.aju02 = $ATipoVenta)
     and  (ajusteponderadosucursal.aju04 = 0))
  group by zonas.zon01,ajusteponderadosucursal.aju04 
		order by zon01					
	";
 $decimales = $ATipoVenta == 0 ? 2 : 0;     
 $result = ObtieneResulsetMySql($query);
 $idx=0;
 while ($fila = mysqli_fetch_array($result)){  
  $metasMensuales = ObtieneMetaMensualZona(
   $AIdSemana, 
   $ATipoVenta,
   $fila['zon01'],
   $fila['ano'],
   $fila['mes'],
  0); 
  $metas[$idx] = array(
   "sucursal" => utf8_encode($fila["Nombre"]),
   "aju05" => number_format($fila['aju05'],0)."%",
   "aju12" => number_format($fila['aju12'],$decimales),
   "aju06" => number_format($fila['aju06'],0)."%",
   "aju13" => number_format($fila['aju13'],$decimales),
   "aju07" => number_format($fila['aju07'],0)."%",
   "aju14" => number_format($fila['aju14'],$decimales),
   "aju08" => number_format($fila['aju08'],0)."%",
   "aju15" => number_format($fila['aju15'],$decimales),
   "aju09" => number_format($fila['aju09'],0)."%",
   "aju16" => number_format($fila['aju16'],$decimales),
   "aju10" => number_format($fila['aju10'],0)."%",
   "aju17" => number_format($fila['aju17'],$decimales),
   "aju11" => number_format($fila['aju11'],0)."%",
   "aju18" => number_format($fila['aju18'],$decimales),
   "aju19" => number_format($fila['aju19'],0)."%",
   "aju20" => number_format($fila['aju20'],$decimales),
   "porcentaje" => number_format($metasMensuales['porcentaje'],0)."%",
   "meta" => number_format($metasMensuales['meta'],$decimales)
  ); 
  for ($j=7; $j<14; $j++){
   $totalesMeta[$j] += $fila[$j+5];
   $totalesMeta[15] += $fila[$j+5];
  }
  $totalesMeta[17] += $metasMensuales['meta'];
  $idx++;
 }
 
 for ($j=0; $j<7; $j++){
  $totalesMeta[$j] = $totalesMeta[15]<>0 ? ($totalesMeta[$j+7]*100)/$totalesMeta[15] : 0;
 }
 $totalesMeta[14] = 100;
 $totalesMeta[16] = 100;
 $metas[$idx] = array(
  "sucursal" => utf8_encode("Total"),
  "aju05" => number_format($totalesMeta[0],0)."%",
  "aju12" => number_format($totalesMeta[7],$decimales),
  "aju06" => number_format($totalesMeta[1],0)."%",
  "aju13" => number_format($totalesMeta[8],$decimales),
  "aju07" => number_format($totalesMeta[2],0)."%",
  "aju14" => number_format($totalesMeta[9],$decimales),
  "aju08" => number_format($totalesMeta[3],0)."%",
  "aju15" => number_format($totalesMeta[10],$decimales),
  "aju09" => number_format($totalesMeta[4],0)."%",
  "aju16" => number_format($totalesMeta[11],$decimales),
  "aju10" => number_format($totalesMeta[5],0)."%",
  "aju17" => number_format($totalesMeta[12],$decimales),
  "aju11" => number_format($totalesMeta[6],0)."%",
  "aju18" => number_format($totalesMeta[13],$decimales),
  "aju19" => number_format($totalesMeta[14],0)."%",
  "aju20" => number_format($totalesMeta[15],$decimales),
  "porcentaje" => number_format($totalesMeta[16],0)."%",
  "meta" => number_format($totalesMeta[17],$decimales)
 ); 

 return $metas;
}

