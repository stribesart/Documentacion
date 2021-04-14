<?php	
 require_once("conexion.php");
	require_once("ObtieneDatosTablaMySql.php");
	require_once("ObtieneSemanasMes.php");
	require_once("ObtieneZonasResumenIndicadores.php");
	require_once("ObtieneZonasNomina.php");
 require_once("ObtieneZonasIntegracion.php");
 
	function ValidaParametros($ATipoUsuario,$AFormulario,$AIdSemana,$AAnio,$ATipoVenta){
		$validacion =	$ATipoUsuario == 4 || $AFormulario == 3 ? false : true; 
		if ($validacion && $AFormulario == 1){
			$validacion = $AIdSemana == 0 || $AAnio == 0 || $ATipoVenta==2 ? false : true;
		}
		return $validacion;
	}

 $anio = ObtieneRequest("anio",0);
 $idSemana = ObtieneRequest("idSemana",0);
 $idMes = ObtieneRequest("idMes",0);
 $tipoUsuario = ObtieneRequest("tipoUsuario",4);
 $idSucursal = ObtieneRequest("idSucursal",0);
	$formulario = ObtieneRequest("formulario",3);
	$tipoVenta = ObtieneRequest("tipoVenta",2);

 $datos=[];
	if(!ValidaParametros($tipoUsuario,$formulario,$idSemana,$anio,$tipoVenta)){
		$datos["Error"] = array("error" => "Tiene que indicar formulario y tipoUsuario
		para indicadores tipoVenta, idSemana y anio ");
		$datos["parametros"] = array(
	 	"anio" => $anio,
			"idSemana" => $idSemana,
			"tipoUsuario" =>$tipoUsuario, 
			"formulario" => $formulario,
 		"idSucursal" => $idSucursal,
			"tipoVenta" => $tipoVenta 
		);
	}else{
	 switch ($formulario) {
	 	case 0:
	 		$datos = ObtieneZonasNomina($tipoUsuario,$idSucursal);
	 		break;
	 	case 1:
				$datos = ObtieneZonasResumenIndicadores($anio, $idSemana,$tipoUsuario, $idSucursal,$tipoVenta,$idMes);
				break;
			case 2:
				$datos = ObtieneZonasIntegracion($idSucursal);
				break;
			default:
				$datos[0]=array("texto" => "No se localizo opcion $formulario");
	 	 break;
	 }
 }
	header('Content-Type: application/json');
 echo json_encode($datos);

