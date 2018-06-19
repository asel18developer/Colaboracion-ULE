<?php
header("X-XSS-Protection: 0");
/* Inicio de sesion */
session_start();

/* Incluyo el php que tiene la funcion para conectarse con la base de datos */
Include('conectorBase.php');

/*Incluyo el php para exportar a pdf*/
include("mpdf/mpdf.php");

/*Recupero el codigo css*/
$stylesheet = file_get_contents('css/materialize.css');
$stylesheet .= file_get_contents('css/style.css');

ob_clean();
$mpdf=new mPDF();
$mpdf->WriteHTML($stylesheet,1);




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


/* Obtengo el directorio actual */
$directory='Repositorio';
$serie='serie-blanca';

/* Establezco conexion con la base de datos */
$conection = establecerConexionDB();

if(isset($_GET['serie'])){

  $serie=$_GET['serie'];


}

if(isset($_GET['directorio'])){

  $directory=$_GET['directorio'];

}

/*
 *  Si existe un idDiapositiva, no aumentamos el idActual que usamos parallax
 *   asignar su id a las nuevas diapositivas
 */
if(!isset($_GET['idDiapositiva'])){

  if(isset($_POST['idActual'])){

    $arrayDiapositivas = split(",",$_POST['diapositivas']);
    $idActual = count($arrayDiapositivas) ;

  }else{

    $idActual = 0;

  }

}else{

  if(isset($_GET['idActual'])){

    $idActual = $_GET['idActual'];

  }else{

    $idActual = 0;

  }

}



/*Para poder exportar elpdf posteriormente*/
ob_start ();

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


  <!--  SCRIPTS -->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
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
          <li class="active" ><a href="crearCuentos.php">Crear cuentos</a></li>
          <li><a href="cerrarSesion.php">Cerrar sesion</a></li>
          <li><a class="modal-trigger" href="#modal2"><i class="material-icons">help</i></a></li>

        </ul>


        <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
        <a href="#modal2" class="modal-trigger help right"><i class="material-icons">help</i></a>

      </div>
    </nav>
  </div>

  <ul id="nav-mobile" class="right side-nav">
    <li ><a href="indexUser.php">Modificar cuenta</a></li>
    <li class="active teal lighten-2"><a href="crearCuentos.php">Crear cuentos</a></li>
    <li><a href="cerrarSesion.php">Cerrar sesion</a></li>
  </ul>
  </header>



    <!-- *********************************************************************** -->
    <!-- *********************************************************************** -->
    <!--********************* DIVISION CONTENIDO PRINCIPAL ********************* -->
    <!-- *********************************************************************** -->
    <!-- *********************************************************************** -->

    <main>

      <div id="modal1" class="modal modal-fixed-footer">
          <h4 style="padding:2%;">Seleccione la imagen</h4>
      <div class="modal-content">
          <div class="container imagesContainerModal" >

            <div class="row">
          <div class="col s12 cards-container" id = "imagesModal">

        <script type="text/javascript">
          getRepoUser("Repositorio");
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

      <!-- Modal Structure -->
      <div id="modal2" class="modal">
        <div class="modal-content">
        <h4>Ayuda modificar cuenta</h4>
        <p>
            Para modificar la cuenta, rellene los datos que quiera cambiar y pulse actualizar.
        </p>                  </div>
        <div class="modal-footer">
          <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">cerrar</a>
        </div>
      </div>

      <br>

      <form id="formCuento" name="formCuento" action=<?php echo("\"paginaCreacionCuentos.php?serie=".$serie."\"");?> method="post">

          <?php

            if (!isset($_POST['abrir_cuento'])) {
              creacionCuentos();
              descargarPDF();
            }else{
              cargarCuento();
            }

          ?>

      </form>



      <br><br>

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
function creacionCuentos(){

    global $serie;

    if ($serie == 'serie-blanca') {
        serieBlanca();
    }else if ($serie == 'serie-amarilla') {
        serieAmarilla();
    }else if ($serie == 'serie-azul') {
        serieAzul();
    }else if ($serie == 'serie-verde') {
        serieVerde();
    }else if ($serie == 'serie-naranja') {
        serieNaranja();
    }

}

