import { Input } from "../../../Componentes/Input.js";
import { Select } from "../../../Componentes/Select.js";
import { CargaSucursales } from "../../../funciones/CargaSucursales.js";
import { GeneraElementoDom } from "../GeneraElementoDom.js";
import { ObtieneElementoDom } from "../ObtieneElementoDom.js";
import { ObtieneUrl } from "../ObtieneUrl.js";
import { ObtieneVariableSession } from "../ObtieneVariableSession.js";
import { ModalHTML } from "./modalHTML.js";

// const divTabla = GeneraElementoDom("div");
// divTabla.appendChild(await Select({
//     nombreTabla: nombreTabla,
//     params: params,
//     url: url
// }, tipo));

export async function FiltrosMasVendidos(cbChange) {
    /*Seccion de Filtro de tipo de Consulta Ascendente o Descendente*/
    const formularioFiltros = GeneraElementoDom("form"),
     $ventanaModal = ObtieneElementoDom("ventanaModal");
    formularioFiltros.id = "formulario-filtros";

    $ventanaModal.innerHTML = ModalHTML("lg");
    formularioFiltros.appendChild(FiltroTipoConsulta());
    formularioFiltros.appendChild(FiltroPeriodo());
    formularioFiltros.appendChild(await 
        Select({
            nombreTabla: "Temporada",
            params: {
            },
            url: ObtieneUrl("php/masVendidos/", "ObtieneTemporadas.php")
        }, 0));

    const idSucursal = ObtieneVariableSession("tipoUsuario") == 3 ?
        ObtieneVariableSession("idPonderado") : 0;
    formularioFiltros.appendChild(await Select({
        nombreTabla: 'Zonas',
        params: {
            tipoUsuario: sessionStorage.getItem("tipoUsuario"),
            idSucursal: idSucursal,
            campoValue: "zon01",
            campoDescripcion: "zon02"
        },
        url: ObtieneUrl("php/masVendidos/", "ObtieneZonas.php")
    }, 1));

    const $filtroSucursales = await Select({
        nombreTabla: 'Sucursales',
        params: {
            tipoUsuario: ObtieneVariableSession("tipoUsuario"),
            idPonderado: ObtieneVariableSession("idPonderado"),
            formulario: 0,
            campoValue: "dzo02",
            campoDescripcion: "dzo04"
        },
        url: ObtieneUrl("php/masVendidos/", "ObtieneSucursalesVentas.php")
    },1);
    formularioFiltros.appendChild( $filtroSucursales);

    formularioFiltros.appendChild(await Select({
        nombreTabla: 'Departamento',
        params: {},
        url: ObtieneUrl("php/masVendidos/", "ObtieneDepartamentos.php")
    }, 1));

    formularioFiltros.appendChild(await Select({
        nombreTabla: 'Seccion',
        params: {
            campoValue: "sec01",
            campoDescripcion: "sec03"
        },
        url: ObtieneUrl("php/masVendidos/", "ObtieneSecciones.php")
    }, 1));

    document.getElementById("filtros").appendChild(formularioFiltros);
    const $filtros = ObtieneElementoDom("filtros");
    const $sucursalesList = ObtieneElementoDom("idSucursales");
    const $zonasList = ObtieneElementoDom("idZonas");
    const fechaActual = new Date(),
      $fechaInicial = ObtieneElementoDom("periodo-inicial").defaultValue = moment().subtract(1, 'month').subtract(fechaActual.getDate()-1,'days').format().substring(0,10),
      $fechaFinal = ObtieneElementoDom("periodo-final").defaultValue = moment().format().substring(0,10);

    $filtroSucursales.style.display = "none";
    formularioFiltros.addEventListener("change", async function(e) {
    if (e.target.id === "cbZonas") {
        const $checkZonas = ObtieneElementoDom("cbZonas");
            const $checkSucursales = ObtieneElementoDom("cbSucursales");
            if ($checkZonas.checked === true) {
                $filtroSucursales.style.display = "block";
                CargaSucursales($sucursalesList, $zonasList, 0);
            } else {
                $checkSucursales.checked = false;
                $filtroSucursales.style.display = "none";
                $sucursalesList.style.display = "none";
            }
        }
        if (e.target === $zonasList) {
            CargaSucursales($sucursalesList, $zonasList);
        }

        cbChange();
    });
}
function FiltroTipoConsulta(){
  const divRadio = GeneraElementoDom("div");
  let nombreLabel1;
  let nombreLabel2;
  
  nombreLabel1 = "Mas Vendidos";
  nombreLabel2 = "Menos Vendidos";
  
  divRadio.appendChild(Input(nombreLabel1, "radio", 'radio-mas-vendidos', "tipoConsulta", "0", 1, 0));
  divRadio.appendChild(Input(nombreLabel2, "radio", 'radio-menos-vendidos', "tipoConsulta", "1", 1));
  return divRadio;
}
function FiltroPeriodo(){
  const divRangoFecha = GeneraElementoDom("div");
  divRangoFecha.appendChild(Input("Periodo a Consultar ", "date", "periodo-inicial", "fechaInicial", ""));
  divRangoFecha.appendChild(Input("", "date", "periodo-final", "fechaFinal"));
  return divRangoFecha;
}