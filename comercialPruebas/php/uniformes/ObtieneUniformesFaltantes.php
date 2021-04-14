<?php
 require_once("../conexion.php");
 require_once("../ObtieneDatosTablaMySql.php");
 $tipoUsuario = ObtieneRequest("tipoUsuario",4);
 $idPonderado = ObtieneRequest("idPonderado",0);
 $idSucursal = ObtieneRequest("idSucursal",0);
 if($tipoUsuario == 4){
  $datos["Error"] = array("error" => "Tiene que indicar tipoUsuario");
  $datos["parametros"] = array(
   "idPonderado" => $idPonderado,
   "tipoUsuario" =>$tipoUsuario, 
   "IdSucursal" => $idSucursal
  );
 }else{
  $idSucursal = $tipoUsuario == 3 ? $idPonderado : $idSucursal; 
  $condicion = $tipoUsuario == 3 ? "where vuniformesfaltantes.uni03 = {$idSucursal}" : "";	
  $compras = BaseDatos("compras");
  $datos = ObtieneDatosTablaMySql(
   " {$compras}vuniformesfaltantes",
   " vuniformesfaltantes.Nombre Sucursal,
     vuniformesfaltantes.empleado Empleado,
     vuniformesfaltantes.uni04 PLU,
     vuniformesfaltantes.uni06 Fecha,
     vuniformesfaltantes.fam04 Descripcion,
     vuniformesfaltantes.dep02 Departamento,
     vuniformesfaltantes.cod10 `Descripcion Tienda`,
     vuniformesfaltantes.tem02 Temporada,
     vuniformesfaltantes.tal02 Talla,
     vuniformesfaltantes.uni05 Unidades",
   "",
   "{$condicion}",
   ""   
  );
 }
 header('Content-Type: application/json');
 echo json_encode($datos);

