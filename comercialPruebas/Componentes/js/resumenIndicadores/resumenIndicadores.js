import { TablaOpcionMenu } from "../../../Componentes/TablaOpcionMenu.js";
import { Table } from "../../../Componentes/Tabla.js";
import { ajax_post } from "../../../funciones/ajax_post.js";
import { Filtros } from "../Filtros.js";
import { GeneraElementoDom } from "../GeneraElementoDom.js";
import { ObtieneElementoDom } from "../obtieneElementoDom.js";
import { ObtieneUrl } from "../ObtieneUrl.js";
import { ObtieneVariableSession } from "../ObtieneVariableSession.js";
import { Modal } from "../masVendidos/Modal.js";

export default async function ResumenIndicadores() {
    await Filtros(1, CargarDatos);
    let container = GeneraElementoDom("div");
    container.id = "container";
    ObtieneElementoDom("contenido").appendChild(container);

    container = ObtieneElementoDom("container");
    ObtieneElementoDom("titulos").innerHTML = "<h1>Resumen Indicadores</h1>";

    await CargarDatos();
    container.addEventListener("click", (e) => {
        console.log(e.target.getAttribute("data-selected-tabla-sucursales-ventas"));
        if (e.target.getAttribute("data-selected-tabla-sucursales-ventas") != undefined || e.target.parentNode.getAttribute("data-selected-tabla-sucursales-ventas") != undefined) {
            const sucursal = (e.target.getAttribute("data-selected-tabla-sucursales-ventas") != undefined) ? e.target.getAttribute("data-selected-tabla-sucursales-ventas") : e.target.parentNode.getAttribute("data-selected-tabla-sucursales-ventas");
            console.log(sucursal);
            let $modal = document.getElementById('indicadores-modal');
            if($modal === null){
                $modal = new bootstrap.Modal(Modal("indicadores-modal", "Empleados", GeneraContenidoModal(sucursal)));
            }else{
                let modalBody = ObtieneElementoDom("modal-body-indicadores-modal");
                modalBody.innerHTML = null;
                modalBody.appendChild(GeneraContenidoModal(sucursal));
                $modal = bootstrap.Modal.getInstance($modal);
            }
            $modal.show();

        }
    });

    return container;
}

async function CargarDatos() {
    const container = ObtieneElementoDom("container");
    const $contendor = GeneraElementoDom("div");
    const data = new FormData(ObtieneElementoDom("filtros-form")),
        url = ObtieneUrl("php/resumenIndicadores/", "ObtieneResumenIndicadores.php");
    data.append("tipoUsuario", ObtieneVariableSession("tipoUsuario"));
    data.append("idPonderado", ObtieneVariableSession("idPonderado"));
    data.append("tipoConsulta", 0);
    container.innerHTML = null;
    await ajax_post({
        url: url,
        params: data,
        cbSuccess: (json) => {
            $contendor.appendChild(TablaOpcionMenu(json.zonas.ZonasVentas, "tabla-zonas-ventas", "table-lg", "res03", 2));
            $contendor.appendChild(TablaOpcionMenu(json.zonas.ZonasPaseantes, "tabla-zonas-paseantes", "table-md", "res03", 2, 3, 1));

            $contendor.appendChild(TablaOpcionMenu(json.sucursales.SucursalesVentas, "tabla-sucursales-ventas", "table-lg", "res03", 1));
            $contendor.appendChild(TablaOpcionMenu(json.sucursales.SucursalesPaseantes, "tabla-sucursales-paseantes", "table-md", "res03", 2, 3,1));
        }
    });
    container.appendChild($contendor);
}

function GeneraContenidoModal(sucursal) {
    const $contendor = GeneraElementoDom("div");
    const data = new FormData(ObtieneElementoDom("filtros-form"));

    data.append("tipoUsuario", ObtieneVariableSession("tipoUsuario"));
    data.append("idPonderado", ObtieneVariableSession("idPonderado"));
    data.append("tipoConsulta", 2);
    data.set("cbSucursales", "on");
    data.set("idSucursales", sucursal);

    ajax_post({
        url: ObtieneUrl("php/resumenIndicadores/", "ObtieneResumenIndicadores.php"),
        params: data,
        cbSuccess: (json) => {
            $contendor.appendChild(TablaOpcionMenu(json.sucursal.SucursalesVentas, "tabla-empleados", "table-lg", "", 2));
            $contendor.appendChild(TablaOpcionMenu(json.empleados, "tabla-empleados", "table-lg", "", 2));
        }
    });

    return $contendor;
}