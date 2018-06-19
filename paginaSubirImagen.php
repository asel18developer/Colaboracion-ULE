<?php

/* Inicio de sesion */
session_start();

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


/* Incluyo el php que tiene la funcion para conectarse con la base de datos */
Include('conectorBase.php');

$directory='Repositorio';

/* Establezco conexion con la base de datos */
$conection = establecerConexionDB();

/* Obtengo el directorio actual */
$directory='Repositorio';

if(isset($_GET['directorio'])){

  $directory=$_GET['directorio'];

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

    <!-- Dropdown -->
    <ul id="gestion_usuarios" class="dropdown-content">
      <li><a href="paginaAdministrador.php">Registrar usuarios</a></li>
      <li><a href="paginaEliminarUsuarios.php">Eliminar usuarios</a></li>
      <li><a href="paginaSeleccionUsuarios.php">Modificar usuarios</a></li>
    </ul>
    <ul id="gestion_imagenes" class="dropdown-content">
      <li class="active"><a href="#">Subir imagenes</a></li>
      <li><a href="paginaEliminarImagen.php">Eliminar imagenes</a></li>
      <li><a href="paginaModificarImagen.php">Modificar imagenes</a></li>
    </ul>

  <div class="navbar-fixed">
  <nav class="teal" role="navigation">
    <div class="nav-wrapper container">


      <ul class="right hide-on-med-and-down">

        <!-- Dropdown Trigger -->
        <li><a class="dropdown-button" href="#" data-activates="gestion_usuarios">Gestión usuarios<i class="material-icons right">arrow_drop_down</i></a></li>
        <li class="active"><a class="dropdown-button" href="#" data-activates="gestion_imagenes">Gestión imagenes<i class="material-icons right">arrow_drop_down</i></a></li>
        <li><a href="cerrarSesion.php">Cerrar sesion</a></li>
        <li><a class="modal-trigger" href="#modal1"><i class="material-icons">help</i></a></li>


      </ul>


      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
      <a href="#modal1" class="modal-trigger help right"><i class="material-icons">help</i></a>

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
            <li class="active teal lighten-2"><a href="#">Subir imagenes</a></li>
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



    <h4 class="center teal-text">Subir imagenes.</h4>
    <div class="container">

                <!-- Modal Structure -->
                <div id="modal1" class="modal">
                  <div class="modal-content">
                  <h4>Ayuda subir imagen</h4>
                  <p>

                    <ul>
                      <li>Se subiran las imagenes en el directorio actual.</li>
                      <li>Se crearan las carpetas en el directorio actual.</li>
                      <li>Para navegar por los diferentes directorios de imagenes,
                      se ha de pinchar sobre estas.</li>
                      <li>La flecha permite retroceder a la carpeta anterior.</li>
                      <li>La casa permite volver a la primera carpeta.</li>
                      <li>Al subir una imagen se ajustara a una resolución de 500x500 pixeles.</li>
                    </ul>
                  </p>                  </div>
                  <div class="modal-footer">
                    <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">cerrar</a>
                  </div>
                </div>


      <?php   mostrarIconosCasaReturn(); ?>
      <br>
      <form class="" action="index.html" method="post">
        <!-- <div class="input-field">
          <input id="search" type="search">
          <label for="search"><i class="material-icons">search</i></label>
          <i class="material-icons">close</i>
        </div> -->
      </form>
      <div class="container imagesContainerAdd" >
      <div class="row">

      <div class="col s12 cards-container">
        <?php

            mostrarError();

            mostrarImagenes();

         ?>

        </div>
        </div>

      </div>
      <br>






      <div class="container">
        <!-- s tamaño para mobiles m tamaño para tablets y l para ordenadores
        en ordenadores el tamaño es menor -->
        <div class="col s12 m12 l12">
              <div class="row">


                <form class="col s12" name="myForm" action="accionesPaginaImagenes.php"
                 accept-charset="utf-8" method="POST"
                enctype="multipart/form-data">

                <div class="row">

                  <div class="input-field col s12">

                    <input class = 'estiloso' type="text" name="nombre" class="validate">
                    <label for="">Nombre de la imagen o carpeta</label>
                  </div>


                </div>


                <div class="row">
                  <div class="file-field input-field">
                    <div class="btn">
                      <span>Imagen</span>
                      <input name="imagen[]" accept="image/*" type="file" multiple>
                    </div>
                    <div class="file-path-wrapper">
                      <input class="file-path validate" type="text" placeholder="Seleccione una imagen o varias imagenes">
                    </div>

                  </div>
                </div>

                <div class="row">
                  <button name = "subir_imagen" type="submit" class="btn waves-effect waves-light">Subir imagen
                  <!-- <i class="material-icons right">send</i> -->
                  </button>
                  <button name = "crear_carpeta" type="submit" class="btn waves-effect waves-light">Crear carpeta
                  <!-- <i class="material-icons right">send</i> -->
                  </button>
                </div>
                <?php  global $directory;
                echo("<input type=\"hidden\" name=\"directorio\" value=\"".$directory."\">");?>

              </form>

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

function mostrarImagenes(){

  global $conection, $directory;

  /* Creacion de la sentencia para introducir el nuevo producto */
  //$sentence = "SELECT * FROM Imagenes";

  /* Ejecucion de la sentencia anterior */
  //$queryUsuario = mysqli_query($conection, $sentence) or die(ERROR_CONSULTA_DB);

  /*cojemos todos los usuarios de la base de datos y los mostramos en el
  formilario*/
  //$tipoUser;

  /*Mientras que tengamos una fila mas de la tabla consultar*/
  //while($usuario = mysqli_fetch_array($queryUsuario)){


    $dirint = dir($directory);

    while (($archivo = $dirint->read()) !== false)
    {
        $archivos[$archivo] = $archivo;
    }

    $dirint->close();

    /* Ordeno los archivos por orden alfabetico */
    ksort ($archivos);



    foreach($archivos as $archivo)
    {



      if($archivo !='..' && $archivo !='.' && $archivo !='.DS_Store'&& $archivo !='._.DS_Store' ){


        echo('<div class="item">');

       if (preg_match("/gif/i", $archivo) || preg_match("/jpg/i", $archivo) || preg_match("/png/i", $archivo)){

            $trozos = explode(".", $archivo);

            echo '<img src="'.$directory."/".$archivo.'">

            <span class="caption">'.$trozos[0].'</span>
            ';



        }else{

              echo "<a style='position: relative;' href=\"paginaSubirImagen.php?directorio=".$directory."/".$archivo."\"><img class='miniatura' src=img/carpeta.png><img src='".obtenerImagen($directory."/".$archivo)."'></a>
              <span class=\"caption\">".$archivo."</span>";

        }

        echo("</div>");
       }
     }



    /* Liberacion */
    //mysqli_free_result($queryUsuario);

    /* Cierre de la conexión a la base de datos. */
    //mysqli_close($conection);

}

function mostrarIconosCasaReturn(){

  global $directory;


  /* Si esta variable existe, es que se ha producido un error */
  if(strcmp ($directory,"Repositorio")!=0){

    /*Desplazarme el directorio root*/
    echo('<div  id="floatHome">
          <a href="paginaSubirImagen.php" class="btn-floating btn-large teal">
            <i class="material-icons">home</i>
          </a>
        </div>');
    echo('<div  id="floatBack">
          <a href="paginaSubirImagen.php?directorio='.dirname($directory).'"
          class="btn-floating btn-large teal">
            <i class="material-icons">arrow_back</i>
          </a>
        </div>');

  }
}

function obtenerImagen($ruta){

  foreach(glob("{$ruta}/*") as $file)
  {
      if(is_dir($file)) {

        return obtenerImagen($file);


      } else {

          return $file;

      }
  }

}

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
