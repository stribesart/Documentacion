import { ajax_post } from "../../../funciones/ajax_post.js";
import { GeneraElementoDom } from "../GeneraElementoDom.js";
import { ObtieneElementoDom } from "../ObtieneElementoDom.js";
import { ObtieneVariableSession } from "../ObtieneVariableSession.js";
import { ObtieneUrl } from "../ObtieneUrl.js";
import { CabeceraSolicitar } from "./CabeceraSolicitar.js";
import Tarjeta from "./Tarjeta.js";

export default async function SolicitarUniformes (AJson){
 const $solicitarUniformesFor = GeneraElementoDom("form");

 $solicitarUniformesFor.id = "solicitar-uniformes-form";
 $solicitarUniformesFor.className = "solicitar-uniformes";

 ObtieneElementoDom("header-uniformes-modal").innerHTML = await CabeceraSolicitar(ObtieneElementoDom("idSucursal").value);
 AJson.forEach( element => {
  $solicitarUniformesFor.appendChild(Tarjeta(element));
 });

 $solicitarUniformesFor.addEventListener("change", function (e){
  if(e.target.name === "plu[]"){
   if(e.target.checked === true){
    e.target.parentNode.parentNode.querySelector(":scope > #divSolicitar").style.display = "block";
   }else{
    e.target.parentNode.parentNode.querySelector(":scope > #divSolicitar").style.display = "none";

   }
  }
 });

 ObtieneElementoDom("modal-guardar").removeEventListener("click", EventoGuardar);
 ObtieneElementoDom("modal-guardar").addEventListener("click", EventoGuardar);
 
 return $solicitarUniformesFor;
}

function EventoGuardar(e){
    if(e.target.id === "modal-guardar"){
        const data = new FormData(ObtieneElementoDom("solicitar-uniformes-form"));
        data.append("comentarios",ObtieneElementoDom("comentarios-solicitud-uniformes").value);
        data.append("idSucursal", ObtieneElementoDom("idSucursal").value);
        data.append("idUsuario", ObtieneVariableSession("idUsuario"));
        data.append("idEmpleado", ObtieneElementoDom("idEmpleado").value);
        ajax_post({
         url: ObtieneUrl("php/uniformes/", "GuardarSolicitudUniformes.php"),
         params: data,
         cbSuccess: (json) => {
             console.log(json);
         }
        })
       }
}