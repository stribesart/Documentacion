import { ajax_post } from "../../../funciones/ajax_post.js";
import { ObtieneUrl } from "../ObtieneUrl.js";

export async function CabeceraSolicitar(AidSucursal){
return `<h4>SOLICITUD DE UNIFORMES</h4>
<div id="caja-filtros">
  <div class="form-group">
   <div id="empleados"> 
    ${ await ObtieneEmpleados(AidSucursal)}
   </div>
  </div>
  <div class="form-group">
   <label for="comentarios">Comentarios:</label>
   <input class="form-control" id="comentarios-solicitud-uniformes" type="text" name="comentarios" placeholder="Ingrese sus comentarios." size="50">
  </div>
 </div>
 <div id="nota">
  <p>Nota: En caso de no encontrar la talla es por que no hay disponible en stock, favor de seleccionar otra talla.</p>
 </div>`;
}

async function ObtieneEmpleados(AidSucursal){
 const data = new FormData();
 let selecEmpleados = `<p>Empleados:</p><select class="form-control" name="idEmpleado" id="idEmpleado">`;
 data.append("idSucursal", AidSucursal);
 await ajax_post({
  url: ObtieneUrl("php/Uniformes/", "ObtieneEmpleadosSucursal.php"),
  params: data,
  cbSuccess: (json) => {
      json.forEach( empleado => {
        selecEmpleados+= `<option value = "${empleado.vsi01}">${empleado.vsi02}</option>`
      });
  }
  });
  
  selecEmpleados+=`</select>`
  return selecEmpleados;
}