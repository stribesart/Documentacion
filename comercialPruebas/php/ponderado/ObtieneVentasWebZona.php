<?php
 function ObtieneVentasWebZona($AFechaInicial,$AIdZona,$ATipoVenta){
  $query = ObtieneQueryVentasWebZona($AFechaInicial,$AIdZona,$ATipoVenta);
 $result = ObtieneResulsetMySql($query);
 $fila = mysqli_fetch_array($result);
	if(!is_null($fila)){ 
  for ($i=0; $i < 8 ; $i++) { 
    $idx = ($i)*2;
    $datos[$idx]="";
    $datos[$idx+1] = $fila[$i];
  }
  $datos[16]="";
  $datos[17]="";
  return $datos;
	}else{
  return $fila; 
 }
}

function ObtieneQueryVentasWebZona($AFechaInicial,$AIdZona,$ATipo){

		$nomina = BaseDatos("nomina");
  $fechaFinal = $AFechaInicial;
  $campo = $ATipo==0 ? "tiendaventasweb.tie05" : "tiendaventasweb.tie04";
  $query ="select ";
  for ($i = 0; $i < 7; $i++) {
   $query .= " sum(if(tiendaventasweb.tie03='$fechaFinal',$campo,0)), ";  
   if ($i<6){
    $fechaFinal = date('Y-m-d', strtotime($fechaFinal."+ 1 days"));	
   }
  } 
  $query .= "sum($campo) 
   from tiendaventasweb
   inner join {$nomina}dzonas on (tiendaventasweb.tie02 = dzonas.dzo02)
  where ((tiendaventasweb.tie03 between '$AFechaInicial' and '$fechaFinal') 
    and  (dzonas.dzo01 = {$AIdZona}))";
	return $query; 
}   
