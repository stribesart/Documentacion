Para la organizacion de nuestro proyecto se debe cumplir lo siguiente. 

La carpeta principal se debe llamar igual que el proyecto esto con el fin de que nuestro proyecto sea fácil de identificar.

Dentro de la carpeta principal se encontra una sola carpeta llamada **publico** al igual que el archivo principal que va a contener toda nuestra estructura **HTML** el cual sera llamado **index.html**. 

Para la creacion de dicho documento lo que podemos hacer es crear la estructura basica, como utilizaremos Visual Studio Code solo podemos poner el simbolo **!** y presionamos la tecla **tab** o **tabulador** y tendremos una estructura como la siguiente:

```html
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  
</body>
</html>
```

Posteriormente hay que identificar bien la **cabecera** y el **cuerpo** los cuales se llaman **head** y **body** respectivamente. Dentro de la cabecera debemos insertar el [link]() del cdn de bootstrap (framework que utilizamos para estilos), debemos insertar el [link]() del FontAwesomey posteriormente nuestros estilos propios que se encontraran en la carpeta CSS [ver estilos](https://stribesart.github.io/Documentacion/tutorial-estilos.html). Ahora en nuestro body debemos insertar un div "principal", este div servira para construir dentro de el nuestra pagina, ademas debemos insertar el [script]() de Bootstrap, el [script]() del Alertify, el [script]() de Axios y tendremos una seccion para nuestros scripts personalizados. Nuestro **index.html** quedaria de la siguiente manera:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">

    <!-- Estilos Personalizados -->
    <link rel="stylesheet" href="publico/css/estilos.css">

    <title>Nombre del Proyecto</title>

</head>
<body>

    <div class="principal" id="principal"></div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

    <!-- Alertify -->
    <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    
    <!-- Scripts Personalizados -->
    <script type="module" src="publico/js/script.js"></script>

</body>
</html>
```

Dentro de nuestra carpeta **publico** se encontraran las carpetas relacionadas con la aplicacion, estas serian las carpetas *js, css, img/imagenes, etc*.

Dentro de nuestra carpeta **js** deben de ir **todos** los archivos **.js**. Esta carpeta se organizará de la siguiente manera: en la raíz de la carpeta se encontrarán todos los archivos *.js*, las funciones de componentes dentro de su propia carpeta llamada **componentes**, se creará una carpeta llamada **funciones** en la cual se guardaran todas las funciones relacionadas al framework, se creará una carpeta exclusiva para los módulos del proyecto llamada **aplicación**.

Dentro de la carpeta **aplicacion** en la raíz de dicha carpeta se encontrarán todas las funciones relacionadas con la aplicación, también se debe crear una carpeta por cada módulo que se cree y cada uno tendrá de raíz dos archivos llamados **módulo.js** y **filtrosModulo.js**.

De esta manera quedaria ordenado nuestro proyecto, cabe recalcar que es importante e incluso necesario verificar que se cumpla al pie de la letra todo el proceso de creacion. A continuacion se encuentra graficamente el ordenamiento de las carpetas y archivos descritos anteriormente:

![OrgProyecto](https://github.com/stribesart/Documentacion/blob/main/imagenes/OrganizacionArchivos/index.jpeg?raw=true)

## Cambios

index.js se cambia a publico/js/index.js
ahora si todos los js van a estar en la carpeta de js

Creamos nuestro archivo html con su estructura basica
Insertamos el link de la hoja de estilos en la cabecera
Insertamos el script en el body que referencia a nuesto index.js

Insertar en la cabecera el link a bootstrap que se encuentra en (referencia a bootstrap).
Insertar en el body del html el script a bootstrap que se encuentra en (referencia a bootstrap).

Se va a crear una carpeta php donde se guarde la sesion de la pagina web

Hay que cargar el fontawesome (refeerencia a fontawesom)
Hay que cargar el alertify (notificaciones)

si se va a usar codigo html dentro de un archivo js se debe crear una funcion dentro del archivo js que contenga solo el codigo html y regresar la funcion, esto con el fin de que no se vea tan saturado el proyecto

todas las clases se van a llamar como la funcion principal y se van a separar los niveles por un guion medio 

guion medio significa que es un elemento que depende de
guion bajo  significa que es una accion de algo

Una variable sera declarada siempre y cuando se modifique la inrformacion de dicha variable, es decir, si se manipulara informacion extra, en caso de que simplemente se regrese dicha variable sin tratar la informacion es sufucuente con que se retorne con comillas invertidas.