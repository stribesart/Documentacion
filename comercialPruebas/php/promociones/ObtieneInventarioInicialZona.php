<?php
function ObtieneInventarioInicialZona($AIdZona,$AIdPromocion){
	$inicial = 0;
 $result = ObtieneTotalPromocionesZona($AIdPromocion,$AIdZona);
 $linea = odbc_fetch_array($result);
 $inicial = $linea['inicial'] > 0 ?  $linea['inicial'] : 0;
 return $inicial;
}
