<?php

function ObtienePradaVentas($AAnio,$AIdSemana,$ATabla){
	$prada = "Prada";
	$query= "select 
    0,
   	'{$prada}',
    format(sum({$ATabla}.res04),0) `Meta Unidades`,
    format(sum({$ATabla}.res05),0) `Venta Unidades`,
    concat(format(avg({$ATabla}.res06),0),'%') `%`,
    format(sum({$ATabla}.res07),2) `Meta Pesos`,
    format(sum({$ATabla}.res08),2) `Venta Pesos`,
    concat(format(avg({$ATabla}.res09),0),'%') `% `,
    format(sum({$ATabla}.res27),0) `Tickets`,
    format(sum({$ATabla}.res10),2) `TC`,
    format(sum({$ATabla}.res11),2) `TP`,
    format(sum({$ATabla}.res12),2) `PP`,
    format(sum({$ATabla}.res13),2) `AXT`,
    format({$ATabla}.res28,2) `Venta Orkestra`,
    concat(format({$ATabla}.res29,0),'%') `% Orkestra`,
    format(sum({$ATabla}.res14),0) `Venta Web Unidades`,
    format(sum({$ATabla}.res15),2) `Venta Web Pesos`,
    format(sum({$ATabla}.res16),0) `Venta Total Unidades`,
    format(sum({$ATabla}.res17),2) `Venta Total Pesos`
    from {$ATabla}
    where (({$ATabla}.res01 = {$AAnio}) 
	  and   ({$ATabla}.res02 = {$AIdSemana}))";
	 $result = ObtieneResulsetMySql($query);
  return $result;
}

/*
function ObtienePradaVentasMensual($AAnio,$AMes,$ATabla){
	$prada = "Prada";
	$semanas = ObtieneSemanasMes($AAnio,$AMes);
 $query= "select 
    0,
   	'{$prada}',
    format(sum({$ATabla}.res04),0) `Meta Unidades`,
    format(sum({$ATabla}.res05),0) `Venta Unidades`,
    concat(format(avg({$ATabla}.res06),0),'%') `%`,
    format(sum({$ATabla}.res07),2) `Meta Pesos`,
    format(sum({$ATabla}.res08),2) `Venta Pesos`,
    concat(format(avg({$ATabla}.res09),0),'%') `% `,
    format(sum({$ATabla}.res27),0) `Tickets`,
    format(sum({$ATabla}.res10),2) `TC`,
    format(sum({$ATabla}.res11),2) `TP`,
    format(sum({$ATabla}.res12),2) `PP`,
    format(sum({$ATabla}.res13),2) `AXT`,
    format(sum({$ATabla}.res14),0) `Venta Web Unidades`,
    format(sum({$ATabla}.res15),2) `Venta Web Pesos`,
    format(sum({$ATabla}.res16),0) `Venta Total Unidades`,
    format(sum({$ATabla}.res17),2) `Venta Total Pesos`
    from {$ATabla}
    where (({$ATabla}.res01 = {$AAnio}) 
	  and   ({$ATabla}.res02 in ({$semanas}))";
	 $result = ObtieneResulsetMySql($query);
  return $result;
}
*/
function ObtienePradaPaseantes($AAnio,$ASemana,$ATabla){
	$prada = "Prada";
	$anioAnterior = $AAnio -1;
 $query= "select 
    0,
   	'{$prada}',
    format(sum({$ATabla}.res18),0) `{ $AAnio`,
    format(sum({$ATabla}.res19),0) `{ $anioAnterior`,
    concat(format(avg({$ATabla}.res20),0),'%') `%`,
    format(sum({$ATabla}.res21),0) `{ $AAnio `,
    format(sum({$ATabla}.res22),0) `{ $anioAnterior `,
    concat(format(avg({$ATabla}.res23),0),'%') ` %  `,
    concat(format(sum({$ATabla}.res24),2),'%') `{  $AAnio`,
    concat(format(sum({$ATabla}.res25),2),'%') `{  $anioAnterior`,
    concat(format(avg({$ATabla}.res26),0),'%') ` % `
    from {$ATabla}
    inner join rmetrics_prada.distrito on ({$ATabla}.res03 = distrito.id) 
    where (({$ATabla}.res01 = {$AAnio}) 
	  and   ({$ATabla}.res02 = {$ASemana}))";
  $result = ObtieneResulsetMySql($query);
  return $result;
 }
	
/*	
function ObtienePradaPaseantesMensual($AAnio,$AMes,$ATabla){
	$prada = "Prada";
	$semanas = ObtieneSemanasMes($AAnio,$AMes);
	$anioAnterior = $AAnio -1;
 $query= "select 
    0,
   	'{$prada}',
    format(sum({$ATabla}.res18),0) `{ $AAnio`,
    format(sum({$ATabla}.res19),0) `{ $anioAnterior`,
    concat(format(avg({$ATabla}.res20),0),'%') `%`,
    format(sum({$ATabla}.res21),0) `{ $AAnio `,
    format(sum({$ATabla}.res22),0) `{ $anioAnterior `,
    concat(format(avg({$ATabla}.res23),0),'%') ` %  `,
    format(sum({$ATabla}.res24),0) `{  $AAnio`,
    format(sum({$ATabla}.res25),0) `{  $anioAnterior`,
    concat(format(avg({$ATabla}.res26),0),'%') ` % `
    from {$ATabla}
    inner join rmetrics_prada.distrito on ({$ATabla}.res03 = distrito.id) 
    where (({$ATabla}.res01 = {$AAnio}) 
	  and   ({$ATabla}.res02 in ({$semanas}))";
  $result = ObtieneResulsetMySql($query);
  return $result;
 }
	
	*/