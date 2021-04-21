Para la creacion de nuestro login simplemente hay que llamar el archivo [Formulario Login](http://127.0.0.1:5500/docs/global.html#FormulariodeLogin) en nuestro login.html con la siguiente linea de codigo:

```html
<script src="./login.js" type="module"></script>
```
De esta manera podemos mandar a llamar a nuestro archivo que contiene la la logica de nuestro login para poder verificar el ingreso del login. Esta linea de codigo se ingresaria en nuestro login. De esta manera estariamos creando el Login, en caso de cambios verificar que no se repitan funciones.

Nuestro archivo HTML de login quedaria de la siguiente manera:

```html
<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">

 <link rel="stylesheet" href="publico/css/hojaCSS.css">
 <script src="https://kit.fontawesome.com/bf7a28b890.js" crossorigin="anonymous"></script>

 <title>Nombre del Proyecto</title>
</head>
<body>
 <header class="encabezado">
   <img src="publico/img/Logo.png" alt="Empresa">
   <h2 class="titulo-empresa">Titulo de la empresa</h2>
   <img src="publico/img/Logo.png" alt="Empresa"> 
  </header>
  <div class="login">
   <form name="edita" id="login" method="POST" autocomplete="off">
    <div class="login-container">
      <div class="campos">
       <div>
        <input class="login-input" id="login-usuario" placeholder="Usuario" type="text" name="usuario" size="10" maxength="15" required>
       </div>
       <div>
        <input class="login-input" id="login-password" placeholder="Contraseña" type="password" name="password" size="10" maxength="15" required>
       </div>
      </div>
      <div class="boton">
       <input class="ingresar" type="submit" name="boton" value="Ingresar">
      </div>
      <p class="mensaje-error" id="error"></p>
    </div>
   </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="funciones/login.js" type="module"></script>
</body>
</html>
```

Ahora para los estilos de este login utilizamos la paqueteria de css y bootstrap 5. [Aqui](http://www.google.com) podras encontrar toda la informacion relacionada con estos dos consumibles.