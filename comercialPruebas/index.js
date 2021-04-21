
// (async function (){
// })();

import { limpiarContenido } from "./publico/js/limpiarContenido.js";
import { ObtieneElementoDom } from "./publico/js/obtieneElementoDom.js";

/**
 * Se crea una variable llamada menu, esta varible nos sirve de apoyo para agregar el evento para cada
 * modulo que se ira creando. En este archivo se agrega el evento al menu para poder cargar contenido
 * diferente por elemento del menu.
 * @name MenuNavegacion
 */
const $menu = document.getElementById("menu-principal");

$menu.addEventListener("click", async (e)=>{
 if(e.target.getAttribute("data-modulo") != null){
  const $contenido = ObtieneElementoDom("contenido");
  const $filtros = ObtieneElementoDom("filtros");
  const $filtrosUniformes = ObtieneElementoDom("filtros-uniformes");
  const nombreComponente = e.target.getAttribute("data-modulo");
  const rutaComponente = `${nombreComponente}/${nombreComponente}.js`;
  const modales = ObtieneElementoDom("modal", true);
  if(modales != null){
   for(let modal of modales){
    modal.parentNode.removeChild(modal);
   }
  }

  limpiarContenido();
  e.target.disabled = true;
  const modulo = await import(`./publico/js/${rutaComponente}`).then((module) => module);
  $contenido.appendChild( await modulo.default());
  e.target.disabled = false;
 }
});

