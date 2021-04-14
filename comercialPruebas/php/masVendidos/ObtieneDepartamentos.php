<?php
require_once("../ObtieneDatosTablaMySql.php");
$compras = BaseDatos("compras");
$datos = ObtieneDatosTablaMySql(
  " {$compras}departamentos",
  " departamentos.dep01,
  departamentos.dep02",
  "",
  "",
  "order by dep01"
 );
 header('Content-Type: application/json');
	echo json_encode($datos);