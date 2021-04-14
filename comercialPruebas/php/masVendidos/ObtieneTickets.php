<?php
require_once("../conexion.php");
 require_once("../ObtieneDatosTablaMySql.php");
	require_once("ObtieneCondicionArticulos.php");
	 function ObtieneFechaInicial(){
  $mes = date('m');
  $ano = date('Y');
  $fecha_actual = date('Y-m-d', mktime(0,0,0, $mes, 1, $ano));
  return date("Y-m-d",strtotime($fecha_actual."- 1 month"));
 }

	$parametros["cbSucursales"]    = ObtieneRequest("cbSucursales","");
	$parametros["cbDepartamento"]  = ObtieneRequest("cbDepartamento","");
	$parametros["cbZonas"]         = ObtieneRequest("cbZonas","");
	$parametros["cbSeccion"]       = ObtieneRequest("cbSeccion","");
	$parametros["idTemporada"]     = ObtieneRequest("idTemporada",0);
 $parametros["idZona"]          = $parametros["cbZonas"] == "on" ? ObtieneRequest("idZonas",0) : 0;
	$parametros["idSucursal"]      = $parametros["cbSucursales"] == "on" ? ObtieneRequest("idSucursales",0) : 0;
 $parametros["idDepartamento"]  = $parametros["cbDepartamento"] == "on" ? ObtieneRequest("idDepartamento",0) : 0;
 $parametros["idSeccion"]       = $parametros["cbSeccion"] == "on" ? ObtieneRequest("idSeccion",0) : 0;
 $parametros["fechaInicial"]    = ObtieneRequest("fechaInicial",ObtieneFechaInicial());
 $parametros["fechaFinal"]      = ObtieneRequest("fechaFinal",date('Y-m-d'));
 $parametros["tipoConsulta"]    = ObtieneRequest("tipoConsulta",0);
 $parametros["tipoUsuario"]     = ObtieneRequest("tipoUsuario",4);
 $parametros["idPonderado"]     = ObtieneRequest("idPonderado",0);
 $parametros["codigoPrada"]     = ObtieneRequest("codigoPrada",0);

if($parametros["tipoUsuario"] == 4 || $parametros["idTemporada"] == 0){
		$datos["Error"] = array("error" => "Tiene que indicar Temporada y tipoUsuario ");
		$datos["parametros"] = $_REQUEST;
	}else{   $facturacion = BaseDatos("facturacion");
 $compras = BaseDatos("compras");
	$condicion   = ObtieneCondicionArticulos($parametros);
 $datos = ObtieneDatosTablaMySql(
 " {$facturacion}dticketsmasvendidos",
 " sucursal.suc03,
   dticketsmasvendidos.dti03 Ticket,
   dticketsmasvendidos.tic04 Fecha,
   codigoprada.cod10 as Descripcion,
   dticketsmasvendidos.dti06 Unidades,
   format(dticketsmasvendidos.dti08,2) Precio,
   format(dticketsmasvendidos.dti08 * dticketsmasvendidos.dti06,2) as Venta",
 " inner join {$compras}modelo on (dticketsmasvendidos.dti18 = modelo.mod05)
   inner join {$compras}codigoprada on (modelo.mod07 = codigoprada.cod01)
   inner join {$compras}tallas on (modelo.mod04 = tallas.tal01)
   inner join {$compras}colores on (modelo.mod03 = colores.col01)
   inner join sucursal on (dticketsmasvendidos.dti01 = sucursal.suc01)",
 " where (((dticketsmasvendidos.dti09 - dticketsmasvendidos.dti14) <> 0) 
     and  (modelo.mod01 = {$parametros["idTemporada"]}) 
     and  (dticketsmasvendidos.tic04 between '{$parametros["fechaInicial"]}' and '{$parametros["fechaFinal"]}')
     and  (modelo.mod07 = {$parametros["codigoPrada"]})
     {$condicion}
   )",
 " order by  dticketsmasvendidos.tic04, sucursal.suc03"
 );
}

 header('Content-Type: application/json');
 echo json_encode($datos);