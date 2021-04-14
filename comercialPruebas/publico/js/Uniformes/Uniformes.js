import { ajax_post } from "../../../funciones/ajax_post.js";
import { FiltrosUniformes } from "./FiltrosUniformes.js";
import { GeneraElementoDom } from "../GeneraElementoDom.js";
import { ObtieneElementoDom } from "../ObtieneElementoDom.js";
import { ObtieneUrl } from "../ObtieneUrl.js";
import { ObtieneVariableSession } from "../ObtieneVariableSession.js";
import { TablaUniformes } from "./TablaUniformes.js";

export default async function Uniformes() {
    const $contenedor = GeneraElementoDom("div");
    $contenedor.id = "contenedor";
    ObtieneElementoDom("contenido").appendChild($contenedor);

    await FiltrosUniformes(CargarDatos);

    CargarDatos();

    return $contenedor;
}

/**
 * Esta funcion realiza la carga de los datos de un contenedor Div en el DOM
 * @function CargarDatos
 * @returns {void}
 */
function CargarDatos() {
    const data = new FormData();
    const $contenedor = ObtieneElementoDom("contenedor");
    data.append(
        "idSucursal", ObtieneElementoDom("idSucursal").value
    );
    data.append(
        "tipoUsuario", ObtieneVariableSession("tipoUsuario")
    );
    ajax_post({
        url: ObtieneUrl("php/Uniformes/", "ObtieneUniformes.php"),
        params: data,
        cbSuccess: (json) => {
            $contenedor.innerHTML = null;
            $contenedor.appendChild(TablaUniformes({
                json: json,
                id: "tablaUniformes",
                sizeClass: "lg"
            }));
        }
    });
}