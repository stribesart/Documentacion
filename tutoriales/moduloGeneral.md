Cuales son los pasos para crear un Modulo en general:

Bienvenido, en este tutorial revisaremos los pasos generales para crear un modulo en general.

Comencemos.

###### Paso 1
Al crear el boton en la pagina principal se debera crear un boton con un atributo modulo que referencie al modulo correcto o en cuestion (Uniformes)

###### Paso 2
En la carpeta publico se debe crear una carpeta con el mismo nombre con el que se llama al modulo anterior (Uniformes)
Dentro de la carpeta se creara el documento principal de la pagina/modulo a cargar

###### Paso 3
Las funciones que se usaran se deberan llamar igual a los nombres de los archivos (FiltrosUniformes || FiltrosUniformes(){})

###### Paso 4
Creando Funcion de Filtros
Se creara un fragmento con la funcion ya existente CrearFragmento, esto sirve para ir almacenando o filtros y posterior se inserte en el DOM

###### Paso 5
Para pasar parametros de la session de la pagina, se utiliza la funcion ObtieneVariableSession(){}

en filtros se manda una palabra reservda cbChange

###### Paso 6
Se realiza el cambios de un fragmento a un div ya que el evento cbChange no se ejecuta en el fragmento ya que el fragmento no se inserta en el dom por lo tanto no detecta el evento.