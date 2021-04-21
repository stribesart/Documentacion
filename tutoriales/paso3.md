SPA(Single Page Application)
Actualmente se requiere realizar nuestros proyectos como SPA, esto es para evitar tener tantos archivos como paginas en nuestro proyecto para esto necesitamos definir bien una barra de navegacion que es la que nos va a ayudar a cargar distinto contenido dentro de nuestra SPA.

Ahora nuestro objetivo principal sera cargar este contenido de manera dinamica.

Para esto en nuestro [index.js](http://127.0.0.1:5500/docs/index.js.html) como podemos ver en el codigo lo primero que tenemos que hacer antes de cargar algo en el contenido sera [limpiar el contenido](http://127.0.0.1:5500/docs/global.html#LimpiarContenido), ya que, sino limpiamos el contenido antes de insertar mas contenido lo que sucedera va a ser que se insertara uno tras de otro.

A continuacion lo que haremos sera crear un primer elemento en nuestra barra de navegacion, para esto en nuestro index.html tenemos que declarar la estructura de nuestra SPA (*vease [Creando el Proyecto](http://127.0.0.1:5500/docs/tutorial-paso1.html)*).

Una vez definido nuestra estructura *HTML* procedemos a crear su respectivo archivo *JS* el cual contendra la logica de nuestro proyecto (*vease [index.js](http://127.0.0.1:5500/docs/index.js.html)*).

Nuestro archivo **index.html** se veria de la siguiente manera:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="publico/css/hojaCSS.css">
    <title>Nombre del Proyecto</title>
    <script src="https://kit.fontawesome.com/bf7a28b890.js" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light" id="menu-principal">
        <div class="container-fluid"> 
            <img class="navbar-logo" src="publico/img/Logo.png" alt="Empresa">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse menu" id="navbarSupportedContent">
                <ul class="navbar-nav"></ul>
            </div>
        </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script src="index.js" type="module"></script>
    </body>
</html>
```
Como vemos solo hemos creado la estructura de nuestra barra de navegacion, este es el formato que se debe llevar para poder crearla, posteriormente se va a llenar de elementos y eventos que seran necesarios segun se requieran, ademas de que necesitamos insertarle elementos a nuestra barra de navegacion (vease [Crear un Modulo]()).

**[Siguiente.](http://127.0.0.1:5500/docs/tutorial-moduloGeneral.html)**