<?php
 function CalculaPorcentaje($divisor, $dividendo){
  $porcentaje = 0;  
  if ($divisor != 0) {
   $porcentaje = ($dividendo * 100) / $divisor;
  }
  return $porcentaje;	 
 }