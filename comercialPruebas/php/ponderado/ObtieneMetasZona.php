<?php
function ObtieneMetasZona($AIdSemana,$ATipoVenta,$AIdZona){
 $condicion = $AIdZona == 0 ? "" : " and (ajusteponderado.aju03 = $AIdZona)";
 $metas = [];
 $metas['titulos'] = ObtieneTitulos("","");
 $query =
  "select
    ajusteponderado.aju01,
    ajusteponderado.aju02,
    ajusteponderado.aju03,
    sum(ajusteponderado.aju04) as aju04,
    avg(ajusteponderado.aju05) as aju05,
    avg(ajusteponderado.aju06) as aju06,
    avg(ajusteponderado.aju07) as aju07, 
    avg(ajusteponderado.aju08) as aju08,
	   avg(ajusteponderado.aju09) as aju09,
    avg(ajusteponderado.aju10) as aju10, 
    avg(ajusteponderado.aju11) as aju11, 
    sum(ajusteponderado.aju12) as aju12,
    sum(ajusteponderado.aju13) as aju13,
    sum(ajusteponderado.aju14) as aju14,
    sum(ajusteponderado.aju15) as aju15,
   	sum(ajusteponderado.aju16) as aju16,
    sum(ajusteponderado.aju17) as aju17,
    sum(ajusteponderado.aju18) as aju18,
    ajusteponderado.aju19, 
    sum(ajusteponderado.aju20) as aju20
	  from ajusteponderado
   where ((ajusteponderado.aju01 = $AIdSemana)
     and  (ajusteponderado.aju02 = $ATipoVenta)
     $condicion)";
 $decimales = $ATipoVenta == 0 ? 2 : 0;    
 $result = ObtieneResulsetMySql($query);
 $fila = mysqli_fetch_assoc($result);   
	if($fila){ 
  $metas['porcentajes'] = array(
    "aju05" => number_format($fila['aju05'],0)."%",
    "aju06" => number_format($fila['aju06'],0)."%",
    "aju07" => number_format($fila['aju07'],0)."%",
    "aju08" => number_format($fila['aju08'],0)."%",
    "aju09" => number_format($fila['aju09'],0)."%",
    "aju10" => number_format($fila['aju10'],0)."%",
    "aju11" => number_format($fila['aju11'],0)."%",
    "aju19" => number_format($fila['aju19'],0)."%"
  ); 
  $metas['valores'] = array(
   "aju12" => number_format($fila['aju12'],$decimales),
   "aju13" => number_format($fila['aju13'],$decimales),
   "aju14" => number_format($fila['aju14'],$decimales),
   "aju15" => number_format($fila['aju15'],$decimales),
   "aju16" => number_format($fila['aju16'],$decimales),
   "aju17" => number_format($fila['aju17'],$decimales),
   "aju18" => number_format($fila['aju18'],$decimales),
   "aju20" => number_format($fila['aju20'],$decimales)
  ); 
	}
 return $metas;
}