import { ObtieneUrl } from "../publico/js/ObtieneUrl.js";
import { llenaLista } from "./llenaLista.js";

/**
 * Esta funcion lo que hace es cargar los datos de las listas de sucursales y de zonas
 * @param {DOMString} $sucursalesList - Parametro que identifica a que elemento del DOM se insertaran datos
 * @param {DOMString} $zonasList - Parametro que identifica a que elemento del DOM se insertaran datos
 * @param {string} AModulo - Parametro equis que no se usa, nlo tuvieron que haber quitado mis chavos xD
 */
export async function CargaSucursales($sucursalesList, $zonasList, AModulo){
 await llenaLista($sucursalesList,{
  nombreTabla: 'Sucursales',
  params: {
      tabla: "catalogolocaciones",
      campos: 'id,nombre',
      condicion : `where IDistrito = ${$zonasList.value}`,
      campoValue: 'id',
      campoDescripcion: 'nombre'
  },
  url:  ObtieneUrl("php/", "ObtieneDatosTablaSqlServer.php")
 });
}