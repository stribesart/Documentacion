<?php
 require_once("../conexion.php");
	$datos["request"] = $_REQUEST;

 $idSucursal = ObtieneRequest("idSucursal",0);
 $idUsuario = ObtieneRequest("idUsuario",0);
 $idEmpleado = ObtieneRequest("idEmpleado",0);	 
 $comentarios = ObtieneRequest("comentarios","");	 
$datos["parametros"] = array(
	"idSucursal" => $idSucursal,
	"idUsuario" => $idUsuario,
	"idEmpleado" => $idEmpleado,
	"comentarios" => $comentarios
);
/*
 $plu = ObtieneRequest("plu",array());	 

 $plus = count($plu);
 $compras = BaseDatos("compras");
 $solicitudes = "";
 $faltantes = "";
 for ($i = 0; $i < $plus; $i++) {
		$cantidad = ObtieneRequest($plu[$i],0);
  $datos[$plu[$i]]=array("Cantidad" => $cantidad);
 # $resultado = ObtieneValorFuncionMysql(
	#		"{$compras}GeneraSolicitudUniformes","{$plu[$i]},
	#		{$cantidad},{$idSucursal},{$idEmpleado},'{$comentarios}'"
	#	);
 # $ids = explode("|",$resultado);
 # if ($ids[0]>0){$solicitudes .= $ids[0].",";}
 # if ($ids[1]>0){$faltantes .= $ids[1].",";}
	}
 $solicitudes = trim($solicitudes,",");
 $faltantes = trim($faltantes,",");
# $datos = array(
#		$mensaje => ObtieneValorFuncionMysql(
#		"{$compras}GeneraCorreoPeticionUniformes",
#		"{$idUsuario},'{$solicitudes}','{$faltantes}'"
#	 )
#	);
*/
header('Content-Type: application/json');
echo json_encode($datos);