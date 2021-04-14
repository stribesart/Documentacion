<?php
function ObtieneSucursalesOrkestra($AIdSucursal,$AIdZona){
 $tabla  = "catalogolocaciones";
 $campos = "id as dzo02,nombre as dzo04";
	$datos = [];
 $condicion = $AIdSucursal > 0 ? " and (catalogolocaciones.id = {$AIdSucursal}) " : "";
	$condicion .= $AIdZona > 0 ? " and (catalogolocaciones.IDistrito = {$AIdZona})" : "";
 $query = "
  select {$campos} from {$tabla}
  where  catalogolocaciones.IDistrito >0 {$condicion}";
 $result = ObtieneResulsetSqlServer($query);
 if(is_null($result)){
  $datos[0] = Array("texto" => "No hay datos en la tabla {$tabla}");
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