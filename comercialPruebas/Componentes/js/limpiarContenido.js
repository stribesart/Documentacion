export function limpiarContenido(){
 limpiarElemento("titulos");
 limpiarElemento("filtros");
 limpiarElemento("contenido");
}

function limpiarElemento(AIdElemento){
 document.getElementById(AIdElemento).innerHTML = null;
}