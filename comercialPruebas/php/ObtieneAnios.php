<?php	
 $fechaEntera = time();
 $anioActual = date("Y", $fechaEntera); 
 $anio = isset($_REQUEST['anio']) ? $_REQUEST['anio'] : $anioActual;
 $i=0;
 if($anio>$anioActual){$anio=$anioActual;}
 $data = [];
 while($anio <= $anioActual){
   $data[$i] = Array(
    'id' => $anio,
    'descripcion' => $anio
   );
  $i++;
  $anio++;
 } 
 header('Content-Type: application/json');
 echo json_encode($data);
 