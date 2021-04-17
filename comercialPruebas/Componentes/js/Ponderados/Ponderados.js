import { ajax_post } from "../../../funciones/ajax_post.js";
import { Filtros } from "../Filtros.js";
import { GeneraElementoDom } from "../GeneraElementoDom.js";
import { ObtieneElementoDom } from "../obtieneElementoDom.js";
import { ObtieneUrl } from "../ObtieneUrl.js"
import { ObtieneVariableSession } from "../ObtieneVariableSession.js";
import {TablaPonderados} from "./TablaPonderados.js";

export default async function Ponderado(){
 const $contendor = GeneraElementoDom("div");
 ObtieneElementoDom("titulos").innerHTML = "<h1>Ponderados</h1>";
 await Filtros(0, CargarDatos);
 CargarDatos();

 return $contendor;

}

function CargarDatos() {
 const $contendor = GeneraElementoDom("div");
 const data = new FormData(ObtieneElementoDom("filtros-form")),
     url = ObtieneUrl("php/ponderado/", "ObtienePonderado.php");
     data.append("tipoUsuario", ObtieneVariableSession("tipoUsuario"));
 ajax_post({
     url: url,
     params: data,
     cbSuccess: (json) => {
        TablaPonderados(json);
     }
 });
 return $contendor;
}