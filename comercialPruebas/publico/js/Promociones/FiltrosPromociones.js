import { Input } from "../../../Componentes/Input.js";
import { Select } from "../../../Componentes/Select.js";
import { CargaSucursales } from "../../../funciones/CargaSucursales.js";
import { GeneraElementoDom } from "../GeneraElementoDom.js";
import { ObtieneElementoDom } from "../ObtieneElementoDom.js";
import { ObtieneUrl } from "../ObtieneUrl.js";
import { ObtieneVariableSession } from "../ObtieneVariableSession.js";

export async function FiltrosPromociones() {
    /*Seccion de Filtro de tipo de Consulta Ascendente o Descendente*/
    const formularioFiltros = GeneraElementoDom("form");
    formularioFiltros.id = "formulario-filtros";
    formularioFiltros.appendChild(await Select({
        nombreTabla: 'Anio',
        params: {
            anio: "2021",
            campoValue: "id",
            campoDescripcion: "descripcion"
        },
        url: ObtieneUrl("php/", "ObtieneAnios.php")
    }, 0));
    formularioFiltros.appendChild(await Select({
      nombreTabla: "Promocion",
      params: {
       tabla: 'Promociones',
       campoValue: 'pro01',
       campoDescripcion: 'pro03',
       atributos : 'pro04,pro05'
      },
      url: ObtieneUrl("php/", "ObtieneDatosTablaSqlServer.php")
     }, 0));
     
     
    formularioFiltros.appendChild(FiltroPeriodo());
    const idSucursal = ObtieneVariableSession("tipoUsuario") == 3 ?
        ObtieneVariableSession("idPonderado") : 0;
    formularioFiltros.appendChild(await Select({
        nombreTabla: 'Zonas',
        params: {
            tabla: 'distrito',
            campos: "Id,Nombre",
            campoOrden: "order by Nombre",
            condicion: "where Id in(1,3)",
            campoValue: "Id",
            campoDescripcion: "Nombre"
        },
        url: ObtieneUrl("php/", "ObtieneDatosTablaSqlServer.php")
    }, 1));

    console.log(formularioFiltros.lastChild.lastChild.value);

    const $filtroSucursales = await Select({
        nombreTabla: 'Sucursales',
        params: {
            tabla: "catalogolocaciones",
            campos: 'id,nombre',
            condicion : `where IDistrito = ${formularioFiltros.lastChild.lastChild.value}`,
            campoValue: 'id',
            campoDescripcion: 'nombre'
        },
        url:  ObtieneUrl("php/", "ObtieneDatosTablaSqlServer.php")
    },1);
    formularioFiltros.appendChild( $filtroSucursales);

    document.getElementById("filtros").appendChild(formularioFiltros);
    const $listaPromociones = ObtieneElementoDom("idPromocion"),
        $filtros = ObtieneElementoDom("filtros"),
        $sucursalesList = ObtieneElementoDom("idSucursales"),
        $zonasList = ObtieneElementoDom("idZonas");
    let $fechaInicial = ObtieneElementoDom("periodo-inicial"),
        $fechaFinal = ObtieneElementoDom("periodo-final");
    
    $filtroSucursales.style.display = "none";
    $fechaInicial.value =$listaPromociones.options[$listaPromociones.selectedIndex].getAttribute('data-pro04');
    $fechaFinal.value =$listaPromociones.options[$listaPromociones.selectedIndex].getAttribute('data-pro05');

    const ChangeFiltros = async (e) => {
        $fechaInicial.value =$listaPromociones.options[$listaPromociones.selectedIndex].getAttribute('data-pro04');
        $fechaFinal.value =$listaPromociones.options[$listaPromociones.selectedIndex].getAttribute('data-pro05');
        const $checkSucursales = ObtieneElementoDom("cbSucursales");
        const $checkZonas = ObtieneElementoDom("cbZonas");
        if (e.target.id === "cbZonas") {
            if ($checkZonas.checked === true) {
                $filtroSucursales.style.display = "block";
                await CargaSucursales($sucursalesList, $zonasList, 0);
            } else {
                $checkSucursales.checked = false;
                $filtroSucursales.style.display = "none";
                $sucursalesList.style.display = "none";
            }
        }
        if (e.target === $zonasList) {
            $checkSucursales.checked = false;
            $sucursalesList.style.display = "none";
            await CargaSucursales($sucursalesList, $zonasList);
        }
    }
    formularioFiltros.addEventListener("change", ChangeFiltros);
}

function FiltroPeriodo(){
    const divRangoFecha = GeneraElementoDom("div"),
        label = GeneraElementoDom("label");
    label.innerHTML = "Periodo a Consultar";
    divRangoFecha.appendChild(label);
    divRangoFecha.appendChild(Input("", "text", "periodo-inicial", "fechaInicial", "", 0));
    divRangoFecha.appendChild(Input("", "text", "periodo-final", "fechaFinal", "", 0));
    return divRangoFecha;
}