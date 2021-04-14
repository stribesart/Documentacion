 <?php
	require("../conexion.php");
 $ids = ObtieneRequest("ids","");
 $semanas = ObtieneRequest("semanas",3);       
 $idUsuario = ObtieneRequest("idUsuario",0);
 $comentarios = ObtieneRequest("comentarios","");
 $mensaje = 
	 array(
		 "mensaje" => ObtieneValorFuncionMysql(
		  "AceptaSolicitudUniformes",
		  "'{$ids}',{$semanas},{$idUsuario},'{$comentarios}'"
	  )
	 );
header('Content-Type: application/json');
echo json_encode($mensaje);