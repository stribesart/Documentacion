<?php
 require_once("../conexion.php");
	require_once("../ObtieneTablaSqlServer.php");
	require_once("ObtieneInventarioInicialZona.php");
	require_once("ObtieneDatosPromocionesSucursal.php");
	require_once("ObtieneZonas.php");

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
	
 function ObtienePromocionesZona($AIdPromocion, $AIdDistrito, $AIdPrecio){
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
  return ObtieneResulsetSqlServer($query);
 } 

 function ObtieneTotalPromocionesZona($AIdPromocion, $AIdDistrito){
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
     and  (distrito.Id = '$AIdDistrito'))
  ";   
  return ObtieneResulsetSqlServer($query);
  }


function ObtieneTotalesZona($AIdZonas,$AZonas,$AIdPromocion){
	$datos=[];
	$inicial = 0;
	$unidades = 0;
	$pesos = 0;
	for ($i=0; $i < count($AIdZonas) ; $i++) { 
  $result = ObtieneTotalPromocionesZona($AIdPromocion,$AIdZonas[$i]);
  $linea = odbc_fetch_array($result);
  $porcentaje =  $linea['inicial'] <> 0 ? number_format(($linea['unidades'] * 100) / $linea['inicial'],2)."%" : 0;
		$datos = array(
		 "Inventario" => number_format($linea['inicial'],0),
   "Unidades" => number_format($linea['unidades'],0),
   "Pesos" => number_format($linea['pesos'],2),
   "%" => $porcentaje
		);
  $renglon[$i] = $datos;
	 $inicial += $linea["inicial"];
		$unidades += $linea["unidades"];
		$pesos += $linea["pesos"];
 }	
 $porcentaje =  $inicial <> 0 ? number_format(($unidades * 100) / $inicial,2)."%" : 0;
	$datos = array(
	 "Inventario" => number_format($inicial,0),
  "Unidades" => number_format($unidades,0),
  "Pesos" => number_format($pesos,2),
  "%" => $porcentaje
	);
 $renglon[$i] = $datos;
 $AZonas["Total General"] = $renglon;
 return $AZonas;
}

/**********************************************************************/
function ObtieneInventarioSucursal($AIdSucursales,$ASucursales,$AIdPromocion){
	$resultPrecios = ObtienePreciosPromocion($AIdPromocion);
	$datos=[];
	while($rowPrecios = odbc_fetch_array($resultPrecios)){
	 $inventarioInicial = 0;
  $inicial = 0;
		$unidades = 0;
		$pesos = 0;
		for ($i=0; $i < count($AIdSucursales) ; $i++) { 
   $result = ObtienePromocionesSucursal($AIdPromocion,$AIdSucursales[$i],$rowPrecios["pre02"]);
 		$inventarioInicialSucursal = ObtieneInventarioInicialSucursal($AIdSucursales[$i],$AIdPromocion);
   $linea = odbc_fetch_array($result);
      $porcentaje =  $linea['inicial'] <> 0 ? number_format(($linea['unidades'] * 100) / $linea['inicial'],2)."%" : 0;
  $porcentajeParticipacion =  $linea['inicial'] != 0 ? number_format(($inventarioInicialSucursal * 100) / $linea['inicial'],2)."%" : 0;
			$datos = array(
        "Inventario" => number_format($linea['inicial'],0),
     			"% Participacion" => $porcentajeParticipacion,
        "Unidades" => number_format($linea['unidades'],0),
        "Pesos" => number_format($linea['pesos'],2),
        "%" => $porcentaje
      );
      $renglon[$i] = $datos;
      $inicial += $linea["inicial"];
			$unidades += $linea["unidades"];
			$pesos += $linea["pesos"];
		$inventarioInicial += $inventarioInicialSucursal;
    }	
    $porcentaje =  $inicial <> 0 ? number_format(($unidades * 100) / $inicial,2)."%" : 0;
  $porcentajeParticipacion =  $inicial != 0 ? number_format(($inventarioInicial * 100) / $inicial,2)."%" : 0;
		$datos = array(
      "Inventario" => number_format($inicial,0),
								"% Participacion" => $porcentajeParticipacion,
      "Unidades" => number_format($unidades,0),
      "Pesos" => number_format($pesos,2),
      "%" => $porcentaje
		);
    $renglon[$i] = $datos;
  $ASucursales[$rowPrecios["pre03"]] = $renglon;
	}
 return $ASucursales;
}

 function ObtienePromocionesSucursal($AIdPromocion, $AIdSucursal, $AIdPrecio){
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

 function ObtieneTotalPromocionesSucursal($AIdPromocion, $AIdSucursal){
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
      and  (catalogolocaciones.id = '$AIdSucursal'))
      ";   
   $result = ObtieneResulsetSqlServer($query);   
   return $result;
  } 

