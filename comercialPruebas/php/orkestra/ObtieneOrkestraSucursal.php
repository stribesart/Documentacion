<?php
 function ObtieneDatosOrkestraSucursal($AAnio, $AIdConsulta, $ATipoConsulta,$ACondicion,$ANumeroSemana){
  $campo = $ATipoConsulta == 0 ? "Semana" : "Mes";
 	  $query = "
   select  
   OrkestraPorSucursal$campo.IdLocacion, 
   OrkestraPorSucursal$campo.Ano, 
    OrkestraPorSucursal$campo.$campo, 
    catalogolocaciones.nombre, 
    catalogolocaciones.idRmetrics, 
    sum(case when OrkestraPorSucursal$campo.idSlug = 11 THEN total ELSE 0 END) AS contactos, 
    sum(case when OrkestraPorSucursal$campo.idSlug = 13 THEN total ELSE 0 END) AS sugeridos, 
    sum(case when OrkestraPorSucursal$campo.idSlug = 09 THEN total ELSE 0 END) AS prospeccion, 
    sum(case when OrkestraPorSucursal$campo.idSlug = 10 THEN total ELSE 0 END) AS prospectosventa, 
    sum(case when OrkestraPorSucursal$campo.idSlug = 07 THEN total ELSE 0 END) AS ventas, 
    sum(case when OrkestraPorSucursal$campo.idSlug = 04 THEN Amount ELSE 0 END) AS ventaligas,
    sum(case when OrkestraPorSucursal$campo.idSlug = 05 then Amount else 0 end) as ligasPendientes
  from  OrkestraPorSucursal$campo 
    inner join catalogolocaciones on (OrkestraPorSucursal$campo.IdLocacion = catalogolocaciones.id)
   where ((OrkestraPorSucursal$campo.$campo = $ANumeroSemana) 
     and  (OrkestraPorSucursal$campo.Ano = $AAnio)  
     $ACondicion
         ) 
   group by OrkestraPorSucursal$campo.IdLocacion,  OrkestraPorSucursal$campo.Ano, 
    OrkestraPorSucursal$campo.$campo, catalogolocaciones.nombre,catalogolocaciones.idRmetrics
			order by nombre	  
   ";
  return ObtieneDatosMostrar($query,"nombre",$ATipoConsulta,$AIdConsulta,$AAnio,2); 
  
  }
