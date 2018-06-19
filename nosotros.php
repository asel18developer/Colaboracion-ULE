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

    header("Location: creacionCuentos.php");

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
<!-- *                           COMIENZO HTML1                             * -->
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


  <!-- Menu -->
<header>
  <div class="navbar-fixed">
  <nav class="teal" role="navigation">
    <div class="nav-wrapper container">

      <ul class="right hide-on-med-and-down">
        <li><a href="index.php">Inicio sesión</a></li>
        <li class="active"><a href="#">Nosotros</a></li>
      </ul>


      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
  </nav>
</div>
<ul id="nav-mobile" class="side-nav">
  <li><a href="index.php">Inicio sesión</a></li>
  <li class="active"><a href="#">Nosotros</a></li>
</ul>
</header>

  <!-- *********************************************************************** -->
  <!-- *********************************************************************** -->
  <!--********************* DIVISION CONTENIDO PRINCIPAL ********************* -->
  <!-- *********************************************************************** -->
  <!-- *********************************************************************** -->
  <main>

    <div id="index-banner" class="parallax-container">
      <div class="section no-pad-bot">
        <div class="container">
          <br><br>
          <h1 class="header center black-text text-black">Autismo León</h1>
          <div class="row center">
            <h5 class="header center black-text text-black">Federación Autismo Castilla y León</h5>
          </div>

          <br><br>

        </div>
      </div>
      <div class="parallax"><img src="img/autismo-leon.png" alt=""></div>
    </div>

    <br>

    <br>

    <div class="container">
      <!--   Icon Section   -->
      <div class="row">
        <div class="col s12 m4">
          <div class="icon-block">
            <h5 class="center teal-text">Objetivo</h5>
            <p class="light autismo">Autismo León tiene como fin promover y mejorar la calidad de vida e inclusión social de las personas con TEA y sus familias a lo largo de todo su ciclo vital mediante la prestación de servicios especializados y fundamentados en las mejores prácticas, la defensa efectiva de sus derechos y la sensibilización positiva de la sociedad.</p>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h5 class="center teal-text">Historia</h5>
            <p class="light autismo">Autismo León es una asociación de padres y familiares de personas con trastorno del espectro del autismo cuya misión es mejorar la calidad de vida de las personas con TEA y sus familias a lo largo de todo su ciclo vital.
              Constituida al amparo al amparo de la Ley de Asociaciones 19/1964 de 24 de diciembre, está registrada en el Registro de Asociaciones de la JCyL nº 3261 sección 1ª y en el Registro de entidades, servicios y centros.
              Autismo León es miembro de la Federación Autismo León y de la Confederación Autismo España</p>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h5 class="center teal-text">Visión</h5>
            <p class="light autismo">Autismo León aspira a ser reconocida a nivel nacional como un ente de prestigio en su ámbito, caracterizada por:
              <ul class="light">
                <li>- Prestar servicios especializados que aportan un valor diferencial a las personas con TEA y sus familias.</li>
                <li>- Contar con profesionales expertos que utilizan metodologías contrastadas y eficaces, basadas en buenas prácticas que cuentan a su vez con evidencia científica.</li>
                <li>- Practicar la mejora continua y perseguir la excelencia.</li>
                <li>- Aplicar criterios rigurosos de administración y buen gobierno.</li>
                <li>- Contribuir activamente al desarrollo del movimiento asociativo de los TEA en particular y de la discapacidad en general.</li>

              </ul>
              </p>
          </div>
        </div>
      </div>

    </div>


  </main>





<!-- *********************************************************************** -->
<!-- *********************************************************************** -->
<!--******************* FIN DIVISION CONTENIDO PRINCIPAL ******************* -->
<!-- *********************************************************************** -->
<!-- *********************************************************************** -->
<br>

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
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="js/materialize.js"></script>
<script src="js/init.js"></script>
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
