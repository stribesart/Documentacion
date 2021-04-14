<?php
 function ObtieneDatosOrkestraZona($AAnio, $AIdConsulta, $ATipoConsulta, $ACondicion,$ANumeroSemana){
  $campo = $ATipoConsulta == 0 ? "Semana" : "Mes";
  $query = "
   select  
    OrkestraPorZona$campo.Ano, 
    OrkestraPorZona$campo.IdDistrito,
    OrkestraPorZona$campo.$campo,
	   distrito.Nombre,
    sum(case when OrkestraPorZona$campo.idSlug = 11 then total else 0 end) as contactos, 
    sum(case when OrkestraPorZona$campo.idSlug = 13 then total else 0 end) as sugeridos, 
    sum(case when OrkestraPorZona$campo.idSlug = 09 then total else 0 end) as prospeccion,
    sum(case when OrkestraPorZona$campo.idSlug = 10 then total else 0 end) as prospectosventa,
    sum(case when OrkestraPorZona$campo.idSlug = 07 then total else 0 end) as ventas,
    sum(case when OrkestraPorZona$campo.idSlug = 04 then Amount else 0 end) as ventaligas, 
    sum(case when OrkestraPorZona$campo.idSlug = 05 then Amount else 0 end) as ligasPendientes
   from OrkestraPorZona$campo
	   inner join distrito on (OrkestraPorZona$campo.IdDistrito = distrito.Id)
    where ((Ano = $AAnio) 
      and  ($campo = $ANumeroSemana) 
      $ACondicion )
    group by Ano, IdDistrito, $campo, distrito.Nombre
   ";
   return ObtieneDatosMostrar($query,"Nombre",$ATipoConsulta,$AIdConsulta,$AAnio,1);  
}