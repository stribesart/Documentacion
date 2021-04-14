<?php
function ObtieneMetaMensualZona($AIdSemana,$ATipoVenta, $AIdZona, $AAnio, $AMes, $AMeta){
 $condicion = $AMeta == 1 ? "(ajusteponderadosucursal.aju01 <= $AIdSemana) and  " : "";
	$nomina = BaseDatos("nomina");
	$rmetrics = BaseDatos("rmetrics");
 $query = "
  select 
   sum(ajusteponderadosucursal.aju20) as meta, 
   avg(ajusteponderadosucursal.aju19) as porcentaje 
  from ajusteponderadosucursal
  join {$nomina}dzonas on (ajusteponderadosucursal.aju03 = dzonas.dzo02)
  join {$nomina}zonas on (dzonas.dzo01 = zonas.zon01)
  inner join {$rmetrics}prada.periodossemanales on ( 
    (ajusteponderadosucursal.aju01 = id) 
    and (mes = $AMes)
    and (ano = $AAnio))
   where ($condicion
          (ajusteponderadosucursal.aju02 = $ATipoVenta)
     and  (zonas.zon01 = $AIdZona)
     and  (ajusteponderadosucursal.aju04 = $AMeta))
 ";
 $result = ObtieneResulsetMySql($query);
 $fila = mysqli_fetch_assoc($result); 
 return $fila;
}