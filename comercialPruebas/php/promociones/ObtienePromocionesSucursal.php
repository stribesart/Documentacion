<?php
function ObtienePromocionesSucursal($AIdPromocion, $AIdSucursal, $AIdPrecio){
   $query = "
    select 
     case when sum(detallepromocionsucursal.det04) is null then 0 else sum(detallepromocionsucursal.det04) end as inicial,
     case when sum(detallepromocionsucursal.det05) is null then 0 else sum(detallepromocionsucursal.det05) end as unidades,
     case when sum(detallepromocionsucursal.det06) is null then 0 else sum(detallepromocionsucursal.det06) end as pesos,
     sum(detallepromocionsucursal.det07) as final
    from detallepromocionsucursal
    inner join catalogolocaciones on (detallepromocionsucursal.det02 = catalogolocaciones.id)
    inner join distrito on (catalogolocaciones.IDistrito = distrito.Id) 
    where ((detallepromocionsucursal.det01 = '$AIdPromocion')
      and  (catalogolocaciones.id = '$AIdSucursal')
      and  (detallepromocionsucursal.det03 = '$AIdPrecio'))
      ";   
   $result = ObtieneResulsetSqlServer($query);   
   return $result;
  } 
