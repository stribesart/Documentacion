Para la organizacion de nuestro proyecto se debe cumplir lo siguiente. 

La carpeta principal se debe llamar igual que el proyecto esto con el fin de que nuestro proyecto sea fácil de identificar.

Dentro de la carpeta principal se encontra una sola carpeta llamada **publico** al igual que el archivo principal que va a contener toda nuestra estructura **HTML** el cual sera llamado **index.html**. Creamos nuestro archivo html con su estructura basica, debemos insertar el link de la hoja de estilos en la cabecera, debemos insertar el script en el body que referencia a nuesto index.js. Debemos insertar en la cabecera el link a bootstrap que se encuentra en (referencia a bootstrap). Debemos insertar en el body del html el script a bootstrap que se encuentra en (referencia a bootstrap).

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