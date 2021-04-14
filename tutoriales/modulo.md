Bienvenido, en este tutorial crearemos un modulo dentro de nuestra pagina principal de Prada Mx.<br>
Asi es como luce nuestra pagina actual: <br>
![Vista General de nuestra pagina de PradaMx](/imagenes/paginaPrada.png)

### Pasos a seguir
##### Paso 1: Definir el nombre de nuestro modulo
Para nuestro primer paso en la creacion de nuestro modulo necesitamos definir el nombre del mismo a crear en este caso se nos pide llamarlo **Uniformes**.<br>
Se necesita navegar en el proyecto **comercialPruebas** hasta encontrar el archivo llamado **Menu.html** el cual tiene una estructura como la siguiente.<br>
```html
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRADA Comercial</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light" id="menu-principal"></nav>
    <main class="container"></main>
    <footer></footer>
  </body>
</html>
```
Dentro de esta estructura tenemos que navegar hasta llegar a la etiqueta **nav** que es la que contiene los botones de nuestra pagina mostrada anteriormente.<br>
Dentro de nuestra etiqueta **nav** encontraremos una estructura como la siguiente: 
```html
<nav class="navbar navbar-expand-lg navbar-light" id="menu-principal">
  <div class="container-fluid"> 
    <img class="navbar-logo" src="publico/img/Logo.png" alt="PRADA">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse menu" id="navbarSupportedContent">
      <ul class="navbar-nav  mb-2 mb-lg-0">
        <button type="button" class="btn btn-primary" data-modulo="Ponderados">Ponderado</button>
        <button type="button" class="btn btn-primary" data-modulo="resumenIndicadores">Resumen Indicadores</button>
        <button type="button" class="btn btn-primary" data-modulo="Promociones">Promociones</button>
        <button type="button" class="btn btn-primary" data-modulo="comportamientoOrkestra">Comportamiento Orkestra</button>
        <button type="button" class="btn btn-primary">Formatos</button>
        <button type="button" class="btn btn-primary" data-modulo="MasVendidos">Mas Vendidos</button>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="nombre-usuario" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          </a>
          <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
            <li><a id="cerrar-sesion" class="dropdown-item">Cerrar Sesion</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
```
En esta parte de nuestro codigo vamos a crear un nuevo boton que nos va a referenciar a nuestro nuevo modulo, para esto necesitamos editar nuestro codigo de la siguiente manera.<br>
Si vemos nuestro codigo tenemos nuestro **nav class="navbar ..." id="menu-Principal"**, **div class="container-fluid">** buscamos **div class="collapse ..." id="navbarSupportedContent">**, **ul class="navbar-nav mb-2 mb-lg-0">** y  nos ubicamos en el ultimo elemento que se llama **Mas Vendidos** e insertamos el siguiente codigo antes de **/ul>** editando la parte del data-modulo y el contenido del **button**.<br>
```html
<button type="button" class="btn btn-primary" data-modulo="Uniformes">Uniformes</button>
```
Quedando de a siguiente manera:<br>
```html
<nav class="navbar navbar-expand-lg navbar-light" id="menu-principal">
  <div class="container-fluid"> 
    <img class="navbar-logo" src="publico/img/Logo.png" alt="PRADA">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse menu" id="navbarSupportedContent">
      <ul class="navbar-nav  mb-2 mb-lg-0">
        <button type="button" class="btn btn-primary" data-modulo="Ponderados">Ponderado</button>
        <button type="button" class="btn btn-primary" data-modulo="resumenIndicadores">Resumen Indicadores</button>
        <button type="button" class="btn btn-primary" data-modulo="Promociones">Promociones</button>
        <button type="button" class="btn btn-primary" data-modulo="comportamientoOrkestra">Comportamiento Orkestra</button>
        <button type="button" class="btn btn-primary">Formatos</button>
        <button type="button" class="btn btn-primary" data-modulo="MasVendidos">Mas Vendidos</button>
        <button type="button" class="btn btn-primary" data-modulo="Uniformes">Uniformes</button>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="nombre-usuario" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
          <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
            <li><a id="cerrar-sesion" class="dropdown-item">Cerrar Sesion</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
```
Nuestra pagina quedaria de la siguiente manera:
![Vista General de nuestra pagina de PradaMx con Boton de Uniformes](/imagenes/paginaPradaUniformes.png)

##### Paso 2: Construir los elementos de Uniformes
Una vez creado el nuevo boton se tendra que crear una carpeta dentro de la carpeta **publico** dentro de la carpeta **js** nombrada de la misma manera que el boton, en este caso crearemos nuestra carpeta **Uniformes**. <br>
Una vez creada la carpeta podemos comenzar el desarrollo de nuestra pagina.<br>
Crearemos un nuevo documento llamandolo **Uniformes.js** y un archivo llamado **FiltrosUniformes.js**.<br>
![Vista de nuestros archivos creados en Uniformes](/imagenes/archivosCreadosEnUniformes.png)
Al inicio de nuestro archivo **Uniformes.js** crearemos la funcion que nos exportara nuestra pagina ya construida, de la siguiente manera:<br>
```javascript
export default async function Uniformes() {}
```
Ahora ya tenemos un modulo creado dentro de nuestra pagina. Para esto necesitamos saber que nuestra pagina principal se compone de sus filtros y su contenido, entonces comenzaremos con los filtros.<br>

### Filtros
En nuestro documento creado llamado **FiltrosUniformes.js** debemos generar una funcion con la siguiente estructura.<br>
```javascript
export async function FiltrosUniformes(cbChange) {}
```
