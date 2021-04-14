<?php
require_once("../conexion.php");
require_once("../ObtieneDatosTablaMySql.php");
$tipoUsuario = ObtieneRequest("tipoUsuario",0);
$idSucursal = ObtieneRequest("idSucursal",0);
$nomina = BaseDatos("nomina");
$join = $tipoUsuario==3 
  ? "inner join {$nomina}dzonas on (zonas.zon01 = dzonas.dzo01) " : "";   
$condicion = $tipoUsuario==3 ? "and (dzonas.dzo02 = $idSucursal)" :"";   
$datos = ObtieneDatosTablaMySql(
  " {$nomina}zonas",
  " zonas.zon01,
    zonas.zon02",
  $join,
  " where ((zon01<13) {$condicion})",
  " order by zon02"
 );
 header('Content-Type: application/json');
 echo json_encode($datos);