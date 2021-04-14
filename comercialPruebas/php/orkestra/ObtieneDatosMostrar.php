<?php
 function ObtieneDatosMostrar($AQuery,$ANombre,$ATipoConsulta,$AIdConsulta,$AAnio,$ANivel){
  $resultado = [];
  $idx = 0;
  $result = ObtieneResulsetSqlServer($AQuery);
	 while ($row = odbc_fetch_array($result)){
   $cumplimiento = $row['sugeridos'] <> 0 ? ($row['prospeccion'] * 100)  / $row['sugeridos'] : 0;
   $tcContacto = $row['prospeccion'] <> 0 ? ($row['prospectosventa'] * 100)  / $row['prospeccion'] : 0;
   $totalLigas = $row['ligasPendientes'] + $row['ventaligas'];
   $cumple = $totalLigas <> 0 ? $row['ventaligas'] / $totalLigas : 0;
   $resultado[$idx] = array(
    $ANombre == "General" ? $ANombre : utf8_encode($row[$ANombre]),
     number_format($row['contactos'],0),
     number_format($row['sugeridos'],0),
     number_format($row['prospeccion'],0),
     number_format($cumplimiento,2)."%",
     number_format($row['prospectosventa'],0),
     number_format($tcContacto,2)."%",
     number_format($row['ventas'],2),
     number_format($row['ventaligas'],2),
     number_format($row['ventaligas']+$row['ventas'],2),
   );  
   if($ANivel < 3 ){
	
				$id = $ANivel == 1 ? $row["IdDistrito"] : 0;
				$id = $ANivel == 2 ? $row["idRmetrics"] : $id;
				$ventaPonderado = ObtieneVentasPonderado($ATipoConsulta,$AIdConsulta,$AAnio,$ANivel,$id);
    array_push($resultado[$idx],number_format($ventaPonderado,2));
				$porcentajePonderado = $ventaPonderado	!= 0 ? number_format(($row['ventaligas']*100)/$ventaPonderado,0)."%" : "";		  
    array_push($resultado[$idx],$porcentajePonderado);
  }
	 if ($ANombre=="nombre"){array_push($resultado[$idx],$row['IdLocacion']);}
  $idx++;
	}
 return $resultado;
}



function ObtieneVentasPonderado($ATipoConsulta,$AIdConsulta,$AAnio,$ANivel,$AId){
	switch ($ANivel) {
		case 0:
			$parametros = "{$ATipoConsulta},0,$AIdConsulta,$AAnio,0,'0'";
			break;
		case 1:
			$parametros = "{$ATipoConsulta},0,$AIdConsulta,$AAnio,1,'{$AId}'";
			break;
		case 2:
			$parametros = "{$ATipoConsulta},0,$AIdConsulta,$AAnio,2,'{$AId}'";
		#var_dump($parametros);
			break;
	}
	$ventaPonderado =  ObtieneValorFuncionMysql("ObtieneVentaPonderado",$parametros);
 return $ventaPonderado;
}