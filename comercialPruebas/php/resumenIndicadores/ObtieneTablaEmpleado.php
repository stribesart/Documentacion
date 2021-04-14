<?php
function ObtieneTablaEmpleado($AAnio,$AIdSemana,$AIdSucursal,$ATipoVenta){
  $data=[];
	 $tabla = $ATipoVenta==0 ? "resumenindicadoresvendedor" : "resumenindicadoresvendedormes" ;
		$resultEmpleados = ObtieneEmpleados($AAnio,$AIdSemana,$AIdSucursal,$tabla);
	 $i = 0;
	 while ($rowEmpleados = mysqli_fetch_array($resultEmpleados)){
   $data[$i] = AgregaRegistroArreglo($rowEmpleados);
   $i++;
  }

  return $data;
}

 function ObtieneEmpleados($AAnio,$ASemana,$ASucursal,$ATabla){
  $query= "select 
   	vendedores.nombre,
    format({$ATabla}.res05,0) `Meta Unidades`,
    format({$ATabla}.res06,0) `Venta Unidades`,
    concat(format({$ATabla}.res07,0),'%') `%`,
    format({$ATabla}.res08,2) `Meta Pesos`,
    format({$ATabla}.res09,2) `Venta Pesos`,
    concat(format({$ATabla}.res10,0),'%') `% `,
    format({$ATabla}.res19,0) `Tickets`,
    format({$ATabla}.res11,2) `TC`,
    format({$ATabla}.res12,2) `TP`,
    format({$ATabla}.res13,2) `PP`,
    format({$ATabla}.res14,2) `AXT`,
    format({$ATabla}.res20,2) `Venta Orkestra`,
    concat(format({$ATabla}.res21,0),'%') `% Orkestra`,
    format({$ATabla}.res15,0) `Venta Web Unidades`,
    format({$ATabla}.res16,2) `Venta Web Pesos`,
    format({$ATabla}.res17,0) `Venta Total Unidades`,
    format({$ATabla}.res18,2) `Venta Total Pesos`,
    {$ATabla}.res03
			 from {$ATabla}
  	inner join rmetrics_prada.vendedores on ({$ATabla}.res04 = vendedores.id) 
   where (({$ATabla}.res01 = {$AAnio}) 
	    and  ({$ATabla}.res02 = {$ASemana}) 
	    and  ({$ATabla}.res03 = {$ASucursal})) 
    group by {$ATabla}.res04
    order by {$ATabla}.res04";
  $result = ObtieneResulsetMySql($query);
  return $result;
 }
