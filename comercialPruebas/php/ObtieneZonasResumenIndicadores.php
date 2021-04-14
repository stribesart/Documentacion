<?php
function ObtieneZonasResumenIndicadores($AAnio, $ASemana,$ATipoUsuario, $AIdSucursal,$ATipoVenta,$AIdMes){
	$datos = [];
 $condicion = $ATipoUsuario==3 ? " and (tienda.id =$AIdSucursal) " : "";
 $rmetrics = BaseDatos('rmetrics')."prada.";
 if($ATipoVenta==0){
 	$nsemana = ObtieneValorCampoMySql(
 		"vperiodossemanales",
 		"nsemana",
 		"where (id = {$ASemana})"
 	);
 	$condicion .= " and (ventasemana.semana = {$nsemana})";
	}else{	
	 $semanas = ObtieneSemanasMes($AAnio,$AIdMes);
	 $condicion .= " and (ventasemana.semana in ({$semanas}))";
	}
 $datos = ObtieneDatosTablaMySql(
  " {$rmetrics}ventasemana",
  " distinct
    distrito.id zon01,
    distrito.nombre zon02",
  "	inner join {$rmetrics}tienda on (ventasemana.IdTienda = tienda.id)
    inner join {$rmetrics}distrito on (tienda.IdDistrito = distrito.id)",
  "  where ((ventasemana.ano = $AAnio)
   {$condicion})",
  "order by distrito.nombre",false
 );
 return $datos;

}