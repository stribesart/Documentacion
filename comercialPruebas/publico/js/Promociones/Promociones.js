import { ajax_post } from "../../../funciones/ajax_post.js";
import { Table } from "../../../Componentes/Tabla.js";
import { FiltrosPromociones } from "./FiltrosPromociones.js";
import { ObtieneElementoDom } from "../obtieneElementoDom.js";
import { ObtieneUrl } from "../ObtieneUrl.js";
import { GeneraElementoDom } from "../GeneraElementoDom.js";
import { ObtieneVariableSession } from "../ObtieneVariableSession.js";
import { llenaTablaPromociones } from "./llenaTablaPromociones.js";

export default async function Promociones(){
    const $contenido = GeneraElementoDom("div");
    ObtieneElementoDom("titulos").innerHTML = "<h1>Promociones</h1>";
    await FiltrosPromociones();
    const $filtros = ObtieneElementoDom("formulario-filtros");

    $contenido.appendChild(CargarDatos($filtros,"ObtienePromociones.php"));
    // $contenido.appendChild(CargarDatos($filtros,"ObtieneDatosPromocionesSucursal.php"));

    $filtros.addEventListener('change', async (e) => {
        $contenido.innerHTML = null;
        $contenido.appendChild(CargarDatos($filtros,"ObtienePromociones.php"));
        // $contenido.appendChild(CargarDatos($filtros,"ObtieneDatosPromociones.php"));
    //    $contenido.appendChild(Table($filtros,"ObtieneDatosPromocionesSucursal.php"));
    });

    return $contenido;
}

function CargarDatos(formularioFiltros, APagina, ) {
    const $contenedor = GeneraElementoDom("div");
    const data = new FormData(formularioFiltros),
        url = ObtieneUrl("php/promociones/", APagina);
        data.append("tipoUsuario", ObtieneVariableSession("tipoUsuario"));
        data.append("idPonderado", ObtieneVariableSession("idPonderado"));
    ajax_post({
        url: url,
        params: data,
        cbSuccess: (json) => {
            // $contenedor.appendChild(Table(json, 'tabla-promociones-sucursal', 'tabla-lg', "", 2,4));//Ejemplo de como se llena la tabla dinamica
            $contenedor.appendChild(llenaTablaPromociones(json.Zonas));
            $contenedor.appendChild(llenaTablaPromociones(json.Sucursales));
        }
    });
    return $contenedor;
   }