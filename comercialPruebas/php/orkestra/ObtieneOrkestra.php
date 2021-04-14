<?php
 require_once("../conexion.php");
	require_once("ObtieneDatosMostrar.php");
 require_once("ObtieneOrkestraGeneral.php");
 require_once("ObtieneOrkestraZona.php");
 require_once("ObtieneOrkestraSucursal.php");
 require_once("ObtieneOrkestraVendedor.php");
	require_once("../ObtieneNumeroSemana.php");

 

function ObtieneCabeceras($ANombre,$ANivel=0){
 $cabeceras = "$ANombre,Contactos,Sugeridos,Prospeccion,Cumplimiento,con venta,con contacto,Prospectadas,por Ligas,Ventas";
 if($ANivel==0){$cabeceras .= ",Prada,Orkestra";} 
 return $cabeceras;  
}

function ObtieneTitulos($ANombre,$ANivel=0){
	$titulos ="$ANombre,,,,%,Sugeridos,TC Prospecto ,Ventas,Ventas Total,Totales";
	if($ANivel==0){$titulos .= ",Ventas,%";}
 return $titulos; 
}

 $contenido=[];

 $tipoUsuario = ObtieneRequest("tipoUsuario",0);
 $idPonderado = ObtieneRequest("idPonderado", 0); 
 $nivelConsulta = ObtieneRequest("nivelConsulta",0);
 $tipoConsulta = ObtieneRequest("tipoVenta",2); //0=mes 1-semana
 $idConsulta = ObtieneRequest("idConsulta", 0);
 $anio = ObtieneRequest("idAnio",0);
 $cbSucursal = ObtieneRequest("cbSucursales","off");
 $cbZonas = ObtieneRequest("cbZonas","off");
 $idZona = $cbZonas == "off" ? 0:ObtieneRequest("idZonas",0);
	if ($tipoUsuario == 3){
  $idSucursal = $idPonderado;
	}else{
		$idSucursal = $cbSucursal == "off" ? 0 : ObtieneRequest("idSucursales",0);
	} 
 $condicionZona = $idZona > 0 ? " and (IdDistrito = $idZona)" :  "";
 if ($tipoUsuario == 3){
		$rmetrics = BaseDatos("rmetrics");
  $idRmetrics = ObtieneValorCampoMySql(
			"sucursal",
			"idExtra",
			"inner join {$rmetrics}prada.tienda on (suc22=id) where suc01 = {$idSucursal}"
		);
  $condicion = " and (idRmetrics = '$idRmetrics')";
}else{
 $condicion = $idSucursal > 0 ? " and (id = $idSucursal)" : "";
	$condicion .= $idZona > 0 ? " and (IDistrito = $idZona)" : "";
} 
 $data = [];
 $contenido=[];
	$numeroSemana = $tipoConsulta==0 ? ObtieneNumeroSemana($idConsulta) : $idConsulta;
 if ($tipoConsulta == 2){
  $contenido[0] = array("No se localizo el tipo de consulta a mostrar");
 }else{  
  switch($nivelConsulta) {
   case 0:
    $contenido["content"] = $tipoUsuario < 3 ? ObtieneDatosOrkestraGeneral($anio,$idConsulta,$tipoConsulta,$numeroSemana) : array("Sucursal");
    $contenido["headers"] = ObtieneCabeceras("Prada");
    $contenido["titulos"] = ObtieneTitulos("");
		  break;
   case 1:
    $contenido["content"] = $tipoUsuario<3 ? ObtieneDatosOrkestraZona($anio,$idConsulta,$tipoConsulta,$condicionZona,$numeroSemana) : array("Zona");
    $contenido["headers"] = ObtieneCabeceras("Zona");
    $contenido["titulos"] = ObtieneTitulos("Nombre");
    break;
   case 2:
    $contenido["content"] = ObtieneDatosOrkestraSucursal($anio,$idConsulta,$tipoConsulta,$condicion,$numeroSemana);
    $contenido["headers"] = ObtieneCabeceras("Sucursal");
    $contenido["titulos"] = ObtieneTitulos("Nombre");
    break;
    case 3:
      $sucursal["content"] = ObtieneDatosOrkestraSucursal($anio,$idConsulta,$tipoConsulta,$condicion,$numeroSemana);
      $sucursal["headers"] = ObtieneCabeceras("Sucursal");
      $sucursal["titulos"] = ObtieneTitulos("Nombre");
      $vendedor["content"] = ObtieneDatosOrkestraVendedor($anio,$idConsulta,$tipoConsulta,$condicion,$numeroSemana);
      $vendedor["headers"] = ObtieneCabeceras("Vendedor",3);
      $vendedor["titulos"] = ObtieneTitulos("Nombre",3);
						$contenido["sucursal"] = $sucursal;
						$contenido['vendedor'] = $vendedor;
       break;
    }
 } 
 header('Content-Type: application/json');
 echo json_encode($contenido);
