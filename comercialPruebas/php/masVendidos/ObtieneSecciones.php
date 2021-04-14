<?php
require_once("../ObtieneDatosTablaMySql.php");
$compras = BaseDatos("compras");
$datos = ObtieneDatosTablaMySql(
  " {$compras}secciones",
  " secciones.sec01,
    secciones.sec03",
  "",
  "where ( length(sec03) > 0)",
  "order by sec03",
  false,
  "1,"
 );
 header('Content-Type: application/json');
	echo json_encode($datos);