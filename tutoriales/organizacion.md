<<<<<<< HEAD
Dentro de nuestra organizacion de carpetas se debe tener en cuenta que debe cumplir estrictamente con el siguiente formato.
![Imagen de la organizacon en el index de un proyecto](/imagenes/OrganizacionArchivos/index.png)

Las carpetas deberan nombrarse con un adjetivo que describa lo que se almacenara en dicha carpeta y ademas debemos recordar que se debera nombrar con el tipo de escritura lowerCamelCase.

### Descripcion de las carpetas.

En la carpeta **nombreProyecto** cambiaremos el nombre a como se debe llamar nuestra carpeta, posteriormente dentro de dicha carpeta irá todo nuestro proyecto que vamos a construir.

En la carpeta **js** deberan ir todos nuestros archivos componentes que se iran creando a lo largo del proyecto, estos componentes son todas aquellas funciones que tienen como proposito crear un elemento en el DOM como pueden ser botones, modales, etc, y que ademas tendran codigo que podremos reutilizar en cualquier momento de nuestro proyecto.

Dentro de nuestra carpeta **js** deben ir dos carpetas mas, la carpeta de funciones y la de aplicacion. En la carpeta de **funciones** deben ir todas nuestras funciones javascript que tengan relacion con el framework como ajax_post, post, etc. Dentro de nuestra otra carpeta **aplicacion** iran todas nuestros archivos relacionados con la aplicacion que crearemos al igual que todas las funciones que tengan relacion con los eventos del DOM.

En la carpeta **php** deran ir todos los archivos php.

Es necesario tener en cuenta que si vamos a trabajar con modulos, dentro de nuestra carpeta de aplicacion necesitaremos crear una carpeta por modulo, al igual que en php.
=======
Para la organizacion de nuestro proyecto se debe cumplir lo siguiente. 

La carpeta principal se debe llamar igual que el proyecto esto con el fin de que nuestro proyecto sea fácil de identificar.

Dentro de la carpeta principal se encontrarán 3 carpetas: los **archivos .js**, la carpeta **publico** y los **PHP** al igual que los archivos principales que seran llamados **index.js** e **index.html**.

Dentro de nuestra carpeta **js** deben de ir todos los archivos **.js** (a excepción del index.js). Esta carpeta se organizará de la siguiente manera: en la raíz de la carpeta se encontrarán todos los componentes, se creará una carpeta llamada **funciones**, se creará una carpeta exclusiva para los módulos del proyecto llamada **aplicación**.

Dentro de la carpeta **funciones** se almacenaran archivos .js que contengan funciones referentes al framework.

Dentro de la carpeta **aplicacion** en la raíz de dicha carpeta se encontrarán todas las funciones relacionadas con la aplicación, también se debe crear una carpeta por cada módulo que se cree y cada uno tendrá de raíz dos archivos llamados **módulo.js** y **filtrosModulo.js**.

Dentro de nuestra carpeta **publico** deben de ir todos nuestros archivos que, valga la redundancia, se consumirán en el proyecto, ejemplo de estos son: imágenes, CSS, servicios de SMTP, etc.

Dentro de la carpeta **php** se debe crear una estructura similar a la de **aplicación** ya que se deben crear en la raíz una carpeta por cada modulo que va a consumir dichos archivos.


![OrgProyecto](/imagenes/OrganizacionArchivos/index.jpeg)
>>>>>>> 2431a32fc8dac5e2dbb1f9a9970e8e62946098f2
