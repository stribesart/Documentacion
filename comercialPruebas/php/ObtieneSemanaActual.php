<?php
/* por default devuelve el numero de semana del año
   para que devuelva el is de la  semana se tiene que mandar
   el parametro campo con el valor id
   campo=id
*/
  
 require('conexion.php');
  $campo = ObtieneRequest("campo","id");
  $semana = ObtieneValorCampoMySql(
     "vperiodossemanales",
     $campo,
     "where (date(now()) between FechaInicio and FechaTermino)"
  );

  header('Content-Type: application/json');
  echo json_encode($semana);