import { ObtieneUrl } from "../publico/js/ObtieneUrl.js";
import { llenaLista } from "./llenaLista.js";

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