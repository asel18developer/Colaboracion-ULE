<?php

define ('ERROR_CONSULTA_DB', 'Error al ejecutar la consulta.');

global $conection;

/* Incluyo el php que tiene la funcion para conectarse con la base de datos */
Include('conectorBase.php');

/* Inicio de sesion si esta no esta iniciada */
if (!isset($_SESSION)) {
  session_start();
}

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
}else if ($_SESSION['tipo'] != 0){

    header('Location: index.php');
    die();

}



/* Establezco conexion con la base de datos */
$conection = establecerConexionDB();


/* Recojo el usuario seleccionado */
$nombreUsuario = $_GET['nombreUsuario'];

/* Creacion de la sentencia para introducir el nuevo producto */
$sentence = "SELECT * FROM Usuarios WHERE nombre_usuario = \"".$nombreUsuario."\"";

/* Ejecucion de la sentencia anterior */
$queryUsuario = mysqli_query($conection, $sentence) or die(ERROR_CONSULTA_DB);

/*Mientras que tengamos una fila mas de la tabla consultar*/
while($usuario = mysqli_fetch_array($queryUsuario)){

  $pass = $usuario['pass'];
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


  <!-- Menu -->
  <header>


    <!-- Dropdown -->
    <ul id="gestion_usuarios" class="dropdown-content">
      <li><a href="paginaAdministrador.php">Registrar usuarios</a></li>
      <li><a href="paginaEliminarUsuarios.php">Eliminar usuarios</a></li>
      <li><a href="paginaSeleccionUsuarios.php">Modificar usuarios</a></li>
    </ul>
    <ul id="gestion_imagenes" class="dropdown-content">
      <li><a href="paginaSubirImagen.php">Subir imagenes</a></li>
      <li><a href="paginaEliminarImagen.php">Eliminar imagenes</a></li>
      <li><a href="paginaModificarImagen.php">Modificar imagenes</a></li>
    </ul>

  <div class="navbar-fixed">
  <nav class="teal" role="navigation">
    <div class="nav-wrapper container">


      <ul class="right hide-on-med-and-down">

        <!-- Dropdown Trigger -->
        <li class="active"><a class="dropdown-button" href="#" data-activates="gestion_usuarios">Gestión usuarios<i class="material-icons right">arrow_drop_down</i></a></li>
        <li><a class="dropdown-button" href="#" data-activates="gestion_imagenes">Gestión imagenes<i class="material-icons right">arrow_drop_down</i></a></li>
        <li><a href="cerrarSesion.php">Cerrar sesion</a></li>



      </ul>


      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>

      </div>

  </nav>
  </div>

  <ul id="nav-mobile" class="side-nav">
    <ul class="collapsible collapsible-accordion">
      <li>
        <a class="collapsible-header waves-effect waves-teal">Gestión usuarios</i></a>
        <div class="collapsible-body">
          <ul>
            <li><a href="paginaAdministrador.php">Registrar usuarios</a></li>
            <li><a href="paginaEliminarUsuarios.php">Eliminar usuarios</a></li>
            <li><a href="paginaSeleccionUsuarios.php">Modificar usuarios</a></li>
          </ul>
        </div>
      </li>
    </ul>

    <ul class="collapsible collapsible-accordion">
      <li>
        <a class="collapsible-header waves-effect waves-teal">Gestión imagenes</i></a>
        <div class="collapsible-body">
          <ul>
            <li><a href="paginaSubirImagen.php">Subir imagenes</a></li>
            <li><a href="paginaEliminarImagen.php">Eliminar imagenes</a></li>
            <li><a href="paginaModificarImagen.php">Modificar imagenes</a></li>
          </ul>
        </div>
      </li>
    </ul>

    <li><a href="cerrarSesion.php">Cerrar sesion</a></li>
  </ul>
  </header>

  <!-- *********************************************************************** -->
  <!-- *********************************************************************** -->
  <!--********************* DIVISION CONTENIDO PRINCIPAL ********************* -->
  <!-- *********************************************************************** -->
  <!-- *********************************************************************** -->
  <main>
  <br>
  <div id="modal1" class="modal modal-fixed-footer">
      <h4 style="padding:2%;">Seleccione la imagen</h4>
  <div class="modal-content">
      <div class="container imagesContainerModal" >

        <div class="row">
      <div class="col s12 cards-container" id = "imagesModal">

    <script type="text/javascript">
      addRepo("Repositorio", <?php echo "\"$nombreUsuario\""; ?>);
    </script>
      </div>
        </div>
        </div>

  </div>
    <div class="modal-footer">
      <div class="row">
        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">cerrar</a>

      </div>

    </div>
  </div>

  <div id="modal2" class="modal modal-fixed-footer">
      <h4 style="padding:2%;">Seleccione la imagen</h4>
  <div class="modal-content">
      <div class="container imagesContainerModal" >

        <div class="row">
      <div class="col s12 cards-container" id = "imagesModalDelete">

        <script type="text/javascript">
          deleteRepo("Repositorio", <?php echo "\"$nombreUsuario\""; ?>);
        </script>

      </div>
        </div>
        </div>

  </div>
    <div class="modal-footer">
      <div class="row">
        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">cerrar</a>

      </div>

    </div>
  </div>
  <div class="container">



    <div class="row">
      <!-- s tamaño para mobiles m tamaño para tablets y l para ordenadores
      en ordenadores el tamaño es menor -->
      <div class="col s12 m12 l8 offset-l2">
        <div class="card grey lighten-4">
          <div class="card-content black-text">
            <b><span class="card-title teal-text">Nombre de usuario: <?php echo($nombreUsuario);?></span></b>
            <?php mostrarError() ?>
            <div class="row">

              <form  autocomplete="off" class="col s12" name="myForm" action="registroUsuario.php?nombreUsuario=<?php echo($nombreUsuario);?>"
              onsubmit="return validateModificarUsuario()" accept-charset="utf-8" method="POST"
              enctype="multipart/form-data">

              <div class="row">
                <div class="input-field col s12">
                  <i class="material-icons prefix">account_circle</i>
                  <input   value="<?php echo($nombreUsuario);?>" autocomplete="off"  value = "" class = 'estiloso' type="text" name="nombre_usuario_update" class="validate">
                  <label for="">Nombre usuario</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <i class="material-icons prefix">lock</i>
                  <input value="" autocomplete="off" value = "" class = 'estiloso' type="password" name="pass"
                  >
                  <label for="contrasena">Contraseña</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <i class="material-icons prefix">perm_identity</i>
                  <input class = 'estiloso' type="text" name="nombre" class="validate"
                  value="<?php echo($nombre);?>">
                  <label for="contrasena">Nombre</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <i class="material-icons prefix">perm_identity</i>
                  <input class = 'estiloso' type="text" name="apellidos" class="validate"
                  value="<?php echo($apellidos);?>">
                  <label for="contrasena">Apellidos</label>
                </div>
              </div>
              <div class="row">


                <div class="input-field col s12">
                  <i class="material-icons prefix">filter_list</i>
                <select name="tipo_usuario">
                  <option value="0" <?php if ($tipoUsuario==0) {
                    echo("selected");  }?>>Administrador</option>
                  <option value="1"<?php if ($tipoUsuario==1) {
                    echo("selected");  }?>>Usuario generico</option>
                  <option value="2"<?php if ($tipoUsuario==2) {
                    echo("selected");  }?>>Usuario especifico</option>
                </select>
                <label>Tipo usuario</label>
              </div>


            </div>



              <div class="center botonesModificar">

                  <button name="modificar_usuario" class="btnMargin btn waves-effect waves-light" type="submit" name="action">Modificar
                    <i class="material-icons right">send</i>
                  </button>


                <?php
                if ($tipoUsuario==2) {

                  echo("<button
                    class=\"btnMargin btn waves-effect waves-light\" data-target=\"modal1\">Añadir imagenes
                    <i class=\"material-icons right\">add</i> </button>");
                  echo("<button
                    class=\"btnMargin btn waves-effect waves-light\" data-target=\"modal2\">Eliminar imagenes
                    <i class=\"material-icons right\">delete_forever</i> </button>");

                }
                ?>


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
