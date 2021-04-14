<?php
 function AgregaRegistroPaseantes($ARenglon){
  $renglon = [];
 	$i = 14;
  foreach ($ARenglon as $nombreCampo => $valorCampo) {
	 	if(!is_numeric($nombreCampo) )
  		$renglon[$nombreCampo] = $valorCampo;
	  	$i++;
  	} 
		return $renglon;
	}
