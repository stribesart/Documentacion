<?php
function ObtieneMetaMensualSucursal($AIdSemana,$ATipoVenta, $AIdSucursal, $AAnio, $AMes, $AMeta){
 $condicion = $AMeta == 1 ? "(ajusteponderadosucursal.aju01 <= $AIdSemana) and  " : "";
 $query = "
  select 
   sum(ajusteponderadosucursal.aju20) as meta, 
   avg(ajusteponderadosucursal.aju19) as porcentaje 
  from ajusteponderadosucursal
   inner join rmetrics_prada.periodossemanales on ( 
    (ajusteponderadosucursal.aju01 = id) 
    and (mes = $AMes)
    and (ano = $AAnio))
   where ($condicion
          (ajusteponderadosucursal.aju02 = $ATipoVenta)
     and  (ajusteponderadosucursal.aju03 = $AIdSucursal)
     and  (ajusteponderadosucursal.aju04 = $AMeta))
 ";
 $result = ObtieneResulsetMySql($query);
 $fila = mysqli_fetch_assoc($result); 
 return $fila;
}