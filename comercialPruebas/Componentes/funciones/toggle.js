/**
 * Esta funcion se encarga de ocultar un elemento cuando otro sea seleccionado 
 * @param {DOMString} elemento - Parametro que se encarga de pasar el elemento que se va a ocultar 
 */
export function toggle(elemento){
 if(elemento.style.display == "none"){
  elemento.style.display = "block";
 }else{
  elemento.style.display = "none";
 }
}