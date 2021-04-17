
/**
 * Este tipo de dato identifica un elemento del DOM
 * @typedef {Object} objeto
 */

/**
 * Esta funcion lo que hace es identificar un elemento del DOM y lo regresa como un Objeto.
 * @type {objeto}
 * @param {object} AIdElemento - Id del elemento del DOM.
 * @param {object} AQuery - Clase del elemento del DOM.
 * @returns {objeto}
 * @example
 * ObtieneElementoDom("idElemento");
 */
export function ObtieneElementoDom(AIdElemento, AQuery = false){
 return AQuery
  ? document.getElementsByClassName(AIdElemento) 
  : document.getElementById(AIdElemento);
}