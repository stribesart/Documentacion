<?php
include_once("../conexion.php");
include_once("../ObtieneDatosTablaMySql.php");

	$datos = [];
 $compras = BaseDatos("compras");
 $anio = ObtieneValorCampoMySql("{$compras}vexistenciauniformes","max(exi02)","");
 $mes = ObtieneValorCampoMySql("{$compras}vexistenciauniformes","exi03"," where exi02 = {$anio}");
 $query = "select * 
	 from {$compras}vexistenciauniformes 
		where ( (vexistenciauniformes.exi02 = {$anio}) 
		  and   (vexistenciauniformes.exi03 = {$mes}) 
				and   (vexistenciauniformes.exi10 > 0) 
				and   (vexistenciauniformes.uni09=1)) 
				group by vexistenciauniformes.cod10";
	$resultUniformes = ObtieneResulsetMySql($query);	
 $i=0;
 while ($fila = mysqli_fetch_array($resultUniformes)){ 
		$linea=[]; 
	 $linea["cod01"]        = $fila["cod01"];
	 $linea["cod10"]        = $fila["cod10"];
	 $linea["Familia"]      = $fila["fam04"];
	 $linea["Seccion"]      = $fila["sec03"];
	 $linea["Departamento"] = $fila["dep02"];
	 $linea["Temporada"]    = $fila['tem02'];
	 $linea["imagen"]       = $fila['imagen'];
	 $linea["tallas"]       = ObtieneDatosTablaMySql(
   " {$compras}vexistenciauniformes ",
			" vexistenciauniformes.exi01, 
			  vexistenciauniformes.tal02, 
					vexistenciauniformes.exi10, 
					vexistenciauniformes.cod01, 
					vexistenciauniformes.exi04 ",
			"",
			"where ( (vexistenciauniformes.exi02 = {$anio}) 
			   and   (vexistenciauniformes.exi03 = {$mes}) 
						and   (vexistenciauniformes.exi10 > 0) 
						and   (vexistenciauniformes.uni09 = 1) 
						and   (vexistenciauniformes.cod10 = '{$fila['cod10']}'))",
			"order by vexistenciauniformes.tal02"
		);
	$datos[$i] = $linea;	
 $i++;
}  

header('Content-Type: application/json');
echo json_encode($datos);

