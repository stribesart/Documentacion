<?php
 function BaseDatos($AIdBaseDatos){
  switch ($AIdBaseDatos) {
   case 'nomina':
    $baseDatos = "pruebasnomina.";
    break;
   case 'compras':
    $baseDatos = "pruebascompras.";
    break;
   case 'facturacion':
    $baseDatos = "pruebasfacturacion18.";
    break;
   case 'rmetrics':
    $baseDatos = "pruebasrmetrics_";
    break;
   default:
    $baseDatos = "pruebasconfiguracion";
    break;
  }
  return $baseDatos;
}

function EstableceConexionMySql(){
 $servername = "192.168.1.195";
 $database = "pruebasconfiguracion";
 $username = "root";
 $password = "r3m3tr1csprada"; 
 $conexion = mysqli_connect($servername, $username, $password, $database);
 if (!$conexion) {
  die("Error en Conexion: " . mysqli_connect_error());
 }
 return $conexion;
}

function EstableceConexionSqlServer(){
 $user = "sa";
 $clave="81X38oso"; 
 $server = '192.168.1.195';
 $database = 'HUBSPOT';
 $connection = odbc_connect(
  "Driver={ODBC Driver 11 for SQL Server};Server=$server;Database=$database;",
  $user, 
  $clave);
 if (!$connection){die("Error en conexion"); }	
 return $connection;
}	

function ObtieneRequest($AParametro, $AValorDefault){
 $parametro = isset($_REQUEST[$AParametro]) ? 
  addslashes($_REQUEST[$AParametro]) : 
  $AValorDefault;
 return $parametro; 
}

function ObtieneResulsetMySql($query){
 $conexion = EstableceConexionMySql(); 
 $result = mysqli_query($conexion,$query);
 return $result;
}
		
function ObtieneResulsetSqlServer($query){
 $conexion = EstableceConexionSqlServer(); 
 $result = odbc_exec($conexion, $query);
 return $result;
}

function ObtieneValorCampoMySql($ATabla, $ACampo, $ACondicion){
 $query= "
  select 
   $ACampo  
  from $ATabla 
  $ACondicion";
 $result =ObtieneResulsetMySql($query);
 $fila = mysqli_fetch_array($result); 
 return $fila[0];
}

function ObtieneValorCampoSqlServer($ATabla, $ACampo, $ACondicion){
 $query= "
  select 
   $ACampo 
  from $ATabla
  $ACondicion";
 $result =ObtieneResulsetSqlServer($query);
 $fila = odbc_fetch_array($result); 
 return $fila[$ACampo];
}

function ObtieneValorFuncionMysql($AFuncion, $AValores){
 $query= "select  $AFuncion($AValores) as valor";
 $result =ObtieneResulsetMySql($query);
	if($result){
		$fila = mysqli_fetch_array($result); 
  return $fila[0];
	}	
}

function ObtieneValorFuncionSqlServer($AFuncion, $AValores){
 $query= "select $AFuncion($AValores)";
 $result =ObtieneResulsetSqlServer($query);
 $fila = mysqli_fetch_array($result); 
 return $fila[0];
}


