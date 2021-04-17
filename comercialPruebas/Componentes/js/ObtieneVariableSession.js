/**
 * Funcion que Obtiene el valor de una variable en el Session Storage.
 * @param {string} ANombreVariable - Nombre de la variable de donde se sacara el valor
 * @returns {DOMString}
 * @example
 * ObtieneVariableSession("idUsuario");
 */
export function ObtieneVariableSession(ANombreVariable){
 return sessionStorage.getItem(ANombreVariable);
}