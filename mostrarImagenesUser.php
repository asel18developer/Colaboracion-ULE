<?php
/* Inicio de sesion */
session_start();

/*
 * Incluyo el php que tiene la funcion para conectarse con la base de datos.
 */
Include('conectorBase.php');

/* Establezco conexion con la base de datos */
$conection = establecerConexionDB();

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
}


$userName = $_SESSION['user'];
$userType = $_SESSION['tipo'];
/* Obtengo el directorio actual */
$directory='Repositorio';



if(isset($_GET['repo'])){

  $directory=$_GET['repo'];

}

global  $directory;

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

  if ($userType == 2) { /* Si es un usuario especifico*/
    $repositorio = obtenerRepositorio();
  }

  foreach($archivos as $archivo)
  {



        if($archivo !='..' && $archivo !='.' && $archivo !='.DS_Store'&& $archivo !='._.DS_Store' ){

          if ($userType == 2 && imagenValida($repositorio, $directory."/".$archivo) == 1 ||
              $userType == 1 ) {
            echo('<div class="item">');

          if (preg_match("/gif/i", $archivo) || preg_match("/jpg/i", $archivo) || preg_match("/png/i", $archivo)){

              $trozos = explode(".", $archivo);
              $imagen = $directory."/".$archivo;
              echo "<img onclick=\"changeImage('$imagen')\" src='$imagen'>";
              echo('<label class="caption">'.$trozos[0].'</label>');



          }else{

              echo "<a style='position: relative;' onclick=\"getRepoUser('$directory"."/"."$archivo')\"><img class='miniatura' src=img/carpeta.png><img src='".obtenerImagen($directory."/".$archivo)."'></a>";
              echo("<label class=\"caption\">".$archivo."</label>");


            }

            echo("</div>");
        }
     }


  }

    echo("<input type=\"hidden\" name=\"directorio\" value=\"".$directory."\">");
    mostrarIconosCasaReturn();

        function mostrarIconosCasaReturn(){

          global $directory;


          /* Si esta variable existe, es que se ha producido un error */
          if(strcmp ($directory,"Repositorio")!=0){

            /*Desplazarme el directorio root*/
            $home = "Repositorio";
            $parent = dirname($directory);

            echo("<div id=\"floatHomeModal\">
                  <a onclick=\"getRepoUser('$home')\" class=\"btn-floating btn-large teal\">
                    <i class=\"material-icons\">home</i>
                  </a>
                </div>");
            echo("<div id=\"floatBackModal\">
                  <a onclick=\"getRepoUser('$parent')\"
                  class=\"btn-floating btn-large teal\">
                    <i class=\"material-icons\">arrow_back</i>
                  </a>
                </div>");

          }
        }


function obtenerRepositorio(){

  global $userName, $conection;

  $repositorio = array();

  $sentence =
     "SELECT
        *
      FROM
        RepPersonal
      WHERE
        usuario='$userName'";

  /* Ejecuacion de la sentencia */
  $query = mysqli_query($conection, $sentence) or die(ERROR_CONSULTA_DB);

  /*Mientras que tengamos una fila mas de la tabla consultar*/
  while($repPersonal = mysqli_fetch_array($query)){

    $idImagen = $repPersonal['imagen'];
    //TENGO EL ID TENGO QUE CONSEGUIR LA RUTA
    $sentence =
       "SELECT
          *
        FROM
          Imagenes
        WHERE
          id_imagen='$idImagen'";

    /* Ejecuacion de la sentencia */
    $queryImg = mysqli_query($conection, $sentence) or die(ERROR_CONSULTA_DB);
    $imagen = mysqli_fetch_array($queryImg);

    array_push($repositorio, $imagen['ruta']);

  }

  return $repositorio;

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

function imagenValida($repositorio, $dirImagen){

  //echo("La imagen pasada es $dirImagen ");

  foreach($repositorio as $imagen)
  {
      //echo("Comparando repUser $imagen con rep $dirImagen");
      if (strcmp($imagen, $dirImagen) == 0) {
        //echo " Correcto";
        //echo("Comparando repUser $imagen con rep $dirImagen<br>");
        return 1;
      }
      //echo "<br>";
  }

  return 0;

}
