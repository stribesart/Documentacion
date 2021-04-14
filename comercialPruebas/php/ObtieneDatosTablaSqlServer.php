<?php	
 require_once("conexion.php");

 $tabla = ObtieneRequest("tabla","");
 $campos = ObtieneRequest("campos","*");
 $campoOrden = ObtieneRequest("campoOrden","");
 $condicion = ObtieneRequest("condicion","");
	$verQuery = isset($_REQUEST["verQuery"]) ? true : false;
 $datos = [];
 if ($tabla == ""){
  $datos[0] = Array("texto" => "Tienes que indicar la tabla ");
 }else{	 
  $query = "select 
 	 {$campos} 
 		from {$tabla}
 		{$condicion}
 		{$campoOrden}";
		if ($verQuery){
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
 header('Content-Type: application/json');
 echo json_encode($datos); 