<?php

function ObtieneSemanasMes($AAnio, $AMes){
	$semanas = "";
	$rmetrics = BaseDatos("rmetrics"); 
 $query = "
	 select nsemana 
		from {$rmetrics}prada.periodossemanales
  where ((ano = {$AAnio})
		  and  (mes = {$AMes}))
	 ";
 $result = ObtieneResulsetMySql($query);
	$i = 0;
	while ($fila = mysqli_fetch_array($result)){
  $semanas .= "{$fila[0]},";
  $i++;
	}
	return trim($semanas, ',');
}