<?php	
 require_once("../conexion.php");

 function ObtieneEncabezados($ACabeceras){
  $ACabeceras += "Descripcion,Inventario,Unidades,Pesos,%,";
  return $ACabeceras;     
 }

 function ObtienePreciosPromocion($AIdPromocion){
  $query = "
   select 
    preciospromocion.pre02,
    preciospromocion.pre03 
   from preciospromocion
   where pre01 = '$AIdPromocion'"; 
  $result = ObtieneResulsetSqlServer($query);   
  return $result;
 }

 function ObtienePromociones($AIdPromocion, $AIdDistrito, $AIdPrecio){
   $query = "
    select 
     case when sum(detallepromocionsucursal.det04) is null then 0 else sum(detallepromocionsucursal.det04) end as inicial,
     case when sum(detallepromocionsucursal.det05) is null then 0 else sum(detallepromocionsucursal.det05) end as unidades,
     case when sum(detallepromocionsucursal.det06) is null then 0 else sum(detallepromocionsucursal.det06) end as pesos,
     sum(detallepromocionsucursal.det07) as final
    from detallepromocionsucursal
    inner join catalogolocaciones on (detallepromocionsucursal.det02 = catalogolocaciones.id)
    inner join distrito on (catalogolocaciones.IDistrito = distrito.Id) 
    where ((detallepromocionsucursal.det01 = '$AIdPromocion')
      and  (distrito.Id = '$AIdDistrito')
      and  (detallepromocionsucursal.det03 = '$AIdPrecio'))
   ";   
   $result = ObtieneResulsetSqlServer($query);   
   return $result;
  } 


 function ObtieneZonas($AIdPromocion, $ACondicion){
   $query = "
    select distinct
     distrito.id,
     distrito.Nombre
    from detallepromocionsucursal 
     inner join catalogolocaciones on (detallepromocionsucursal.det02 = catalogolocaciones.id)
     inner join distrito on (catalogolocaciones.IDistrito = distrito.Id) 
    where detallepromocionsucursal.det01 = '$AIdPromocion' ".$ACondicion."
    order by distrito.id
   ";
  $result = ObtieneResulsetSqlServer($query);
  return $result; 
 }

 $idPromocion = ObtieneRequest("idPromocion",0);
 $idZona = ObtieneRequest("idZona",0);
 $tipoUsuario = ObtieneRequest("tipoUsuario",4);
 $condicion = $idZona > 0 ? " and IDistrito = {$idZona}" : "and IDistrito in (1,3)";
 $cabeceras = "Nombre,";
 $titulos = "Zona,";
 $data = [];
 $contenido=[];
 $totales = [];//"Totales";
 if ($idPromocion == 0){
  $contenido[0] = array("No se localizo en id de promocion");
 }else{
  if($tipoUsuario<3){ 
   $i = 0;
   $resultZonas = ObtieneZonas($idPromocion,$condicion);
  // $totales[0] = "Totales";
   while ($rowZonas = odbc_fetch_array($resultZonas)){
    $j = 1;
    $idZona = $rowZonas['id'];     
   	$promociones=[];
    $promociones["Nombre"] = $rowZonas["Nombre"]; 
    $resultPrecios = ObtienePreciosPromocion($idPromocion);
    $totalInicial = 0;
    $totalUnidades = 0;
    $totalPesos = 0;
    while($rowPrecios = odbc_fetch_array($resultPrecios)){
     if($i == 0){
      $cabeceras .= "Inventario,Unidades,Pesos,%,";
      $titulos .= $rowPrecios["pre03"].",";
     } 
     $result = ObtienePromociones($idPromocion, $idZona, $rowPrecios["pre02"]);
     while ($row = odbc_fetch_array($result)){
      if($i == 0){
       for($k = 0; $k < 4; ++$k){
        $totales[$j+$k] = 0;
       }
      }
      $totales[$j] += $row['inicial'];
      $totales[$j+1] += $row['unidades'];
      $totales[$j+2] += $row['pesos'];
      $j += 4;
      $porcentaje =  $row['inicial'] <> 0 ? number_format(($row['unidades'] * 100) / $row['inicial'],2)."%" : 0;
						$promocion = array(
						 "inicial" => number_format($row['inicial'],0),
       "unidades" => number_format($row['unidades'],0),
       "pesos" => number_format($row['pesos'],2),
       "porcentaje" => $porcentaje
						);
			   $totalInicial += $row['inicial'];
      $totalUnidades += $row['unidades'];
      $totalPesos += $row['pesos'];
     }
	 			$promociones[$rowPrecios["pre03"]] = $promocion;
				}
    $data[$rowZonas["Nombre"]]=$promociones;   
		  
				if( $i==0 ){
     $cabeceras .= "Total Inventario, Total Unidades, Total Pesos, Total %";
     $titulos .= "Totales";  
     for($k = 0; $k < 4; ++$k){
      $totales[$j+$k] = 0;
     }   
    }  
    $totales[$j] += $totalInicial;
    $totales[$j+1] += $totalUnidades;
    $totales[$j+2] += $totalPesos;
    $porcentaje =  $totalInicial <> 0 ? number_format(($totalUnidades * 100) / $totalInicial,2)."%" : 0;
    $promociones["precio"]="Totales";
    $promociones["incial"] = number_format($totalInicial,0);
    $promociones["unidades"] = number_format($totalUnidades,0);
    $promociones["pesos"] = number_format($totalPesos,2);
    $promociones["porcentaje"] = $porcentaje;
    $i++;  
   }

   $elemetosTotal = count($totales);
   $elemento = 1;
	  while($elemento < $elemetosTotal){
    $porcentaje =  $totales[$elemento] <> 0 ? number_format(($totales[$elemento+1] * 100) / $totales[$elemento],2)."%" : "0%";
    $totales[$elemento] = number_format($totales[$elemento],0);
    $totales[$elemento+1] = number_format($totales[$elemento+1],0);
    $totales[$elemento+2] = number_format($totales[$elemento+2],2);
    $totales[$elemento+3] = $porcentaje;
    $elemento += 4;
   }
   $data[$i] = $totales;
   $contenido["content"] = $data;
 //  $contenido["headers"] = $cabeceras;
 //  $contenido["titulos"] = $titulos;
  }  
 }
	$contenido["request"]=$_REQUEST;
 header('Content-Type: application/json');
 echo json_encode($contenido);
?>