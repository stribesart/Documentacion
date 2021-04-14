<?php
function AgregaRegistroArreglo($ARenglon){
 $renglon = [];
	$i = 0;
 foreach ($ARenglon as $nombreCampo => $valorCampo) {
		if( !is_numeric ($nombreCampo))
 		$renglon[$nombreCampo] = utf8_encode($valorCampo);
	 	$i++;
 	} 
 return $renglon;
};