function ObtieneSucursales($AIdPromocion, $AIdSucursal, $ACondicion){
 $result = ObtieneResulsetSqlServer("
  select distinct
    catalogolocaciones.id,
    catalogolocaciones.nombre
   from detallepromocionsucursal 
   inner join catalogolocaciones on (detallepromocionsucursal.det02 = catalogolocaciones.id)
   where detallepromocionsucursal.det01 = '$AIdPromocion' ".$ACondicion."
   order by catalogolocaciones.id
   ");
 $i = 0;
	$datos=[];
	while ($row = odbc_fetch_array($result)){
		$sucursales[$i] = array("Nombre" => utf8_encode($row["nombre"]));
		$idSucursal[$i] = $row["id"];
		$i++;
	}	
	if($i>0){
    $sucursales[$i] = array("Nombre" => "Totales");
    $datos["Sucursal"] = $sucursales;
    $datos = ObtieneInventarioSucursal($idSucursal,$datos,$AIdPromocion);
    $datos = ObtieneTotalesSucursal($idSucursal,$datos,$AIdPromocion);
	}
	return $datos;
} 

function ObtieneTotalesSucursal($AIdSucursales,$ASucursales,$AIdPromocion){
	$datos=[];
	$inicial = 0;
	$unidades = 0;
	$pesos = 0;
	for ($i=0; $i < count($AIdSucursales) ; $i++) { 
  $result = ObtieneTotalPromocionesSucursal($AIdPromocion,$AIdSucursales[$i]);
  $linea = odbc_fetch_array($result);
  $porcentaje =  $linea['inicial'] <> 0 ? number_format(($linea['unidades'] * 100) / $linea['inicial'],2)."%" : 0;
		$datos = array(
		 "Inventario" => number_format($linea['inicial'],0),
   "Unidades" => number_format($linea['unidades'],0),
   "Pesos" => number_format($linea['pesos'],2),
   "%" => $porcentaje
		);
  $renglon[$i] = $datos;
	 $inicial += $linea["inicial"];
		$unidades += $linea["unidades"];
		$pesos += $linea["pesos"];
 }	
 $porcentaje =  $inicial <> 0 ? number_format(($unidades * 100) / $inicial,2)."%" : 0;
	$datos = array(
	 "Inventario" => number_format($inicial,0),
  "Unidades" => number_format($unidades,0),
  "Pesos" => number_format($pesos,2),
  "%" => $porcentaje
	);
 $renglon[$i] = $datos;
 $ASucursales["Total General"] = $renglon;
 return $ASucursales;
}

 $idPonderado = ObtieneRequest("idPonderado",0);
 $idPromocion = ObtieneRequest("idPromocion",0);
 $cbZonas = ObtieneRequest("cbZonas","off");
 $idZona = $cbZonas == "off" ? 0 : ObtieneRequest("idZonas",0);
 $tipoUsuario = ObtieneRequest("tipoUsuario",4);
 $cbSucural = ObtieneRequest("cbSucursales","off");
 $tipoUsuario = ObtieneRequest("tipoUsuario",10);

 if($tipoUsuario==3){
		$idSucursal = $idPonderado;
	}else{
		$idSucursal = $cbSucural == "off" ? 0 : ObtieneRequest("idSucursales",0);
	}

 $condicionZona = $idZona > 0 ? " and IDistrito = {$idZona}" :  "and IDistrito in (1,3)";
 $condicionScucursal = $idSucursal > 0 ? " and id = ".$idSucursal : "";
 $condicion = $condicionScucursal." ".$condicionZona;

 $datos = [];
 $zonas=[];
	$idZonas=[];
 if ($idPromocion == 0){
  $contenido[0] = array("No se localizo en id de promocion");
 }else{
#  $contenido["Zonas"] = ObtieneZonas($idPromocion,$condicionZona);		
#	$contenido["Sucursales"] = ObtieneSucursales($idPromocion,$idSucursal,$condicion);
 }

	$contenido["request"] = $_REQUEST;
 header('Content-Type: application/json');
 echo json_encode($contenido);
