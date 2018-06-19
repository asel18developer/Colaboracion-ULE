<?php

/* Inicio de sesion */
session_start();

/* Incluyo el php que tiene la funcion para conectarse con la base de datos */
Include('conectorBase.php');

/*
* En caso de que la variable de sesion del usuario logueado no este inicializada,
* nos retorna al index
*/
if (!isset($_SESSION['user'])){

    header('Location: index.php');
    die();

/*
 * Si el usuario esta logeado hay que revisar que su tipo le permite acceder
 * a esta pagina.
 * Lo hago en else if porque si no hay usuario logeado, este campo tampoco
 * esta lleno, entonces si efectivamente hay usuario logeado reviso su tipo
 */
}else if ($_SESSION['tipo'] == 0){

    header('Location: index.php');
    die();

}



/* Establezco conexion con la base de datos */
$conection = establecerConexionDB();


/* Creacion de la sentencia para introducir el nuevo producto */
$sentence = "SELECT * FROM Usuarios WHERE nombre_usuario = \"".$_SESSION['user']."\"";

/* Ejecucion de la sentencia anterior */
$queryUsuario = mysqli_query($conection, $sentence) or die(ERROR_CONSULTA_DB);

/*Mientras que tengamos una fila mas de la tabla consultar*/
while($usuario = mysqli_fetch_array($queryUsuario)){


  $nombre = $usuario['nombre'];
  $apellidos = $usuario['apellidos'];
  $tipoUsuario = $usuario['tipo'];


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
  <script type=”text/javascript” src=”ckeditor/ckeditor.js”>

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
          <li><a href="indexUser.php">Modificar cuenta</a></li>
          <li class="active"><a href="#">Crear cuentos</a></li>
          <li><a href="cerrarSesion.php">Cerrar sesion</a></li>
          <li><a class="modal-trigger" href="#modal1"><i class="material-icons">help</i></a></li>

        </ul>

        <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
        <a href="#modal1" class="modal-trigger help right"><i class="material-icons">help</i></a>

      </div>
    </nav>
  </div>


          <ul id="nav-mobile" class="right side-nav">
            <li ><a href="indexUser.php">Modificar cuenta</a></li>
            <li class="active teal lighten-2"><a href="#">Crear cuentos</a></li>
            <li><a href="cerrarSesion.php">Cerrar sesion</a></li>
          </ul>
  </header>




    <!-- *********************************************************************** -->
    <!-- *********************************************************************** -->
    <!--********************* DIVISION CONTENIDO PRINCIPAL ********************* -->
    <!-- *********************************************************************** -->
    <!-- *********************************************************************** -->

    <main>

      <!-- Modal Structure -->
      <div id="modal1" class="modal">
        <div class="modal-content">
        <h4>Seleccion serie de cuentos</h4>
        <p>
            Selecciona la serie a partir de la cual quiere crear el cuento.
        </p>                  </div>
        <div class="modal-footer">
          <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">cerrar</a>
        </div>
      </div>

      <br>
    <h4 class="center teal-text">Creación cuentos</h4>
    <div class="container">
    <p>Seleccione el tipo de presntación que desea crear:
      <ul>

        <li>Serie blanca: Cuentos con 1 imagen y 1 pictograma con 1 palabra por diapositiva.</li>
        <li>Serie amarilla: Cuentos con 1 imagen y 2 pictograma con 2 palabra por diapositiva.</li>
        <li>Serie azul: Cuentos con 1 imagen y 3 pictograma con 3 palabra por diapositiva.</li>
        <li>Serie verde: Cuentos con 1 imagen y 4 pictograma con 4 palabra por diapositiva.</li>
        <li>Serie naranja: Cuentos editables con un selector de filas por diapositiva.</li>

      </ul>
      </p>

      <form class="amplio center" name="myForm" action="eliminarImagenes.php"
      accept-charset="utf-8" method="POST" enctype="multipart/form-data">
      <br>

      <div class="container imagesContainer" >
      <div class="row">

      <div class="col s12 cards-container">

        <?php


            mostrarCuentos();

         ?>

        </div>
        </div>

      </div>

    </form>

    </div>
    </main>


    <!-- *********************************************************************** -->
    <!-- *                                                                     * -->
    <!-- *                                                                     * -->
    <!-- *                                                                     * -->
    <!-- *                              FOOTER                                 * -->
    <!-- *                                                                     * -->
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



    <!-- *********************************************************************** -->
    <!-- *                                                                     * -->
    <!-- *                                                                     * -->
    <!-- *                                                                     * -->
    <!-- *                            FUNCIONES PHP                            * -->
    <!-- *                                                                     * -->
    <!-- *                                                                     * -->
    <!-- *                                                                     * -->
    <!-- *********************************************************************** -->

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


    function mostrarCuentos(){


      echo '<a href = "paginaCreacionCuentos.php?serie=serie-blanca"> <div class="serie">
      <img src="./img/serie-blanca.png">
      <span class="caption">Serie blanca</span>
      </div></a>
      ';

      echo '<a href = "paginaCreacionCuentos.php?serie=serie-amarilla"><div class="serie">
      <img src="./img/serie-amarilla.png">
      <span class="caption">Serie amarilla</span>
      </div></a>
      ';

      echo '<a href = "paginaCreacionCuentos.php?serie=serie-azul"><div class="serie">
      <img src="./img/serie-azul.png">
      <span class="caption">Serie azul</span>
      </div></a>
      ';

      echo '<a href = "paginaCreacionCuentos.php?serie=serie-verde"><div class="serie">
      <img src="./img/serie-verde.png">
      <span class="caption">Serie verde</span>
      </div></a>
      ';

      echo '<a href = "paginaCreacionCuentos.php?serie=serie-naranja"><div class="serie">
      <img src="./img/serie-naranja.png">
      <span class="caption">Serie naranja</span>
      </div></a>
      ';

    }

    ?>
