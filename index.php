<?php

/* Inicio de sesion si esta no esta iniciada */
if (!isset($_SESSION)) {
  session_start();
}

/*
* En caso de que un usuario este logueado, se le redirija a la pagina que le
* corresponde dependiendo el rol que tenga.
* Negando asi el acceso a la pagina de inicio de sesión sin haber cerrado
* esta.
*/
if(isset($_SESSION['user'])){ /* Si un usuario ha iniciado sesion */

  /*
  * Tengo que mirar el tipo de usuario que ha iniciado sesion, para asi
  * redirigirle a la pagina adecuada.
  */
  if($_SESSION['tipo'] == '0'){ /* Usuario administrador */

    header("Location: paginaAdministrador.php");

  }else{ /* Usuario normal */

    header("Location: indexUser.php");

  }

  /*
  * La ejecución debe morir, ya que header no mata la ejecución del programa,
  * cambia de pagina, pero se sigue la linea de ejecución hasta el final.
  */
  die();

}


?>

<!-- *********************************************************************** -->
<!-- *                                                                     * -->
<!-- *                                                                     * -->
<!-- *                                                                     * -->
<!-- *                           COMIENZO HTML                             * -->
<!-- *                                                                     * -->
<!-- *                                                                     * -->
<!-- *                                                                     * -->
<!-- *********************************************************************** -->

<!DOCTYPE html>
<html lang="es">

<!-- *********************************************************************** -->
<!-- *                                                                     * -->
<!-- *                                                                     * -->
<!-- *                                                                     * -->
<!-- *                          COMIENZO HEAD                              * -->
<!-- *                                                                     * -->
<!-- *                                                                     * -->
<!-- *                                                                     * -->
<!-- *********************************************************************** -->

<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>Crea tus cuentos</title>

  <!-- CSS  -->
  <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>

  <!-- SCRIPTS -->
  <script type="text/javascript" src="js/script.js"></script>
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>


</head>

<!-- *********************************************************************** -->
<!-- *                                                                     * -->
<!-- *                                                                     * -->
<!-- *                                                                     * -->
<!-- *                              FIN HEAD                               * -->
<!-- *                                                                     * -->
<!-- *                                                                     * -->
<!-- *                                                                     * -->
<!-- *********************************************************************** -->


<!-- *********************************************************************** -->
<!-- *                                                                     * -->
<!-- *                                                                     * -->
<!-- *                                                                     * -->
<!-- *                            COMIENZO BODY                            * -->
<!-- *                                                                     * -->
<!-- *                                                                     * -->
<!-- *                                                                     * -->
<!-- *********************************************************************** -->

<body>


<!-- *********************************************************************** -->
<!-- *                                                                     * -->
<!-- *                             NAV-BAR                                 * -->
<!-- *                                                                     * -->
<!-- *********************************************************************** -->

<header>

  <div class="navbar-fixed">
  <nav class="teal" role="navigation">
    <div class="nav-wrapper container">

      <ul class="right hide-on-med-and-down">
        <li class="active" ><a href="#">Inicio sesión</a></li>
        <li><a href="nosotros.php">Nosotros</a></li>
      </ul>


      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
  </nav>
</div>
<ul id="nav-mobile" class="right side-nav">
  <li class="active" ><a href="#">Inicio sesión</a></li>
  <li><a href="nosotros.php">Nosotros</a></li>
</ul>
</header>

 <main >

   <br>

   <h4 class="center teal-text">Empieza a crear cuentos.</h4>



   <!-- Tarjeta del formulario -->

   <div class="container">


     <div class="row">
       <div class="col s12 m12 l8 offset-l2">
         <div class="card grey lighten-4">
           <div class="card-content black-text">
               <h5 class="center teal-text">Inicio sesión</h5>

             <div class="row">

               <?php mostrarError(); ?>

               <form class="col s12" name="myForm" action="inicioSesion.php"
               onsubmit="return validateInicioSesion()" accept-charset="utf-8" method="POST"
               enctype="multipart/form-data">

               <div class="row">
                 <div class="input-field col s12">
                   <i class="material-icons prefix">account_circle</i>
                   <input class = 'estiloso' type="text" name="nombre_usuario" class="validate">
                   <label for="">Nombre usuario</label>
                 </div>
               </div>
               <div class="row">
                 <div class="input-field col s12">
                   <i class="material-icons prefix">lock</i>
                   <input class = 'estiloso' type="password" name="pass" class="validate">
                   <label for="">Contraseña</label>
                 </div>
               </div>

               <div class="center">
                 <button class="btn  waves-effect waves-light" type="submit" name="action">Iniciar sesión
                   <i class="material-icons right">send</i>
                 </button>
               </div>

             </form>
           </div>



         </div>
       </div>
     </div>
   </div>
 </div>

 </main>





<!-- *********************************************************************** -->
<!-- *                                                                     * -->
<!-- *                                                                     * -->
<!-- *                              FOOTER                                 * -->
<!-- *                                                                     * -->
<!-- *                                                                     * -->
<!-- *********************************************************************** -->

<footer class="page-footer teal">

  <div class="container">
    <div class="row">
      <div class="col l6 s12">
        <h5 class="white-text">Universidad de León</h5>
        <p class="grey-text text-lighten-4">Pagina web desarrollada por la ULE empleando Materialize.</p>


      </div>

      <div class="col l4 offset-l2 s12">
        <h5 class="white-text">Repositorios empleados</h5>
        <ul>
          <li><a class="white-text" href="#!">ARASAAC</a></li>

        </ul>
      </div>
    </div>
  </div>

  <div class="footer-copyright">
    <div class="container">
      Realizada por <a class="brown-text text-lighten-3" target="blank" href="https://www.linkedin.com/in/jesús-garc%C3%ADa-potes-77ab2012b?trk=hp-identity-name">Jesús García Potes</a>
    </div>
  </div>
</footer>

<!--  Scripts-->



<script src="js/index.js"></script>

</body>

<!-- *********************************************************************** -->
<!-- *                                                                     * -->
<!-- *                                                                     * -->
<!-- *                                                                     * -->
<!-- *                              FIN BODY                               * -->
<!-- *                                                                     * -->
<!-- *                                                                     * -->
<!-- *                                                                     * -->
<!-- *********************************************************************** -->

</html>



<?php

/*
* Funcion empleada para mostrar el error
*/
function mostrarError(){



  /* Si esta variable existe, es que se ha producido un error */
  if(isset($_SESSION['error'])){

    /* Muestro el error */
    echo "<br><p class = \"center red-text\" >" . $_SESSION['error'] . "</p><br>";

    /* Elimino la variable para no volver a entrar a este error. */
    unset($_SESSION['error']);

  }
}

?>
 
