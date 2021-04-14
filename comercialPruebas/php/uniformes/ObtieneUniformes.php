<?php
 require_once("../conexion.php");
 require_once("../ObtieneDatosTablaMySql.php");

	$idPonderado = ObtieneRequest("idPonderado",0);
 $tipoUsuario = ObtieneRequest("tipoUsuario",4); 
 $idSucursal  = $tipoUsuario==3 ? $idPonderado : ObtieneRequest("idSucursal",0);

$datos=[];
if($tipoUsuario == 4){
		 $datos["Error"] = array("error" => "Tiene que indicar tipoUsuario ");
		 $datos["parametros"] = $_REQUEST;
	}else{
  $compras = BaseDatos("compras");
	 $datos = ObtieneDatosTablaMySql(
			" {$compras}vsolicituduniformes",
			" vsolicituduniformes.Nombre Sucursal,
     vsolicituduniformes.empleado Empleado,
     vsolicituduniformes.sol01,
     vsolicituduniformes.sol02 PLU,
     vsolicituduniformes.sol05 `Fecha Solicitud`,
     vsolicituduniformes.sol10 `Fecha Envio`,
     vsolicituduniformes.fam04 Descripcion,
     vsolicituduniformes.dep02 Departamento,
     vsolicituduniformes.cod10 `Descripcion Tienda`,
     vsolicituduniformes.tem02 Temporada,
     vsolicituduniformes.tal02 Talla,
     vsolicituduniformes.sol03 Unidades,
     vsolicituduniformes.sol08 Descuento,
     vsolicituduniformes.estatus Estatus
			",
			"",
			" where ((vsolicituduniformes.sol06 < 3) and (vsolicituduniformes.sol07 = {$idSucursal}))",
			" order by vsolicituduniformes.sol01"
		);
	}	
 header('Content-Type: application/json');
 echo json_encode($datos);
