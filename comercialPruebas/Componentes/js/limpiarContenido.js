/**
 * Esta funcion lo que hace es limpiar el contenido de los titulos, filtros y contenido
 * @name LimpiarContenido
 */
export function limpiarContenido(){
 limpiarElemento("titulos");
 limpiarElemento("filtros");
 limpiarElemento("contenido");
}

/**
 * Esta funcion lo que hace es limpiar un elemento del DOM.
 * @param {string} AIdElemento - Id del elemento en el DOM.
 * @name LimpiarElemento
 */
function limpiarElemento(AIdElemento){
 document.getElementById(AIdElemento).innerHTML = null;
}