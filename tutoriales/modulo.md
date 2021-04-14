Bienvenido, en este tutorial crearemos un modulo dentro de nuestra pagina principal de Prada Mx.<br>
<br>
Se solicita crear un apartado para la parte de administracion de los Uniformes en la pagina principal de Prada MX, asi es como luce nuestra pagina actual: <br>

![Vista General de nuestra pagina de PradaMx](/imagenes/paginaPrada.png)

Para este apartado se necesita crear un boton en el Menu anterior para poder dirigirnos al modulo de Uniformes, al cual le llamaremos **Uniformes**. Para esto debemos de seguir una serie de pasos que estaran descritas a continuacion.<br>

### Pasos a seguir

##### Paso 1: Definir el nombre de nuestro modulo
Para nuestro primer paso en la creacion de nuestro nuevo modulo necesitamos definir el nombre del mismo a crear en este caso se nos ha pedido llamarlo **Uniformes**.<br>
Para este primer paso necesitamos navegar en el proyecto **comercialPruebas** hasta encontrar el archivo llamado **Menu.html** el cual tiene una estructura comun de un HTML como la siguiente.<br>
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
Si vemos nuestro codigo tenemos nuestro **nav class="navbar ..." id="menu-Principal"**, **div class="container-fluid">** buscamos **div class="collapse ..." id="navbarSupportedContent">**, **ul class="navbar-nav mb-2 mb-lg-0">** y nos ubicamos en el ultimo elemento que se llama **Mas Vendidos** e insertamos el siguiente codigo antes de **/ul>** editando la parte del data-modulo y el contenido del **button**.<br>
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
En esta funcion lo que haremos es gestionar nuestros elementos que se insertaran en el apartado de Uniformes dentro de nuestra pagina web.<br>
Procedemos a Editar el la funcion creada **Uniformes** creando las variables que utilizaremos, en este caso crearemos una variable para el elemento que contendra nuestros filtros de Uniformes llamando a la funcion **GeneraElementoDOM()** y le asignamos un id, esto nos servira para crear todo el contenido del modulo, llamamos a la funcion **ObtieneElementoDOM()** y le añadimos nuestro contenedor, despues llamamos a nuestra funcion **FiltrosUniformes()** y le insertamos la funcion de **CargarDatos**, la cual como dice su nombre, cargara los datos que deberan ir dentro del modulo. Posteriormente retornaremos nuestro contenedor para insertarlo en el DOM, en el modulo de Uniformes de la siguiente manera en codigo:<br>

```javascript
export default async function Uniformes() {
    const $contenedor = GeneraElementoDom("div");
    $contenedor.id = "contenedor";
    ObtieneElementoDom("contenido").appendChild($contenedor);

    await FiltrosUniformes(CargarDatos);

    CargarDatos();

    return $contenedor;
}
```
Hasta ahora lo que hemos creado es una referencia a nuestro contenido de nuestra pagina web y creado el boton que nos dara un espacio para nuestro modulo. Nuestra pagina queda de la siguiente manera:<br>

![Imagen de la pagina creada con su referencia al contenido](/imagenes/referenciaContenido.png)

Ahora ya tenemos un modulo creado con sus referencias a su contenido y sus filtros dentro de nuestra pagina. Ahora comenzaremos con los filtros, los cuales manejaran ciertos eventos que nos mostraran informacion limitada de acuerdo a los que sean seleccionados.<br>

### Filtros
En nuestro documento creado llamado **FiltrosUniformes.js** debemos generar una funcion con la siguiente estructura.<br>
```javascript
export async function FiltrosUniformes(cbChange) {}
```
