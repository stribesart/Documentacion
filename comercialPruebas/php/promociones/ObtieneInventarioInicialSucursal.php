<?php

function ObtieneInventarioInicialSucursal($AIdSucursal,$AIdPromocion){
		$inicial = 0;
  $result = ObtieneTotalPromocionesSucursal($AIdPromocion,$AIdSucursal);
  $linea = odbc_fetch_array($result);
 $inicial = $linea['inicial'] > 0 ?  $linea['inicial'] : 0;
 return $inicial;
}
