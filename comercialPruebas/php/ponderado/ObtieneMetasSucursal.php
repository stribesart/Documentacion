<?php
function ObtieneMetasSucursal($AIdSemana,$ATipoVenta,$AIdZona,$AIdSucursal){
 $condicion = $AIdZona == 0 ? "" : " and (vajusteponderadosucursal.zon01 = $AIdZona)";
 $condicion .= $AIdSucursal == 0 ? "" : " and (vajusteponderadosucursal.aju03 = $AIdSucursal)";
 $totalesMeta = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
 $metas = [];
			/**
		"SELECT aju01,aju02,zon01,aju04,
		round(avg(aju05),0) aju05,round(avg(aju06),0) aju06,round(avg(aju07),0) aju07,round(avg(aju08),0) aju08,round(avg(aju09),0) aju09,
		round(avg(aju10),0) aju10,round(avg(aju11),0) aju11,
		sum(aju12) aju12,sum(aju13) aju13,sum(aju14) aju14,sum(aju15) aju15,sum(aju16) aju16,sum(aju17) aju17,sum(aju18) aju18,
		round(avg(aju19),0) aju19,sum(aju20) aju20,round(avg(aju21),0) aju21,sum(aju22) aju22,zon02,mes, ano
		FROM `pradaconfiguracion`.`ajusteponderadosucursal`
		join pradanomina.dzonas on aju03=dzo02
		join pradanomina.zonas on dzo01 = zon01
		inner join rmetrics_prada.periodossemanales on aju01=periodossemanales.id
		where ".$zonasExistentes." and  aju01 =".$semana." and aju02=".$tipo." and ".$aju04.
		" group by zon01,aju04 desc"
	 */

// $metas["titulos"] = ObtieneTitulos("Sucursal","Totales Mensuales");
// $metas["titulosSucursal"] = ObtieneTitulosSucursal();
 $query =
  "select
    Nombre,
    vajusteponderadosucursal.aju01,
    vajusteponderadosucursal.aju02,
    vajusteponderadosucursal.aju03,
    vajusteponderadosucursal.aju04,
    vajusteponderadosucursal.aju05,
    vajusteponderadosucursal.aju06,
    vajusteponderadosucursal.aju07, 
    vajusteponderadosucursal.aju08,
	   vajusteponderadosucursal.aju09,
    vajusteponderadosucursal.aju10, 
    vajusteponderadosucursal.aju11, 
    vajusteponderadosucursal.aju12,
    vajusteponderadosucursal.aju13,
    vajusteponderadosucursal.aju14,
    vajusteponderadosucursal.aju15,
   	vajusteponderadosucursal.aju16,
    vajusteponderadosucursal.aju17,
    vajusteponderadosucursal.aju18,
    vajusteponderadosucursal.aju19, 
    vajusteponderadosucursal.aju20,
    vajusteponderadosucursal.mes,
    vajusteponderadosucursal.ano
	 from vajusteponderadosucursal
   where ((vajusteponderadosucursal.aju01 = $AIdSemana)
     and  (vajusteponderadosucursal.aju02 = $ATipoVenta)
     and  (vajusteponderadosucursal.aju04 = 0)
     $condicion)
			order by aju03		";
 $decimales = $ATipoVenta == 0 ? 2 : 0;     
 $result = ObtieneResulsetMySql($query);
 $idx=0;
 while ($fila = mysqli_fetch_array($result)){  
  $metasMensuales = ObtieneMetaMensualSucursal(
   $AIdSemana, 
   $ATipoVenta,
   $fila['aju03'],
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

