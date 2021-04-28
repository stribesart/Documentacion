/**
 * Funcion menu, cierra la sesion actual y limpia el contenido del session storage
 */
(()=>{
 const $nombreUsuario = document.getElementById("nombre-usuario");
 const $cerrarSesion = document.getElementById("cerrar-sesion");

 $nombreUsuario.innerText = sessionStorage.getItem("nombreUsuario");

 $cerrarSesion.addEventListener("click", (e) => {
  sessionStorage.clear();
  window.location = "http://oficinas.prada.mx:72/comercialPruebas/";
 });

})();

