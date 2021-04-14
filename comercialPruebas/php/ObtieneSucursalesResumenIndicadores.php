<?php
function ObtieneSucursaleResumenIndicadores($AAnio, $ASemana, $AIdSucursal,$AIdZona){
	$datos = [];
 $condicion = $AIdSucursal > 0 ? " and (tienda.id = {$AIdSucursal}) " : "";
	$condicion .= $AIdZona > 0 ? " and (distrito.id = {$AIdZona})" : "";
 $rmetrics = BaseDatos('rmetrics')."prada.";
	$nsemana = ObtieneValorCampoMySql(
		"vperiodossemanales",
		"nsemana",
		"where (id = {$ASemana})"
	);
 $datos = ObtieneDatosTablaMySql(
  " {$rmetrics}ventasemana",
  " distinct
    tienda.id dzo02,
    tienda.nombre dzo04",
  "	inner join {$rmetrics}tienda on (ventasemana.IdTienda = tienda.id)
    inner join {$rmetrics}distrito on (tienda.IdDistrito = distrito.id)",
  "  where ((ventasemana.ano = {$AAnio})
  and  (ventasemana.semana = {$nsemana})
  {$condicion})",
  "order by tienda.nombre"  
 );
 return $datos;
}