<?php

function ObtieneTablaSucursal($AAnio,$AIdSemana,$AIdSucursal,$AIdZona,$ATipoVenta){
	$sucursalesVentas = [];
	$sucursalesPaseantes = [];
 $tabla = $ATipoVenta==0 ? "resumenindicadoressucursal" : "resumenindicadoressucursalmes" ;
 $resultSucursales = ObtieneSucursal($AAnio,$AIdSemana,$AIdSucursal,$AIdZona,$tabla);
 $i = 0;
 while ($rowSucursales = mysqli_fetch_array($resultSucursales)){
  $sucursalesVentas[$i] = AgregaRegistroArreglo($rowSucursales);
  $i++;
 }
 $resultSucursales = ObtieneSucursalPaseantes($AAnio,$AIdSemana,$AIdSucursal,$AIdZona,$tabla);
	$i = 0;
 while ($rowSucursales = mysqli_fetch_array($resultSucursales)){
  $sucursalesPaseantes[$i] = AgregaRegistroPaseantes($rowSucursales);
  $i++;
 }
 $datos["SucursalesVentas"] =$sucursalesVentas;
 $datos["SucursalesPaseantes"] = $sucursalesPaseantes;

 return $datos;
}

 function ObtieneSucursal($AAnio,$ASemana,$ASucursal,$AZona,$ATabla){
  $condicionZona = $AZona != 0 ? " and (tienda.IdDistrito =  ".$AZona.")" : "";
  $condicion = $ASucursal != 0 ? " and (tienda.id  =  ".$ASucursal.")" : "";
  $query= "select 
   	tienda.nombre Sucursal,
    format({$ATabla}.res04,0) `Meta Unidades`,
    format({$ATabla}.res05,0) `Venta Unidades`,
    concat(format({$ATabla}.res06,0),'%') `%`,
    format({$ATabla}.res07,2) `Meta Pesos`,
    format({$ATabla}.res08,2) `Venta Pesos`,
    concat(format({$ATabla}.res09,0),'%') `% `,
    format({$ATabla}.res27,0) `Tickets`,
    format({$ATabla}.res10,2) `TC`,
    format({$ATabla}.res11,2) `TP`,
    format({$ATabla}.res12,2) `PP`,
    format({$ATabla}.res13,2) `AXT`,
    format({$ATabla}.res28,2) `Venta Orkestra`,
    concat(format({$ATabla}.res29,0),'%') `% Orkestra`,
    format({$ATabla}.res14,0) `Venta Web Unidades`,
    format({$ATabla}.res15,2) `Venta Web Pesos`,
    format({$ATabla}.res16,0) `Venta Total Unidades`,
    format({$ATabla}.res17,2) `Venta Total Pesos`,
    {$ATabla}.res03
    from {$ATabla}
    inner join rmetrics_prada.tienda on ({$ATabla}.res03 = tienda.id) 
    inner join rmetrics_prada.distrito on (tienda.IdDistrito = distrito.id)
    where (({$ATabla}.res01 = {$AAnio}) 
	  and   ({$ATabla}.res02 = {$ASemana}) {$condicion} {$condicionZona})
    group by {$ATabla}.res03
    order by {$ATabla}.res03";
  $result = ObtieneResulsetMySql($query);
  return $result;
 }

