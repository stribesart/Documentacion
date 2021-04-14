<?php
 function ObtieneDatosOrkestraGeneral($anio, $idConsulta, $tipoConsulta,$numeroSemana){
  $campo = $tipoConsulta == 0 ? "Semana" : "Mes";
		$query = 
   " select  
    OrkestraGeneral$campo.Ano, 
    OrkestraGeneral$campo.$campo, 
    sum(case when OrkestraGeneral$campo.idSlug = 11 then total else 0 end) as contactos, 
    sum(case when OrkestraGeneral$campo.idSlug = 13 then total else 0 end) as sugeridos, 
    sum(case when OrkestraGeneral$campo.idSlug = 09 then total else 0 end) as prospeccion,
    sum(case when OrkestraGeneral$campo.idSlug = 10 then total else 0 end) as prospectosventa,
    sum(case when OrkestraGeneral$campo.idSlug = 07 then total else 0 end) as ventas,
    sum(case when OrkestraGeneral$campo.idSlug = 04 then Amount else 0 end) as ventaligas, 
    sum(case when OrkestraGeneral$campo.idSlug = 05 then Amount else 0 end) as ligasPendientes
			 from OrkestraGeneral$campo 
    where Ano =$anio and $campo = $numeroSemana 
     group by Ano, ".$campo;
  return ObtieneDatosMostrar($query,"General",$tipoConsulta,$idConsulta,$anio,0);  
}
