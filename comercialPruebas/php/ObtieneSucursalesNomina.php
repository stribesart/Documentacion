<?php

function ObtieneSucursalesNomina($ATipoUsuario,$AIdSucursal,$AIdZona){
 if($AIdZona>0 || $AIdSucursal>0){
  if($AIdZona>0 && $AIdSucursal>0){
   $condicion = "where dzonas.dzo02 = {$AIdSucursal} and dzonas.dzo01 = {$AIdZona}"; 
  }elseif ($AIdSucursal>0) {
   $condicion = "where dzonas.dzo02 = {$AIdSucursal}";
  } else{
   $condicion = "where dzonas.dzo01 = {$AIdZona}"; 
  }  
 }else{
  $condicion = "";
 } 
 if($ATipoUsuario==3){
  $condicion = "where dzonas.dzo02 = {$AIdSucursal}";
 }
 $sucursales = [];
 $nomina = BaseDatos("nomina");
 $sucursales = ObtieneDatosTablaMySql(
  "{$nomina}dzonas",
  " dzonas.dzo02,
    dzonas.dzo04",
  "",
  "",
 $condicion
 );
 return $sucursales;
}
