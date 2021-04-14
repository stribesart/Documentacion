<?php
 function ObtieneDatosOrkestraVendedor($AAnio, $AIdConsulta, $ATipoConsulta,$ACondicion,$ANumeroSemana){
  $campo = $ATipoConsulta == 0 ? "Semana" :  "Mes";
  $query = "
   select
    OrkestraPorUsuario$campo.Ano, 
    OrkestraPorUsuario$campo.$campo, 
    OrkestraPorUsuario$campo.NameU, 
    sum(case when OrkestraPorUsuario$campo.idSlug = 11 then total else 0 end) as contactos, 
    sum(case when OrkestraPorUsuario$campo.idSlug = 13 then total else 0 end) as sugeridos, 
    sum(case when OrkestraPorUsuario$campo.idSlug = 09 then total else 0 end) as prospeccion,
    sum(case when OrkestraPorUsuario$campo.idSlug = 10 then total else 0 end) as prospectosventa,
    sum(case when OrkestraPorUsuario$campo.idSlug = 07 then total else 0 end) as ventas,
    sum(case when OrkestraPorUsuario$campo.idSlug = 04 then Amount else 0 end) as ventaligas, 
    sum(case when OrkestraPorUsuario$campo.idSlug = 05 then Amount else 0 end) as ligasPendientes
   from OrkestraPorUsuario$campo 
   inner join catalogolocaciones on (OrkestraPorUsuario$campo.IdLocacion = catalogolocaciones.id)
   where ((OrkestraPorUsuario$campo.$campo = $ANumeroSemana) 
     and  (OrkestraPorUsuario$campo.Ano = $AAnio) 
     and  (OrkestraPorUsuario$campo.Orkestra = 1) 
     $ACondicion
   )
   group by OrkestraPorUsuario$campo.Ano, OrkestraPorUsuario$campo.$campo, OrkestraPorUsuario$campo.NameU
   ";
   return ObtieneDatosMostrar($query,"NameU",$ATipoConsulta,$AIdConsulta,$AAnio,3); 
  }

  
