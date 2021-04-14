<?php	
require_once("conexion.php");
 
function ObtieneDatosTablaMySql($ATabla, $ACampos, $AUnion, $ACondicion, $AOrden, $AVerQuery=false){
 $datos = [];
 if ($ATabla == "" || $ACampos==""){
  $datos[0] = Array('texto' => 'No se recibio Tabla o Campos');
 }else{
  $query = "
   select {$ACampos} from {$ATabla}
   {$AUnion}
   {$ACondicion}
   {$AOrden}";
  if ($AVerQuery){
   var_dump($query);
  } else {  
   $result = ObtieneResulsetMySql($query);
   if(is_null($result)){
    $datos[0] = Array("texto" => "No hay datos en la tabla {$ATabla}");
   }else{
    $i=0;
    while($fila = mysqli_fetch_assoc($result)){
     $registro = [];
     foreach($fila as $campo=>$valor){
       $registro[$campo]= utf8_encode($valor); 
     } 
     $datos[$i] = $registro;
     $i++;
    } 
   }
  }
 } 
 return $datos;
}