/*
 function ObtieneSucursalMensual($AAnio,$AMes,$ASucursal,$AZona){
  $condicionZona = $AZona != 0 ? " and (tienda.IdDistrito =  ".$AZona.")" : "";
  $condicion = $ASucursal != 0 ? " and (tienda.id  =  ".$ASucursal.")" : "";
		$semanas = ObtieneSemanasMes($AAnio,$AMes);
  $query= "select 
   	tienda.nombre Sucursal,
    format(sum({$ATabla}.res04),0) `Meta Unidades`,
    format(sum({$ATabla}.res05),0) `Venta Unidades`,
    concat(format(avg({$ATabla}.res06),0),'%') `%`,
    format(sum({$ATabla}.res07),2) `Meta Pesos`,
    format(sum({$ATabla}.res08),2) `Venta Pesos`,
    concat(format(avg({$ATabla}.res09),0),'%') `% `,
    format(sum({$ATabla}.res27),0) `Tickets`,
    format(avg({$ATabla}.res10),2) `TC`,
    format(avg({$ATabla}.res11),2) `TP`,
    format(avg({$ATabla}.res12),2) `PP`,
    format(avg({$ATabla}.res13),2) `AXT`,
    format(sum({$ATabla}.res14),0) `Venta Web Unidades`,
    format(sum({$ATabla}.res15),2) `Venta Web Pesos`,
    format(sum({$ATabla}.res16),0) `Venta Total Unidades`,
    format(sum({$ATabla}.res17),2) `Venta Total Pesos`,
    {$ATabla}.res03
    from {$ATabla}
    inner join rmetrics_prada.tienda on ({$ATabla}.res03 = tienda.id) 
    inner join rmetrics_prada.distrito on (tienda.IdDistrito = distrito.id)
    where (({$ATabla}.res01 = {$AAnio}) 
	  and   ({$ATabla}.res02 in ({$semanas})) {$condicion} {$condicionZona})
    group by {$ATabla}.res03
    order by {$ATabla}.res03";
  $result = ObtieneResulsetMySql($query);
  return $result;
 }
*/	

 function ObtieneSucursalPaseantes($AAnio,$ASemana,$ASucursal,$AZona,$ATabla){
  $condicionZona = $AZona != 0 ? " and (tienda.IdDistrito =  ".$AZona.")" : "";
  $condicion = $ASucursal != 0 ? " and (tienda.id  =  ".$ASucursal.")" : "";
		$anioAnterior = $AAnio -1;
  $query= "select 
   	tienda.nombre Sucursal,
    format({$ATabla}.res18,0) `{ $AAnio`,
    format({$ATabla}.res19,0) `{ $anioAnterior`,
    concat(format({$ATabla}.res20,0),'%') `%`,
    format({$ATabla}.res21,0) `{ $AAnio `,
    format({$ATabla}.res22,0) `{ $anioAnterior `,
    concat(format({$ATabla}.res23,0),'%') ` %  `,
    concat(format({$ATabla}.res24,2),'%') `{  $AAnio`,
    concat(format({$ATabla}.res25,2),'%') `{  $anioAnterior`,
    concat(format({$ATabla}.res26,0),'%') ` % `,
    {$ATabla}.res03
    from {$ATabla}
    inner join rmetrics_prada.tienda on ({$ATabla}.res03 = tienda.id) 
    inner join rmetrics_prada.distrito on (tienda.IdDistrito = distrito.id)
    where (({$ATabla}.res01 = {$AAnio}) 
	  and   ({$ATabla}.res02 = {$ASemana}) {$condicion} {$condicionZona})
    group by {$ATabla}.res03
    order by {$ATabla}.res03";
  $result = ObtieneResulsetMySql($query);
  return $result;
 }

/*
 function ObtieneSucursalPaseantesMensual($AAnio,$ASemana,$ASucursal,$AZona){
  $condicionZona = $AZona != 0 ? " and (tienda.IdDistrito =  ".$AZona.")" : "";
  $condicion = $ASucursal != 0 ? " and (tienda.id  =  ".$ASucursal.")" : "";
		$anioAnterior = $AAnio -1;
  $query= "select 
   	tienda.nombre Sucursal,
    format(sum({$ATabla}.res18),0) `{ $AAnio}`,
    format(sum({$ATabla}.res19),0) `{ $anioAnterior}`,
    concat(format(avg({$ATabla}.res20),0),'%') `%`,
    format(sum({$ATabla}.res21),0) `{ $AAnio }`,
    format(sum({$ATabla}.res22),0) `{ $anioAnterior }`,
    concat(formatavg(({$ATabla}.res2)3,0),'%') ` %  `,
    format(avg({$ATabla}.res24),0) `{  $AAnio}`,
    format(avg({$ATabla}.res25),0) `{  $anioAnterior}`,
    concat(format(avg({$ATabla}.res26),0),'%') ` % `,
    {$ATabla}.res03
    from {$ATabla}
    inner join rmetrics_prada.tienda on ({$ATabla}.res03 = tienda.id) 
    inner join rmetrics_prada.distrito on (tienda.IdDistrito = distrito.id)
    where (({$ATabla}.res01 = {$AAnio}) 
	  and   ({$ATabla}.res02 = {$ASemana}) {$condicion} {$condicionZona})
    group by {$ATabla}.res03
    order by {$ATabla}.res03";
  $result = ObtieneResulsetMySql($query);
  return $result;
 }
*/