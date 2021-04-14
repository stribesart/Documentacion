<?php
require_once("../ObtieneDatosTablaMySql.php");
$compras = BaseDatos("compras");
$datos = ObtieneDatosTablaMySql(
  " {$compras}temporadas",
  " temporadas.tem01,
    temporadas.tem02",
  "",
  "where (temporadas.tem01 > 1)",
  "order by tem01 desc"
 );
 header('Content-Type: application/json');
	echo json_encode($datos);