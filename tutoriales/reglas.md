### Descripción
En este manual se define el estándar de programación general para cualquier proyecto que se desarrollara en DCSR, se va a definir como declarar variables, constantes, funciones, clases, etc, al momento de programar. Se dará una breve explicación de que consiste cada elemento y un formato a seguir para cada uno así como una estructura que hay que respetar para la declaración, tanto de funciones, como de clases. Veremos la estructura de archivos que se tendrá que respetar para facilitar la búsqueda de archivos dentro del proyecto.

### Análisis
Nuestro estándar de programación necesitara ciertos criterios que se tendrán que cumplir para poder desarrollar las reglas que se proponen a continuación, para esto hay que definir bien lo que tenemos que saber previamente de cumplir las reglas.
Definiremos el(los) lenguaje(s) de programación a utilizar en este caso el lenguaje de programación a trabajar es JavaScript.
Definiremos una estructura de ordenamiento de carpetas y archivos para la facilitación de acceso a archivos acordes al proyecto.
Seccionaremos los archivos de JavaScript de manera que todo este ordenado para la mayor comprensión del código.
Definiremos distintos estilos de escritura para distintos elementos dentro del lenguaje JavaScript que nos permitirán generalizar el estilo de programación de cada uno de los integrantes del equipo.
Definiremos como vamos a trabajar con las excepciones dentro de los distintos métodos que se irán generando a lo largo del desarrollo de la programación.

### Criterios
Las reglas de nuestro estándar de programación deben ser:
•	Fáciles de recordar
•	Deben ser fáciles de leer y entender rápidamente.
•	El código debe tener consistencia para que el código sea legible.

### Estructura
La estructura que se utilizara para la codificación para EMICOFI (1.0) sirve para evitar redundancias en el estilo de programación individual y crear un estilo general para facilitar el mantenimiento a largo plazo. Es necesario que se lea toda la pagina.

#### Estilo de escritura
Se utilizará el método Camello (CamelCase) para los nombres de las variables y métodos. 
CamelCase es un estilo de escritura que se aplica a frases o palabras compuestas. 
El nombre se debe a que las mayúsculas a lo largo de una palabra en CamelCase se asemejan a las jorobas de un camello. 
El nombre CamelCase se podría traducir como Mayúsculas/Minúsculas Camello. 
 
Existen dos tipos de CamelCase: 
•	UpperCamelCase, cuando la primera letra de cada una de las palabras es mayúscula. Ejemplo: *EjemploDeUpperCamelCase*. 
•	lowerCamelCase, igual que la anterior con la excepción de que la primera letra es minúscula. Ejemplo: *ejemploDeLowerCamelCase*. 
En los nombres se deberán omitir las preposiciones: *a, antes de, dentro de, desde, desde hace, despues de, durante, en, hasta, etc.* 

#### Carpetas
En el caso de las Carpetas deben de usar el tipo de notación lowerCamelCase, es decir, la primera letra de la carpeta debe de iniciar con minúscula.
Ejemplo:

![Imagen de como se deben nombrar las carpertas](https://github.com/stribesart/Documentacion/blob/main/imagenes/ReglasCodificacion/carpetas.png?raw=true)

#### Archivos
En el caso de los Archivos deben de usar el tipo de notación UpperCamelCase, es decir, la primera letra del nombre del archivo tendrá que ser mayúscula.
Ejemplo:

![Imagen de como se deben nombrar los archivos](https://github.com/stribesart/Documentacion/blob/main/imagenes/ReglasCodificacion/archivos.png?raw=true)

#### Funciones
En caso de las funciones deberán ser llamadas igual que el archivo en cuestión. Para las funciones se utilizará la estructura CamelCase y sus parámetros serán llamados por una A mayúscula.
Se deberá respetar tanto para envío de parámetros como de recepción de los mismos.
Ejemplo: 

![Imagen de como se deben nombrar las funciones](https://github.com/stribesart/Documentacion/blob/main/imagenes/ReglasCodificacion/funciones.png?raw=true)

### Constantes y Variables
##### Relacionadas al DOM
Para las constantes o variables se utilizaran diferentes formatos según sea el uso que se le dará, para las variables que se le asignan elementos del DOM deberán empezar con el símbolo de “$”
Ejemplo:

![Imagen de como se deben nombrar las constantes o variables](https://github.com/stribesart/Documentacion/blob/main/imagenes/ReglasCodificacion/vcDOM.png?raw=true)

##### No relacionadas al DOM
Para las variables o constantes que no tienen que ver con los elementos DOM utilizaran la misma notación lowerCamelCase.
Ejemplo:

![Imagen de como se deben nombrar las constantes o variables](https://github.com/stribesart/Documentacion/blob/main/imagenes/ReglasCodificacion/vcNoDOM.png?raw=true)