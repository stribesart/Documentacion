import { TablaOpcionMenu } from "../../../Componentes/TablaOpcionMenu.js";
import { Tarjeta } from "../../../Componentes/Tarjeta.js";
import { ajax_post } from "../../../funciones/ajax_post.js";
import { CrearFragmento } from "../CrearFragmento.js";
import { GeneraElementoDom } from "../GeneraElementoDom.js";
import { ObtieneElementoDom } from "../ObtieneElementoDom.js";
import { ObtieneUrl } from "../ObtieneUrl.js";
import { FiltrosMasVendidos } from "./FiltrosMasVendidos.js";

export default async function MasVendidos() {
    const $fragmentoContenido = CrearFragmento(),
        $contenedor = GeneraElementoDom("section");
    $contenedor.classList.add("contenedor");
    $contenedor.id = "conTarjeta";
    const $filtrosContenedor = ObtieneElementoDom("filtros");
    ObtieneElementoDom("contenido").appendChild($contenedor); 

    
    ObtieneElementoDom("titulos").innerHTML = "<h1>Mas Vendidos</h1>";
    await FiltrosMasVendidos(cargaContenido);
    
    
    cargaContenido();
    
    $contenedor.addEventListener("click", async (e) => {
        let $modal;
        if (e.target.getAttribute("data-selected") != null || e.target.parentNode.parentNode.getAttribute("data-selected") != null) {
            const codigoPrada = e.target.getAttribute("data-selected"),
            $tarjeta = ObtieneElementoDom(codigoPrada).cloneNode(true);
            $tarjeta.lastChild.childNodes.item("15").style.display = "none";
            $tarjeta.lastChild.childNodes.item("15").classList.remove("d-grid");
            $tarjeta.lastChild.childNodes.item("15");
            let pagina;
            switch (e.target.id) {
                case "tallas":
                    pagina = "ObtieneTallas.php";
                    break;
                    case "tiendas":
                        pagina = "ObtieneSucursales.php";
                        break;
                        case "tickets":
                            pagina = "ObtieneTickets.php";
                            break;
                        }
                        const $tabla = await ObtieneDatos(pagina, codigoPrada);
                        const $cuerpoModal = GeneraElementoDom("div");
                        $cuerpoModal.classList.add("contenedor");
                        $cuerpoModal.appendChild($tarjeta);
                        $cuerpoModal.appendChild($tabla); 
                        
                        LanzaModal({titulo:e.target.id, texto:$cuerpoModal});
        }
        if (e.target.id === "close-button") {
            const $eliminar = document.body.lastChild;
            document.body.removeChild($eliminar);
        }
    });
    
    return $contenedor;
}

async function cargaContenido() {
    const data = new FormData(ObtieneElementoDom("formulario-filtros"));
    const contenedor = ObtieneElementoDom("conTarjeta"); 
    let $tarjeta;
    await ajax_post({
        url: "http://oficinas.prada.mx:72/comercialPruebas/php/masVendidos/ObtieneMasVendidos.php",
        params: data,
        cbSuccess: (json) => {
            if (json.length === 0) {
                contenedor.innerHTML = "<h3 class = 'no-data-message'>No hay datos</h3>";
            }
            contenedor.innerHTML= null;
            json.forEach(registro => {
                $tarjeta = Tarjeta(registro);
                contenedor.appendChild($tarjeta);
            });
        }
    });
    return contenedor;
}

async function ObtieneDatos(APagina, ACodigoPrada) {
    const url = ObtieneUrl("php/masVendidos/", APagina);
    const data = new FormData(ObtieneElementoDom("formulario-filtros"));
    let $tablaProducto;

    data.append("codigoPrada", ACodigoPrada);
    data.append("tipoUsuario", sessionStorage.getItem("tipoUsuario"));
    await ajax_post({
        url: url,
        params: data,
        cbSuccess: (json) => {
            $tablaProducto = TablaOpcionMenu(json, "tabla-productos", "table-lg", "", 2);
        }
    });
    return $tablaProducto;
}
function LanzaModal(AParametros){
    const {titulo, texto} = AParametros;
    document.getElementsByClassName("modal-body").item("0").innerHTML = texto.innerHTML;
    document.getElementById("tituloVentana").innerHTML = titulo;
    document.getElementById("botonVentana").click();
}