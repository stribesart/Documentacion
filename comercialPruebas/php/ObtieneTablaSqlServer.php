<?php
function ObtieneDatosTablaSqlServer($ATabla, $ACampos, $AUnion, $ACondicion, $AOrden, $AVerQuery=false){
 $datos = [];
 if ($ATabla == ""){
  $datos[0] = Array("texto" => "Tienes que indicar la tabla ");
 }else{	 
  $query = "select 
 	 {$ACampos} 
 		from {$ATabla}
			{$AUnion}
 		{$ACondicion}
 		{$AOrden}";
		if ($AVerQuery){
   var_dump($query);
  } else {  
   $result = ObtieneResulsetSqlServer($query);
   if(is_null($result)){
    $datos[0] = Array("texto" => "No hay datos en la tabla {$ATabla}");
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
  } 
	}											
 return $datos; 
}	