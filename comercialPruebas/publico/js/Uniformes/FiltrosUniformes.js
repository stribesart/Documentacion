import { GeneraElementoDom } from "../GeneraElementoDom.js";
import { Select } from "../../../Componentes/Select.js";
import { ObtieneVariableSession } from "../ObtieneVariableSession.js";
import { ObtieneUrl } from "../ObtieneUrl.js";
import { ObtieneElementoDom } from "../ObtieneElementoDom.js";
import { Button } from "../../../Componentes/Button.js";
import { Modal } from "../masVendidos/Modal.js";
import { ajax_post } from "../../../funciones/ajax_post.js";
import { CabeceraSolicitar } from "./CabeceraSolicitar.js";

export async function FiltrosUniformes(cbChange) {
    const elemento = GeneraElementoDom("div");
    const $filtros = ObtieneElementoDom("filtros");
    const idSucursal = ObtieneVariableSession("idPonderado") === 3 ? ObtieneVariableSession("idPonderado") : "";
    $filtros.innerHTML = null;
    elemento.appendChild(
        await Select({
            nombreTabla: "Sucursal",
            params: {
                campoValue: "suc01",
                campoDescripcion: "suc03",
                idSucursal: idSucursal
            },
            url: ObtieneUrl("php/Uniformes/", "ObtieneSucursalesUniformes.php")
        })
    );

    elemento.appendChild(
        Button(
            "Solicitar",
            "Solicitar",
            "btn-secondary",
            "modulo-uniformes",
            "SolicitarUniformes"
        )
    );

    elemento.appendChild(
        Button(
            "Aceptar",
            "Aceptar",
            "btn-secondary",
            "modulo-uniformes",
            "AceptarUniformes"
        )
    );

    elemento.appendChild(
        Button(
            "Rechazar",
            "Rechazar",
            "btn-secondary"
        )
    );

    elemento.appendChild(
        Button(
            "Formato",
            "Formato",
            "btn-secondary"
        )
    );

    elemento.addEventListener("change", (e) => {
        cbChange();
    });

    elemento.addEventListener("click", async (e) => {
        if(e.target.tagName === "BUTTON"){
            let $modal = document.getElementById("uniformes-modal");
            const modulo = e.target.getAttribute("data-modulo-uniformes");
            if($modal === null){
                $modal = new bootstrap.Modal(Modal("uniformes-modal", "Vendedores",await GeneraContenidoModal(modulo), 1, "modal-fullscreen"));
            }else{
                let modalBody = ObtieneElementoDom("modal-body-uniformes-modal");
                modalBody.innerHTML = null;
                modalBody.appendChild(await GeneraContenidoModal(modulo));
                $modal = bootstrap.Modal.getInstance($modal);
            }
            $modal.show();
        }
    });
    $filtros.appendChild(elemento);
}

async function GeneraContenidoModal(Amodulo){
    const $contenedor = GeneraElementoDom("div");
    $contenedor.className = "solicitar-uniformes";
    const modulo = await import(`./${Amodulo}.js`).then((module) => module);
    const data = new FormData();
    data.append("idSucursal", ObtieneElementoDom("idSucursal").value);
    ajax_post({
        url: ObtieneUrl("php/uniformes/","ObtieneSolicitudUniformes.php"),
        params: data,
        cbSuccess:async (json) => {
            $contenedor.appendChild(await modulo.default(json));
        }
    });

    return $contenedor;
}