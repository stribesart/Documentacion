<?php	
 require("../conexion.php");

 function ObtieneEncabezados($ACabeceras){
  $ACabeceras += "Descripcion,Inventario,Unidades,Pesos,%,";
  return $ACabeceras;     
 }

 function ObtieneIdExtra($AId){
  $rmetrics = BaseDatos("rmetrics"); 
  $condicion  = 
   "inner join {$rmetrics}tienda on (sucursal.suc22 = id)  
   where suc01 = {$AId}";
 $idExtra = ObtieneValorCampoMySql("sucursal","idExtra",$condicion);
 return $idExtra;
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

 function ObtienePromociones($AIdPromocion, $AIdSucursal, $AIdPrecio){
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
      and  (catalogolocaciones.id = '$AIdSucursal')
      and  (detallepromocionsucursal.det03 = '$AIdPrecio'))
      ";   
   $result = ObtieneResulsetSqlServer($query);   
   return $result;
  } 
 function ObtieneSucursales($AIdPromocion, $ACondicion){
   $query = "
   select distinct
    catalogolocaciones.id,
    catalogolocaciones.nombre
   from detallepromocionsucursal 
   inner join catalogolocaciones on (detallepromocionsucursal.det02 = catalogolocaciones.id)
   where detallepromocionsucursal.det01 = '$AIdPromocion' ".$ACondicion."
   order by catalogolocaciones.id
   ";
  $result = ObtieneResulsetSqlServer($query);   
  return $result; 
 }

 $idPromocion = isset($_REQUEST['idPromocion']) ? $_REQUEST['idPromocion'] : 0;
 $idZona = isset($_REQUEST['idZona']) ? $_REQUEST['idZona'] : 0;
 $idSucursal = isset($_REQUEST['idSucursal']) ? $_REQUEST['idSucursal'] : 0;
 $condicionZona = $idZona > 0 ? " and IDistrito = ".$idZona :  "and IDistrito in (1,3)";
 $condicionScucursal = $idSucursal > 0 ? " and id = ".$idSucursal : "";
 $tipoUsuario = isset($_SESSION['tipoUsuario']) ? $_SESSION['tipoUsuario'] : 10;
 $id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
 $condicion = $condicionScucursal." ".$condicionZona;
 if ($tipoUsuario==3){
  $idExtra = ObtieneIdExtra($id);
  $condicion .= " and idRmetrics = '$idExtra'";
 }
 $cabeceras = "Nombre,";
 $titulos = "Sucursales,";
 $data = [];
 $contenido=[];
 if ($idPromocion == ''){
  $data[0] = array("No se localizo en id de promocion");
 }else{
  $i = 0;
  $resultSucursal = ObtieneSucursales($idPromocion,$condicion);
  while ($rowSucursal = odbc_fetch_array($resultSucursal)){
   $idSucursal = $rowSucursal['id'];     
   $promociones = array(utf8_encode($rowSucursal['nombre']));
   $resultPrecios = ObtienePreciosPromocion($idPromocion);
   $totalInicial = 0;
   $totalUnidades = 0;
   $totalPesos = 0;
  while($rowPrecios = odbc_fetch_array($resultPrecios)){
    if($i == 0){
     $cabeceras .= "Inventario,Unidades,Pesos,%,";
     $titulos .= $rowPrecios["pre03"].",";
    } 
    $result = ObtienePromociones($idPromocion, $idSucursal, $rowPrecios["pre02"]);
    while ($row = odbc_fetch_array($result)){
      $porcentaje = $row['inicial'] <> 0 ? number_format(($row['unidades'] * 100) / $row['inicial'],2)."%" : 0;
      array_push(
        $promociones,
        number_format($row['inicial'],0),
        number_format($row['unidades'],0),
        number_format($row['pesos'],2),
        $porcentaje
      );
      $totalInicial += $row['inicial'];
      $totalUnidades += $row['unidades'];
      $totalPesos += $row['pesos'];
    }
  }  
  if( $i==0 ){
    $cabeceras .= "Total Inventario, Total Unidades, Total Pesos, Total %";
    $titulos .= "Totales";     
  }
  $porcentaje = $totalInicial <> 0 ? number_format(($totalUnidades * 100) / $totalInicial,2)."%" : 0;
  array_push(
    $promociones,
    number_format($totalInicial,0),
    number_format($totalUnidades,0),
    number_format($totalPesos,2),
    $porcentaje
  );
  $data[$i] = $promociones;
  $i++;
}
$contenido["content"] = $data;
$contenido["headers"] = $cabeceras;
$contenido["titulos"] = $titulos;
}
 header('Content-Type: application/json');
 echo json_encode($contenido);
?>