function serieBlanca(){

  global $idActual, $serie, $mpdf;


    if(isset($_GET['idDiapositiva'])){

      $idDiapositiva  = $_GET['idDiapositiva'];
      $diapositivasArray = split(",",$_POST['diapositivas']);


      echo("
       <div id='diapositiva'>
       ".

       $diapositivasArray[$idDiapositiva]

       ."

       </div>");

       echo('    <div class="center botonesModificar">

               <button onclick="guardarDiapositiva('.$idDiapositiva.')" name="siguiente" class="btn waves-effect waves-light" type="submit" name="action">Guardar
                 <i class="material-icons right">send</i>
               </button><br><br>
               ');
       echo  " <input type='hidden' value = '".




         $_POST['diapositivas']

       ."' name='diapositivas' id='diapositivas'>";

       echo  " <input type='hidden' value = '".



       $idActual

       ."' name='idActual'>";

       if (strlen($_POST['diapositivas'])!=0) {
         $diapositivasArray = split(",",$_POST['diapositivas']);

         for ($i=0; $i < count($diapositivasArray) ; $i++) {
           //echo "<a href ='paginaCreacionCuentos.php?serie=serie-azul?idDiapositiva=".$i."'>".$diapositivasArray[$i]."</a>";
           echo "<div onclick='seleccionarDiapositiva(\"$serie\", $i, $idActual)' style='cursor:pointer;'>".$diapositivasArray[$i]."</div>";

         }
       }
       echo("</div>");




    }else{  echo('
      <div id="diapositiva">
      <div class="container paginaCuento" id ="'. $idActual.'" >


        <div class="row" >

          <div class="col s10 m10 l10 offset-s1 offset-l1 offset-m1">
            <div class="card grey lighten-4" >
              <div class="card-content black-text">

                <div class="row">


                    <div class="center col s12">
                      <a class="modal-trigger" href="#modal1"><img id = "img1" class = "unselected" onclick="seleccionar(this.id)" style="width:40%;height:40%;"src="img/add-image.png" alt=""></a>
                    </div>
                  </div>

                  <div class="row">

                  <div class="center col s12">
                    <a class="modal-trigger" href="#modal1"><img id = "img2" class = "unselected" onclick="seleccionar(this.id)" style="width:10%;height:10%;"src="img/add-image.png" alt=""></a>
                  </div>

                  </div>

                  <div class="row">

                  <div class="input-field col s8 m5 l5 offset-s2 offset-m4 offset-l4">

                    <input  type="text" class="imgText" class="validate">
                    <label for="">Inserte texto aquí</label>
                  </div>




                  </div>

              </div>



            </div>


            </div>

          </div>
        </div>
      </div>
      </div>
      <div class="center botonesModificar">

          <button onclick="anadirDiapositiva()" name="siguiente" class="btn waves-effect waves-light" type="submit" name="action">Siguiente
            <i class="material-icons right">send</i>
          </button>
          <button  name="descargar_PDF" class="btn waves-effect waves-light" type="submit" name="action">Cuento PDF
            <i class="material-icons right">send</i>
          </button>
          <button name="abrir_cuento" class="btn waves-effect waves-light" type="submit" name="action">Cuento web
            <i class="material-icons right">send</i>
          </button><br><br>');

      echo  " <input type='hidden' value = '".



        $_POST['diapositivas']

      ."' name='diapositivas' id='diapositivas'>";

      echo  " <input type='hidden' value = '".



      $idActual

      ."' name='idActual'>";


      if (strlen($_POST['diapositivas'])!=0) {
        $diapositivasArray = split(",",$_POST['diapositivas']);

        for ($i=0; $i < count($diapositivasArray) ; $i++) {
          //echo "<a href ='paginaCreacionCuentos.php?serie=serie-azul?idDiapositiva=".$i."'>".$diapositivasArray[$i]."</a>";
          echo "<div onclick='seleccionarDiapositiva(\"$serie\", $i, $idActual)' style='cursor:pointer;'>".$diapositivasArray[$i]."</div>";

        }
      }
      echo("</div>");
    }

}

function serieAmarilla(){

  global $idActual, $serie;


    if(isset($_GET['idDiapositiva'])){

      $idDiapositiva  = $_GET['idDiapositiva'];
      $diapositivasArray = split(",",$_POST['diapositivas']);


      echo("
       <div id='diapositiva'>
       ".

       $diapositivasArray[$idDiapositiva]

       ."

       </div>");

       echo('    <div class="center botonesModificar">

               <button onclick="guardarDiapositiva('.$idDiapositiva.')" name="siguiente" class="btn waves-effect waves-light" type="submit" name="action">Guardar
                 <i class="material-icons right">send</i>
               </button><br><br>');
       echo  " <input type='hidden' value = '".



         $_POST['diapositivas']

       ."' name='diapositivas' id='diapositivas'>";

       echo  " <input type='hidden' value = '".



       $idActual

       ."' name='idActual'>";

       if (strlen($_POST['diapositivas'])!=0) {
         $diapositivasArray = split(",",$_POST['diapositivas']);

         for ($i=0; $i < count($diapositivasArray) ; $i++) {
           //echo "<a href ='paginaCreacionCuentos.php?serie=serie-azul?idDiapositiva=".$i."'>".$diapositivasArray[$i]."</a>";
           echo "<div onclick='seleccionarDiapositiva(\"$serie\",$i, $idActual)' style='cursor:pointer;'>".$diapositivasArray[$i]."</div>";

         }
       }
       echo("</div>");




    }else{
      echo('
      <div id="diapositiva">
      <div class="container paginaCuento" id ="'. $idActual.'" >


        <div class="row" >

          <div class="col s10 m10 l10 offset-s1 offset-l1 offset-m1">
            <div class="card grey lighten-4" >
              <div class="card-content black-text">

                <div class="row">


                    <div class="center col s12">
                      <a class="modal-trigger" href="#modal1"><img id = "img1" class = "unselected" onclick="seleccionar(this.id)" style="width:40%;height:40%;"src="img/add-image.png" alt=""></a>
                    </div>
                  </div>

  <br>
                  <div class="center row">

                      <div class=" col s6">
                        <a class="serie-amarillaL modal-trigger" href="#modal1"><img id = "img2" class = "unselected" onclick="seleccionar(this.id)" style="width:20%;height:20%;"src="img/add-image.png" alt=""></a>
                      </div>

                      <div class="col s6">
                        <a class="serie-amarillaR modal-trigger" href="#modal1"><img id = "img3" class = "unselected" onclick="seleccionar(this.id)" style="width:20%;height:20%;"src="img/add-image.png" alt=""></a>
                      </div>

                  </div>

                  <div class="row">

                  <div class="input-field col s6">

                    <input type="text" class="imgText" class="validate">
                    <label for="">Inserte texto aquí</label>
                  </div>
                  <div class="input-field col s6">

                    <input type="text" class="imgText" class="validate">
                    <label for="">Inserte texto aquí</label>
                  </div>

                  </div>

              </div>



            </div>


            </div>

          </div>
        </div>
      </div>
      </div>
      <div class="center botonesModificar">

          <button onclick="anadirDiapositiva()" name="siguiente" class="btn waves-effect waves-light" type="submit" name="action">Siguiente
            <i class="material-icons right">send</i>
          </button>
          <button  name="descargar_PDF" class="btn waves-effect waves-light" type="submit" name="action">Cuento PDF
            <i class="material-icons right">send</i>
          </button>
          <button name="abrir_cuento" class="btn waves-effect waves-light" type="submit" name="action">Cuento web
            <i class="material-icons right">send</i>
          </button><br><br>');

      echo  " <input type='hidden' value = '".



        $_POST['diapositivas']

      ."' name='diapositivas' id='diapositivas'>";

      echo  " <input type='hidden' value = '".



      $idActual

      ."' name='idActual'>";


      if (strlen($_POST['diapositivas'])!=0) {
        $diapositivasArray = split(",",$_POST['diapositivas']);

        for ($i=0; $i < count($diapositivasArray) ; $i++) {
          //echo "<a href ='paginaCreacionCuentos.php?serie=serie-azul?idDiapositiva=".$i."'>".$diapositivasArray[$i]."</a>";
          echo "<div onclick='seleccionarDiapositiva(\"$serie\", $i, $idActual)' style='cursor:pointer;'>".$diapositivasArray[$i]."</div>";

        }
      }
      echo("</div>");
    }


}
function serieAzul(){

global $idActual, $serie;


  if(isset($_GET['idDiapositiva'])){

    $idDiapositiva  = $_GET['idDiapositiva'];
    $diapositivasArray = split(",",$_POST['diapositivas']);


    echo("
     <div id='diapositiva'>
     ".

     $diapositivasArray[$idDiapositiva]

     ."

     </div>");

     echo('    <div class="center botonesModificar">

             <button onclick="guardarDiapositiva('.$idDiapositiva.')" name="siguiente" class="btn waves-effect waves-light" type="submit" name="action">Guardar
               <i class="material-icons right">send</i>
             </button><br><br>');
     echo  " <input type='hidden' value = '".



       $_POST['diapositivas']

     ."' name='diapositivas' id='diapositivas'>";

     echo  " <input type='hidden' value = '".



     $idActual

     ."' name='idActual'>";

     if (strlen($_POST['diapositivas'])!=0) {
       $diapositivasArray = split(",",$_POST['diapositivas']);

       for ($i=0; $i < count($diapositivasArray) ; $i++) {
         //echo "<a href ='paginaCreacionCuentos.php?serie=serie-azul?idDiapositiva=".$i."'>".$diapositivasArray[$i]."</a>";
         echo "<div onclick='seleccionarDiapositiva(\"$serie\", $i, $idActual)' style='cursor:pointer;'>".$diapositivasArray[$i]."</div>";

       }
     }
     echo("</div>");




  }else{  echo('
    <div id="diapositiva">
    <div class="container paginaCuento" id ="'. $idActual.'" >


      <div class="row" >

        <div class="col s10 m10 l10 offset-s1 offset-l1 offset-m1">
          <div class="card grey lighten-4" >
            <div class="card-content black-text">

              <div class="row">


                  <div class="center col s12">
                    <a class="modal-trigger" href="#modal1"><img id = "img1" class = "unselected" onclick="seleccionar(this.id)" style="width:40%;height:40%;"src="img/add-image.png" alt=""></a>
                  </div>
                </div>

<br>
                <div class="row">

                <div class="center  col s4">
                  <a class="serie-amarillaL modal-trigger" href="#modal1"><img id = "img2" class = "unselected" onclick="seleccionar(this.id)" style="width:30%;height:20%;"src="img/add-image.png" alt=""></a>
                </div>

                <div class="center col s4">
                  <a class="modal-trigger" href="#modal1"><img id = "img3" class = "unselected" onclick="seleccionar(this.id)" style="width:30%;height:20%;"src="img/add-image.png" alt=""></a>
                </div>

                <div class="center col s4">
                  <a class="serie-amarillaR modal-trigger" href="#modal1"><img id = "img4" class = "unselected" onclick="seleccionar(this.id)" style="width:30%;height:20%;"src="img/add-image.png" alt=""></a>
                </div>

                </div>

                <div class="row">
                <div id="prueba" class="input-field col s4">

                  <input  type="text" class="imgText" class="validate">
                  <label for="">Inserte texto aquí</label>
                </div>
                <div class="input-field col s4">

                  <input  type="text" class="imgText" class="validate">
                  <label for="">Inserte texto aquí</label>
                </div>
                <div class="input-field col s4">

                  <input  type="text" class="imgText" class="validate">
                  <label for="">Inserte texto aquí</label>
                </div>




                </div>

            </div>



          </div>


          </div>

        </div>
      </div>
    </div>
    </div>
    <div class="center botonesModificar">

        <button onclick="anadirDiapositiva()" name="siguiente" class="btn waves-effect waves-light" type="submit" name="action">Siguiente
          <i class="material-icons right">send</i>
        </button>
        <button  name="descargar_PDF" class="btn waves-effect waves-light" type="submit" name="action">Cuento PDF
          <i class="material-icons right">send</i>
        </button>
        <button name="abrir_cuento" class="btn waves-effect waves-light" type="submit" name="action">Cuento web
          <i class="material-icons right">send</i>
        </button><br><br>');

    echo  " <input type='hidden' value = '".



      $_POST['diapositivas']

    ."' name='diapositivas' id='diapositivas'>";

    echo  " <input type='hidden' value = '".



    $idActual

    ."' name='idActual'>";


    if (strlen($_POST['diapositivas'])!=0) {
      $diapositivasArray = split(",",$_POST['diapositivas']);

      for ($i=0; $i < count($diapositivasArray) ; $i++) {
        //echo "<a href ='paginaCreacionCuentos.php?serie=serie-azul?idDiapositiva=".$i."'>".$diapositivasArray[$i]."</a>";
        echo "<div onclick='seleccionarDiapositiva(\"$serie\", $i, $idActual)' style='cursor:pointer;'>".$diapositivasArray[$i]."</div>";

      }
    }
    echo("</div>");
  }




}
function serieVerde(){

  global $idActual, $serie;


    if(isset($_GET['idDiapositiva'])){

      $idDiapositiva  = $_GET['idDiapositiva'];
      $diapositivasArray = split(",",$_POST['diapositivas']);


      echo("
       <div id='diapositiva'>
       ".

       $diapositivasArray[$idDiapositiva]

       ."

       </div>");

       echo('    <div class="center botonesModificar">

               <button onclick="guardarDiapositiva('.$idDiapositiva.')" name="siguiente" class="btn waves-effect waves-light" type="submit" name="action">Guardar
                 <i class="material-icons right">send</i>
               </button><br><br>');
       echo  " <input type='hidden' value = '".



         $_POST['diapositivas']

       ."' name='diapositivas' id='diapositivas'>";

       echo  " <input type='hidden' value = '".



       $idActual

       ."' name='idActual'>";

       if (strlen($_POST['diapositivas'])!=0) {
         $diapositivasArray = split(",",$_POST['diapositivas']);

         for ($i=0; $i < count($diapositivasArray) ; $i++) {
           //echo "<a href ='paginaCreacionCuentos.php?serie=serie-azul?idDiapositiva=".$i."'>".$diapositivasArray[$i]."</a>";
           echo "<div onclick='seleccionarDiapositiva(\"$serie\", $i, $idActual)' style='cursor:pointer;'>".$diapositivasArray[$i]."</div>";

         }
       }
       echo("</div>");




    }else{  echo('
      <div id="diapositiva">
      <div class="container paginaCuento" id ="'. $idActual.'" >


        <div class="row" >

          <div class="col s10 m10 l10 offset-s1 offset-l1 offset-m1">
            <div class="card grey lighten-4" >
              <div class="card-content black-text">

                <div class="row">


                    <div class="center col s12">
                      <a class="modal-trigger" href="#modal1"><img id = "img1" class = "unselected" onclick="seleccionar(this.id)" style="width:40%;height:40%;"src="img/add-image.png" alt=""></a>
                    </div>
                  </div>

  <br>
                  <div class="row">

                  <div class="center  col s3">
                    <a class="serie-amarillaL modal-trigger" href="#modal1"><img id = "img2" class = "unselected" onclick="seleccionar(this.id)" style="width:30%;height:20%;"src="img/add-image.png" alt=""></a>
                  </div>

                  <div class="center col s3">
                    <a class="modal-trigger" href="#modal1"><img id = "img3" class = "unselected" onclick="seleccionar(this.id)" style="width:30%;height:20%;"src="img/add-image.png" alt=""></a>
                  </div>

                  <div class="center col s3">
                    <a class="modal-trigger" href="#modal1"><img id = "img3" class = "unselected" onclick="seleccionar(this.id)" style="width:30%;height:20%;"src="img/add-image.png" alt=""></a>
                  </div>


                  <div class="center col s3">
                    <a class="serie-amarillaR modal-trigger" href="#modal1"><img id = "img4" class = "unselected" onclick="seleccionar(this.id)" style="width:30%;height:20%;"src="img/add-image.png" alt=""></a>
                  </div>

                  </div>

                  <div class="row">
                  <div id="prueba" class="input-field col s3">

                    <input  type="text" class="imgText" class="validate">
                    <label for="">Inserte texto aquí</label>
                  </div>
                  <div id="prueba" class="input-field col s3">

                    <input  type="text" class="imgText" class="validate">
                    <label for="">Inserte texto aquí</label>
                  </div>
                  <div class="input-field col s3">

                    <input  type="text" class="imgText" class="validate">
                    <label for="">Inserte texto aquí</label>
                  </div>
                  <div class="input-field col s3">

                    <input  type="text" class="imgText" class="validate">
                    <label for="">Inserte texto aquí</label>
                  </div>




                  </div>

              </div>



            </div>


            </div>

          </div>
        </div>
      </div>
      </div>
      <div class="center botonesModificar">

          <button onclick="anadirDiapositiva()" name="siguiente" class="btn waves-effect waves-light" type="submit" name="action">Siguiente
            <i class="material-icons right">send</i>
          </button>
          <button  name="descargar_PDF" class="btn waves-effect waves-light" type="submit" name="action">Cuento PDF
            <i class="material-icons right">send</i>
          </button>
          <button name="abrir_cuento" class="btn waves-effect waves-light" type="submit" name="action">Cuento web
            <i class="material-icons right">send</i>
          </button><br><br>');

      echo  " <input type='hidden' value = '".



        $_POST['diapositivas']

      ."' name='diapositivas' id='diapositivas'>";

      echo  " <input type='hidden' value = '".



      $idActual

      ."' name='idActual'>";


      if (strlen($_POST['diapositivas'])!=0) {
        $diapositivasArray = split(",",$_POST['diapositivas']);

        for ($i=0; $i < count($diapositivasArray) ; $i++) {
          //echo "<a href ='paginaCreacionCuentos.php?serie=serie-azul?idDiapositiva=".$i."'>".$diapositivasArray[$i]."</a>";
          echo "<div onclick='seleccionarDiapositiva(\"$serie\", $i, $idActual)' style='cursor:pointer;'>".$diapositivasArray[$i]."</div>";

        }
      }
      echo("</div>");
    }
}
function serieNaranja(){

    echo('
    <div class="container paginaCuento">


      <div class="row">

        <div class="col s10 m10 l10 offset-s1 offset-l1 offset-m1">
          <div class="card grey lighten-4">
            <div class="card-content black-text">

              <div class="row">


                  <div class="center col s12">
                    <a class="modal-trigger" href="#modal1"><img id = "img1" class = "unselected" onclick="seleccionar(this.id)" style="width:40%;height:40%;"src="img/add-image.png" alt=""></a>
                  </div>
                </div>


                <div class="row">

                    <div class="center col s12">
                      <a class="modal-trigger" href="#modal1"><img id = "img2" class = "unselected" onclick="seleccionar(this.id)" style="width:5%;height:5%;"src="img/add-image.png" alt=""></a>
                    </div>

                </div>

                <div class="row">


                  <div class="input-field col s8 m5 l5 offset-s2 offset-m4 offset-l4">

                    <input  type="text" class="imgText" class="validate">
                    <label for="">Inserte texto aquí</label>
                  </div>

                </div>

            </div>



          </div>
        </div>
      </div>
    </div>');
}

function descargarPDF(){

  global $mpdf;

  if (isset($_POST['descargar_PDF'])){

  $html = "<div class='center'>";
    if (strlen($_POST['diapositivas'])!=0) {
      $diapositivasArray = split(",",$_POST['diapositivas']);

      for ($i=0; $i < count($diapositivasArray) ; $i++) {
        //echo "<a href ='paginaCreacionCuentos.php?serie=serie-azul?idDiapositiva=".$i."'>".$diapositivasArray[$i]."</a>";
        $html .= "<div style='cursor:pointer;'>".$diapositivasArray[$i]."</div>";

      }
    }
  $html .= "</div>";

    $mpdf->WriteHTML($html);
    $mpdf->Output('cuento.pdf', 'D');

  }

}

function cargarCuento(){

  echo "<div class='center'>";
    if (strlen($_POST['diapositivas'])!=0) {
      $diapositivasArray = split(",",$_POST['diapositivas']);

      for ($i=0; $i < count($diapositivasArray) ; $i++) {
        //echo "<a href ='paginaCreacionCuentos.php?serie=serie-azul?idDiapositiva=".$i."'>".$diapositivasArray[$i]."</a>";
        echo "<div style='cursor:pointer;'>".$diapositivasArray[$i]."</div>";

      }
    }
  echo "</div>";

}


 ?>
