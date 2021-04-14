<?php
	function ObtieneTotalMetaZona($AIdSemana,$ATipoVenta,$AIdZona){
		$condicion = $AIdZona == 0 ? "" : " and (ajusteponderado.aju03 = $AIdZona)";
  $totalMetaZona = ObtieneValorCampoMySql(
			"ajusteponderado ",
	 	"sum(ajusteponderado.aju04) as aju04",
   "where ((ajusteponderado.aju01 = $AIdSemana)
			   and (ajusteponderado.aju02 = $ATipoVenta)
						$condicion)"
		);
		$decimales = $ATipoVenta==0 ? 2 : 0;
		return number_format($totalMetaZona,$decimales);
	}
