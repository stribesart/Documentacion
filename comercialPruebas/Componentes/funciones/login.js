import { ajax_post } from "./ajax_post.js";
/**
 * Variable que nos obtiene un elemento del DOM llamado login. Se le asigna un evento para que cuando se
 * presione un elemento submit se envie el formulario a un {@link ajax_post} como json para que valide
 * si el usuario que va a ingresar es valido y posteriormente ingresa o redirecciona.
 * @name FormularioLogin
 */
const loginForm = document.getElementById("login");

loginForm.addEventListener("submit", async (e) => {
 e.preventDefault();
 const usuario = document.getElementById("login-usuario").value;
 const password = document.getElementById("login-password").value;

 const data = new FormData();

 data.append("usuario", usuario);
 data.append("password", password);

 await ajax_post({
  url : "http://oficinas.prada.mx:72/comercialPruebas/php/ingreso.php",
  params: data,
  cbSuccess: async (json) =>{
   if(json.hasOwnProperty("error")){
    document.getElementById("error").innerText = json.error;
   }else{
    sessionStorage.setItem("claveUsuario", json.perfil["claveUsuario"]);
    sessionStorage.setItem("idUsuario", json.perfil["idUsuario"]);
    sessionStorage.setItem("nombreUsuario", json.perfil["nombreUsuario"]);
    sessionStorage.setItem("tipoUsuario", json.perfil["tipoUsuario"]);
    sessionStorage.setItem("idPonderado", json.perfil["idPonderado"]);

    window.location = "http://oficinas.prada.mx:72/comercialPruebas/Menu.html";
   }
  }
 });
});