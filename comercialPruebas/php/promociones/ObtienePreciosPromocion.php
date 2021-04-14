<?php
 function ObtienePreciosPromocion($AIdPromocion){
  $query = "
   select 
    preciospromocion.pre02,
    preciospromocion.pre03 
   from preciospromocion
   where pre01 = '$AIdPromocion'"; 
  $result = ObtieneResulsetSqlServer($query);   
  return $result;
 }
