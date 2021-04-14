<?php
 require_once("../conexion.php");
 require_once("../ObtieneDatosTablaMySql.php");

 $ids = ObtieneRequest("ids","");

 $compras = BaseDatos("compras");
 $datos = ObtieneDatosTablaMySql(
		"{$compras}vsolicituduniformes",
  " vsolicituduniformes.Nombre as Sucursal, 
    vsolicituduniformes.empleado as Empleado, 
    vsolicituduniformes.sol02 as PLU, 
    vsolicituduniformes.fam04 as Descripcion, 
    vsolicituduniformes.dep02 as Departamento,
    vsolicituduniformes.imagen as Temporada,
    vsolicituduniformes.cod10 as `Descripcion Tienda`,
    vsolicituduniformes.tem02 as Temporada, 
    vsolicituduniformes.tal02 as Talla,
    vsolicituduniformes.sol03 as Unidades,
    vsolicituduniformes.sol08 as Descuento",
    "",
				"where vsolicituduniformes.sol01 in ({$ids})",
				""
	);

header('Content-Type: application/json');
echo json_encode($datos);
