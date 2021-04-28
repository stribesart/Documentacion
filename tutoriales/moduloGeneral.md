Cuales son los pasos para crear un Modulo en general:

Bienvenido, en este tutorial revisaremos los pasos generales para crear un modulo en general.

Nuestro proyecto se va a manejar por modulos por lo tanto necesitamos saber como es que se van a crear cada uno de ellos.

###### Paso 1
Para el paso 1 se necesita crear un boton que es el que nos va a ayudar a construir lo relacionado con ese modulo.

Por lo tanto es necesario crearlo en nuestra estructura HTML con el siguiente codigo:
```html
<button type="button" class="btn btn-primary" data-modulo="Modulo">Modulo</button>
```

De esta manera ya pudimos crear un boton dentro de nuestro codigo, este componente puede llamarse en cualquier archivo a este punto no sera necesario llamar la ruta ya que tenemos una funcion que llama al modulo que fue seleccionado.

###### Paso 2
En la carpeta **publico** se debe crear una carpeta con el mismo nombre con el que se llama al modulo anterior. Dentro de la carpeta se creara el documento principal de la pagina/modulo a cargar.

###### Paso 3
Conforme se va armando nuesro modulo debemos crear funciones, cada funcion debe pertenecer a un archivo, este archivo se debe de llamar igual que la funcion.

Si nuestra funcion se llama *Funcion* el archivo se llamara *Funcion.js* y en la parte superior del archivo se importaran todas las funciones que utilice est funcion.
```javascript
import {} from ""
Funcion(){}
```

###### Paso 4
Creando Funcion de Filtros
Se creara un fragmento con la funcion ya existente [CrearFragmento](https://stribesart.github.io/Documentacion/global.html#CrearFragmento), esto sirve para ir almacenando o filtros y posterior se inserte en el DOM.

###### Paso 5
Para pasar parametros de la session de la pagina, se utiliza la funcion [ObtieneVariableSession](https://stribesart.github.io/Documentacion/global.html#ObtieneVariableSession).

###### Paso 6
Se realiza el cambios de un fragmento a un div ya que el evento cbChange no se ejecuta en el fragmento ya que el fragmento no se inserta en el dom por lo tanto no detecta el evento.