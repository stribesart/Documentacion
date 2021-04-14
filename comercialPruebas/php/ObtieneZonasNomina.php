<?php
function ObtieneZonasNomina($ATipoUsuario,$AIdSucursal){
 $condicion = $ATipoUsuario==3 
  ? "inner join pradanomina.dzonas on (zonas.zon01 = dzonas.dzo01) 
     where (dzonas.dzo02 = $AIdSucursal)"
  : "";
 $nomina = BaseDatos("nomina"); 
 $datos = ObtieneDatosTablaMySql(
  " {$nomina}zonas",
  " zonas.zon01,
    zonas.zon02",
  "",
  "where ((zonas.zon01<13) {$condicion})  ",
  "order by zonas.zon02"  
 );
 return $datos;
}  