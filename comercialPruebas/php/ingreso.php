<?php
 require("conexion.php");
 $password = ObtieneRequest("password","");
 $usuario =  ObtieneRequest("usuario","");
 $ingreso = ObtieneValorFuncionMysql("AccesoPonderado","'$usuario','$password'");
 $datos = [];
 if($ingreso == 'CONCEDIDO'){
  $query = "select 
    usuarios.usu01,
 	  usuarios.usu04,
	   accesoponderado.acc02,
	   accesoponderado.acc03 
	  from accesoponderado 
  	inner join usuarios on (accesoponderado.acc01 = usuarios.usu01) 
	  where (usuarios.usu02 = '$usuario')";
   $result = ObtieneResulsetMySql($query);
   $fila = mysqli_fetch_row($result);
   $datos["perfil"] = array(  
    "claveUsuario" => $usuario,
    "idUsuario" => $fila[0],
    "nombreUsuario" => $fila[1],
    "tipoUsuario" => $fila[2],
    "idPonderado" => $fila[3]
   );
 }else{
  $datos['error'] = array(
   "Usuario o Contraseña, incorrecto."
  ); 
 }
 header('Content-Type: application/json');
 echo json_encode($datos);
