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
  $condicion = ($tipoUsuario == 3) 
   ? "where ((vsolicituduniformes.sol06 < 3) and (vsolicituduniformes.sol07 = {$idSucursal}))" 
   : "where (vsolicituduniformes.sol06 < 3)";
  $compras = BaseDatos("compras"); 	  
  $datos = ObtieneDatosTablaMySql(
   " {$compras}vsolicituduniformes",
   " vsolicituduniformes.Nombre,
    vsolicituduniformes.empleado Empleado,
    vsolicituduniformes.sol02 PLU,
    vsolicituduniformes.sol05 Fecha,
    vsolicituduniformes.sol10 `Fecha Envio`,
    vsolicituduniformes.fam04 Descripcion,
    vsolicituduniformes.dep02 Departamento,
    vsolicituduniformes.tem02 Temporada,
    vsolicituduniformes.tal02 `Descripcion Tienda`,
    vsolicituduniformes.sol03 Unidades,
    vsolicituduniformes.sol08 Descuento,
    vsolicituduniformes.estatus Estatus",
   "",
   $condicion,
   ""   
  );
 }
 header('Content-Type: application/json');
 echo json_encode($datos);
