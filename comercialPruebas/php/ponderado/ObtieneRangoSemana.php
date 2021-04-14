<?php

function ObtieneRangoSemana($AIdSemana){
 $query =  "
  select 
   vperiodossemanales.periodo,
   vperiodossemanales.FechaInicio,
   vperiodossemanales.FechaTermino 
  from vperiodossemanales 
  where (id = $AIdSemana)";
 $result = ObtieneResulsetMySql($query);
 $fila = mysqli_fetch_array($result);
 $registros = [];
 if (is_Null($fila)) {
  $registros[0]= array("Error" => "No se localizo la semana $AIdSemana");
 }else{
  $registros[0] = Array(
    "periodo" => $fila[0],
    "FechaInicio" => $fila[1],
   "FechaTermino " => $fila[2]
  ); 
 }
return $registros;
}