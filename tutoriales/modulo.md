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

##### Paso 3: Construir los Filtros.
### Filtros 
En nuestro documento creado llamado **FiltrosUniformes.js** debemos generar una funcion con la siguiente estructura.<br>
```javascript
export async function FiltrosUniformes(cbChange) {}
```
En esta funcion tenemos que construir cada elemento con el que interactuara nuestro modulo de Uniformes, para esto hay que definir que tipo de filtros tenemos que crear y cual sera la funcionalidad.<br>
Se sabe que nuestro apartado de uniformes debera contener una estructura como la siguiente pantalla: 

![Imagen de prada Productivo Modulo Uniformes](/imagenes/pantallaPradaProductivoUniformes.png)

Entonces comencemos<br><br>
Necesitaremos 4 botones ya que el boton de regresar ya no es necesario en esta pagina, vemos que la tabla que se muestra en el contenido podra filtrarse por sucursal por lo tanto crearemos una lista que nos permita filtrar por dicho parametro. Una vez analizado lo que se nos pide procederemos a la insercion de nuestros **Filtros**.
##### Filtros 3.1
Para la creacion de nuestros filtros como ya sabemos tenemos nuestro archivo **FiltrosUniformes.js** que creamos junto con **Uniformes.js**.<br>
Crearemos una funcion llamada **FiltrosUniformes()** y la exportaremos como default para cargarla y utilizarla en **Uniformes.js**, ya que llenaremos nuestra lista dinamicamente la tendremos que hacer asincrona (vease **[Select](https://stribesart.github.io/Documentacion/global.html#Select)**), ademas le pasaremos un parametro que se tendra que ejecutar cuando le añadamos evento change. Nuestro codigo deberia verse de la siguiente manera:
```javascript
export async function FiltrosUniformes(cbChange) {}
```
###### Lista Sucursales
Dentro de nuestra funcion de filtros utilizaremos la funcion **Select** para crear nuestra lista con el codigo siguiente:
```javascript
export async function FiltrosUniformes(cbChange) {
  const elemento = GeneraElementoDom("div");
  const $filtros = ObtieneElementoDom("filtros");
  const idSucursal = ObtieneVariableSession("idPonderado") === 3 ? ObtieneVariableSession("idPonderado") : "";
  $filtros.innerHTML = null;
  elemento.appendChild(
    await Select({
      nombreTabla: "Sucursal",
      params: {
        campoValue: "suc01",
        campoDescripcion: "suc03",
        idSucursal: idSucursal
      },
      url: ObtieneUrl("php/Uniformes/", "ObtieneSucursalesUniformes.php")
    })
  );
}
```
Como podemos ver se crea una variable la cual [crea un elemento en el DOM](https://stribesart.github.io/Documentacion/global.html#GeneraElementoDOM) (un div), ademas se crea una variable que almacenara un valor del session storage (vease [ObtieneVariableSession](https://stribesart.github.io/Documentacion/global.html#ObtieneVariableSession)), la cual condicionamos a si es 3 que obtenga cierto valor y si no es 3 que lo mande como vacio, creamos una variable que obtenga la parte de los filtros de nuestro modulo Uniformes (vease [ObtieneElementoDOM](https://stribesart.github.io/Documentacion/global.html#ObtieneElementoDom)). Posteriormente cada vez que se entre a uniformes se tendra que limpiar la seccion de los filtros y lo hacemos con un null, despues a nuestro elemento div le añadimos nuestra lista llamando a nuestra funcion Select con sus respectivos parametros (vease **[Select](https://stribesart.github.io/Documentacion/global.html#Select)**), y listo tendremos creada nuestro primer filtro y nuestra pagina se vera de la siguiente manera:

![Imagen de Uniformes con el primer Filtro](/imagenes/UniformesPrimerFiltro.png)

Como podemos ver nuestra lista ya fue creada e incluso ya fue llenada. Procederemos con los botones que necesitamos crear y para esto continuaremos editando nuestro archivo.<br>
###### Botones
Para crear nuestros botones tenemos un componente que ya nos crea nuestros Botones (vease [Button](https://stribesart.github.io/Documentacion/global.html#Button)), este componente lo llamaremos 4 veces ya que necesitamos 4 botones diferentes, nuestro codigo quedaria de la siguiente manera:<br>

```javascript
export async function FiltrosUniformes(cbChange) {
  const elemento = GeneraElementoDom("div");
  const $filtros = ObtieneElementoDom("filtros");
  const idSucursal = ObtieneVariableSession("idPonderado") === 3 ? ObtieneVariableSession("idPonderado") : "";
  $filtros.innerHTML = null;
  elemento.appendChild(await Select({
    nombreTabla: "Sucursal",
    params: {
      campoValue: "suc01",
      campoDescripcion: "suc03",
      idSucursal: idSucursal
    },
    url: ObtieneUrl("php/Uniformes/", "ObtieneSucursalesUniformes.php")
  })
);
  elemento.appendChild(Button("Solicitar","Solicitar","btn-secondary","modulo-uniformes","SolicitarUniformes"));
  elemento.appendChild(Button("Aceptar","Aceptar","btn-secondary","modulo-uniformes","AceptarUniformes"));
  elemento.appendChild(Button("Rechazar","Rechazar","btn-secondary"));
  elemento.appendChild(Button("Formato","Formato","btn-secondary"));
}
```
Nuestra pagina se vera de la siguiente manera:<br>

![Imagen de Uniformes con todos los Filtros](/imagenes/filtrosCompletos.png)

Hasta este punto hemos creado nuestros elementos en el HTML de la parte de nuestros filtros, nos faltaran nuestros eventos pero eso dependera del modulo, lo veremos a continuacion.<br>