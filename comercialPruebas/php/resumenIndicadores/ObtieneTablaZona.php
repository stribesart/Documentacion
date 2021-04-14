<?php
function ObtieneCondicionZona($AIdSucursal,$AIdZona){
 $condicion = "";
	
 if($AIdZona != 0 && $AIdSucursal==0){
  $condicion = " and (distrito.id = {$AIdZona})";
	}else{
		if($AIdSucursal != 0){
  	$rmetrics = BaseDatos("rmetrics");
   $idZona = ObtieneValorCampoMySql(
 		 "{$rmetrics}prada.tienda",
 			"idDistrito",
  		"where id =  {$AIdSucursal}"
 		);
   $condicion = " and (distrito.id = {$idZona})";
		}
	}
	 return  $condicion;	
}

function ObtieneTablaZona($AAnio,$AIdSemana,$AIdSucursal,$AIdZona,$ATipoVenta){
	$zonasVentas = [];
	$zonasPaseantes = [];
	$tabla = $ATipoVenta==0 ? "resumenindicadoreszonas" : "resumenindicadoreszonasmes";
 $resultZonas = ObtieneZonas($AAnio,$AIdSemana,$AIdSucursal,$AIdZona,$tabla);
	$i = 0;
 while ($rowZonas = mysqli_fetch_array($resultZonas)){
  $zonasVentas[$i] = AgregaRegistroArreglo($rowZonas);
  $i++;
 }
 $resultZonas = ObtieneZonasPaseantes($AAnio,$AIdSemana,$AIdSucursal,$AIdZona,$tabla);
	$i = 0;
 while ($rowZonas = mysqli_fetch_array($resultZonas)){
  $zonasPaseantes[$i] = AgregaRegistroPaseantes($rowZonas);
  $i++;
 }
	$tabla = $ATipoVenta==0 ? "resumenindicadoresprada" : "resumenindicadorespradames";
 $resultPrada = ObtienePradaVentas($AAnio,$AIdSemana,$tabla);
 $totales = mysqli_fetch_array($resultPrada);
	$zonasVentas[$i] = AgregaRegistroArreglo($totales);
 $resultPrada = ObtienePradaPaseantes($AAnio,$AIdSemana,$tabla);
 $totales = mysqli_fetch_array($resultPrada);
	$zonasPaseantes[$i] = AgregaRegistroPaseantes($totales);
 $datos["ZonasVentas"] =$zonasVentas;
 $datos["ZonasPaseantes"] = $zonasPaseantes;
 return $datos;

}

function ObtieneZonas($AAnio,$ASemana,$AIdSucursal,$AIdZona,$ATabla){
  $condicion = ObtieneCondicionZona($AIdSucursal,$AIdZona);  
  $query = "select 
   	distrito.nombre Zona,
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
    inner join rmetrics_prada.distrito on ({$ATabla}.res03 = distrito.id) 
    where (({$ATabla}.res01 = {$AAnio}) 
	  and   ({$ATabla}.res02 = {$ASemana} {$condicion}))
    group by {$ATabla}.res03
    order by distrito.nombre";
		$result = ObtieneResulsetMySql($query);
  return $result;
 }

/*
function ObtieneZonasMensual($AAnio,$AMes,$AIdSucursal,$AIdZona){
  $condicion = ObtieneCondicionZona($AIdSucursal,$AIdZona);  
		$semanas = ObtieneSemanasMes($AAnio,$AMes);
  $query = "select 
   	distrito.nombre Zona,
    format(sum(resumenindicadoreszonas.res04),0) `Meta Unidades`,
    format(sum(resumenindicadoreszonas.res05),0) `Venta Unidades`,
    concat(format(avg(resumenindicadoreszonas.res06),0),'%') `%`,
    format(sum(resumenindicadoreszonas.res07),2) `Meta Pesos`,
    format(sum(resumenindicadoreszonas.res27),0) `Tickets`,
    format(avg(resumenindicadoreszonas.res10),2) `TC`,
    format(avg(resumenindicadoreszonas.res11),2) `TP`,
    format(avg(resumenindicadoreszonas.res12),2) `PP`,
    format(avg(resumenindicadoreszonas.res13),2) `AXT`,
    format(resumenindicadoreszonas.res28,0) `Venta Orkestra`,
    concat(format(resumenindicadoreszonas.res29,0),'%') `% Orkestra`,
    format(sum(resumenindicadoreszonas.res14),0) `Venta Web Unidades`,
    format(sum(resumenindicadoreszonas.res15),2) `Venta Web Pesos`,
    format(sum(resumenindicadoreszonas.res16),0) `Venta Total Unidades`,
    format(sum(resumenindicadoreszonas.res17),2) `Venta Total Pesos`,
    resumenindicadoreszonas.res03
    from resumenindicadoreszonas
    inner join rmetrics_prada.distrito on (resumenindicadoreszonas.res03 = distrito.id) 
    where ((resumenindicadoreszonas.res01 = {$AAnio}) 
	  and   (resumenindicadoreszonas.res02 in ({$semanas}) {$condicion}))
    group by resumenindicadoreszonas.res03
    order by distrito.nombre";
		$result = ObtieneResulsetMySql($query);
  return $result;
 }
*/	

function ObtieneZonasPaseantes($AAnio,$ASemana,$AIdSucursal,$AIdZona,$ATabla){
 $condicion = ObtieneCondicionZona($AIdSucursal,$AIdZona);  
	$anioAnterior = $AAnio -1;
 $query = "select 
   	distrito.nombre Zona,
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
    inner join rmetrics_prada.distrito on ({$ATabla}.res03 = distrito.id) 
    where (({$ATabla}.res01 = {$AAnio}) 
	  and   ({$ATabla}.res02 = {$ASemana} {$condicion}))
    group by {$ATabla}.res03
    order by distrito.nombre";
  $result = ObtieneResulsetMySql($query);
  return $result;
 }
	
/*	
function ObtieneZonasPaseantesMensual($AAnio,$AMes,$AIdSucursal,$AIdZona){
 $condicion = ObtieneCondicionZona($AIdSucursal,$AIdZona);  
	$anioAnterior = $AAnio -1;
	$semanas = ObtieneSemanasMes($AAnio,$AMes);
 $query = "select 
   	distrito.nombre Zona,
    format(sum(resumenindicadoreszonas.res18),0) `{ $AAnio`,
    format(sum(resumenindicadoreszonas.res19),0) `{ $anioAnterior`,
    concat(format(avg(resumenindicadoreszonas.res20),0),'%') `%`,
    format(sum(resumenindicadoreszonas.res21),0) `{ $AAnio `,
    format(sum(resumenindicadoreszonas.res22),0) `{ $anioAnterior `,
    concat(format(avg(resumenindicadoreszonas.res23),0),'%') ` %  `,
    format(avg(resumenindicadoreszonas.res24),0) `{  $AAnio`,
    format(avg(resumenindicadoreszonas.res25),0) `{  $anioAnterior`,
    concat(format(avg(resumenindicadoreszonas.res26),0),'%') ` % `,
    resumenindicadoreszonas.res03
    from resumenindicadoreszonas
    inner join rmetrics_prada.distrito on (resumenindicadoreszonas.res03 = distrito.id) 
    where ((resumenindicadoreszonas.res01 = {$AAnio}) 
	  and   (resumenindicadoreszonas.res02 in ({$semanas}) $condicion))
    group by resumenindicadoreszonas.res03
    order by distrito.nombre";
  $result = ObtieneResulsetMySql($query);
  return $result;
 }
*/	