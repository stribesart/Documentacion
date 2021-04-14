<?php
include_once("../conexion.php");
include_once("../ObtieneDatosTablaMySql.php");

 $idSucursal = ObtieneRequest("idSucursal",0);

 if($idSucursal == 0){
	 $datos["Error"] = array("error" => "Tiene que indicar Sucursal ");
		 $datos["parametros"] = $_REQUEST;
	}else{	
		$datos=[];
 	$nomina = BaseDatos("nomina");

 	$datos = ObtieneDatosTablaMySql( 
 		" {$nomina}vsicoss ",
 		" vsicoss.sic01 vsi01,
 			 vsicoss.nombre vsi02",
 		"",
 		"where ((vsicoss.sic05 in 
	 	 (select nombre from rmetrics_prada.tienda 
	 		 where id = {$idSucursal}))
       and  (vsicoss.sic28 <> 'B'))",
	 			"order by  nombre"	
 	);
	
	}
 header('Content-Type: application/json');
 echo json_encode($datos);
