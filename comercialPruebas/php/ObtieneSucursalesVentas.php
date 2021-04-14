<?php	
	require_once("conexion.php");
 require_once("ObtieneDatosTablaMySql.php");
 require_once("ObtieneSucursalesResumenIndicadores.php");
	require_once("ObtieneSucursalesNomina.php");
	require_once("ObtieneSucursalesOrkestra.php");
 
	$idPonderado = ObtieneRequest("idPonderado",0);
 $tipoUsuario = ObtieneRequest("tipoUsuario",4);
 $idSucursal = $tipoUsuario==3 ? $idPonderado : ObtieneRequest("idSucursal",0);
 $idZona = ObtieneRequest("idZona",0);
	$formulario = ObtieneRequest("formulario",3);
	$anio = ObtieneRequest("anio",0);
	$semana = ObtieneRequest("idSemana",0);
	$datos=[];
	if($tipoUsuario == 4 || $formulario==3){
		$datos["Error"] = array("error" => "Tiene que indicar formulario y tipoUsuario ");
		$datos["request"] = $_REQUEST;
		$datos["parametros"] = array(
			"tipoUsuario" =>$tipoUsuario, 
			"formulario" => $formulario,
				"idzona" => $idZona,
 		"idSucursal" => $idSucursal
		);
	}else{
 	switch ($formulario) {
  	case 0:
  		$datos = ObtieneSucursalesNomina($tipoUsuario,$idSucursal,$idZona);
  		break;
	 	case 1:
 		$datos = ObtieneSucursaleResumenIndicadores($anio, $semana, $idSucursal,$idZona); 
  		break;
  	case 2:
  		$datos = ObtieneSucursalesOrkestra($idSucursal,$idZona);
  		break;
  	default:
  		$datos[0]=array("texto" => "No se localizo opcion $formulario");
 	  break; 
 	}
	}	
header('Content-Type: application/json');
echo json_encode($datos);
