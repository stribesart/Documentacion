<?php
function ObtieneNumeroSemana($AIdSemana){
	$rmetrics = BaseDatos("rmetrics");
	$numeroSemana = ObtieneValorCampoMySql(
  "{$rmetrics}prada.periodossemanales",
		"nsemana",
		"where periodossemanales.id = {$AIdSemana}"
	);
	return $numeroSemana;
}
