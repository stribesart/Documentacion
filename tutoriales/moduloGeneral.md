Cuales son los pasos para crear un Modulo en general:

Bienvenido, en este tutorial revisaremos los pasos generales para crear un modulo en general.

Nuestro proyecto se va a manejar por modulos por lo tanto necesitamos saber como es que se van a crear cada uno de ellos.

###### Paso 1
Para el paso 1 se necesita crear un boton que es el que nos va a ayudar a construir lo relacionado con ese modulo.

Por lo tanto necesitamos crearlo con el componente [Boton](https://stribesart.github.io/Documentacion/global.html#Button), con este componente podemos llamarlo con el siguiente codigo 
```javascript
import { Button } from "./Componentes/Button.js";

Button("Solicitar","Solicitar","btn-secondary","modulo-uniformes","SolicitarUniformes");
```
De esta manera ya pudimos crear un boton dentro de nuestro codigo, este componente puede llamarse en cualquier archivo, simplemente hay que verificar bien la ruta de donde lo vamos a llamar.

###### Paso 2
En la carpeta publico se debe crear una carpeta con el mismo nombre con el que se llama al modulo anterior. Dentro de la carpeta se creara el documento principal de la pagina/modulo a cargar

###### Paso 3
Las funciones que se usaran se deberan llamar igual a los nombres de los archivos

###### Paso 4
Creando Funcion de Filtros
Se creara un fragmento con la funcion ya existente CrearFragmento, esto sirve para ir almacenando o filtros y posterior se inserte en el DOM

###### Paso 5
Para pasar parametros de la session de la pagina, se utiliza la funcion ObtieneVariableSession(){}

en filtros se manda una palabra reservda cbChange

###### Paso 6
Se realiza el cambios de un fragmento a un div ya que el evento cbChange no se ejecuta en el fragmento ya que el fragmento no se inserta en el dom por lo tanto no detecta el evento.