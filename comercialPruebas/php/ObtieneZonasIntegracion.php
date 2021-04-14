<?php
function ObtieneZonasIntegracion($AIdSucursal){
 $condicion = $AIdSucursal > 0 ? " and (catalogolocaciones.id = {$AIdSucursal}) " : "";
 $query = "
  select distinct
		 distrito.id as zon01,
			distrito.nombre as zon02
		 from distrito
			inner join catalogolocaciones on (distrito.id = catalogolocaciones.IDistrito)
   where 1=1 {$condicion}";
 $result = ObtieneResulsetSqlServer($query);
 if(is_null($result)){
  $datos[0] = Array("texto" => "No hay datos en la tabla distrito");
 }else{
  $i=0;
  while ($linea = odbc_fetch_array($result)){
   $keys = array_keys($linea);
   $cadena = [];
   $j=0;
   foreach($keys as $clave => $valor) {
    $cadena[$valor] = utf8_encode($linea[$valor]);
   	$j++;
   }
   $datos[$i] = $cadena;
   $i++;
  }
 }
	 return $datos;
}

