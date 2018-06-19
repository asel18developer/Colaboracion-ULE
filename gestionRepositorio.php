<?php

/* Inicio de sesion */
session_start();

/* Incluyo el php que tiene la funcion para conectarse con la base de datos */
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
}else if ($_SESSION['tipo'] != 0){

    header('Location: index.php');
    die();

}

/* Obtengo el directorio actual */
$userName = '';


if(isset($_GET['user'])){

  $userName=$_GET['user'];

}

if (isset($_POST['delete_imagenes'])){

  deleteImages();

}

if (isset($_POST['anadir_imagenes'])){

  addImages();

}

header("Location: paginaModificacionUsuario.php?nombreUsuario=$userName");


function addImages(){
  global $userName, $conection;

  /* Recojo los usuarios a eliminar */
  $imagenesAnadir = $_POST['imagenesAnadir'];


  /* Establezco conexion con la base de datos */
  $conection = establecerConexionDB();

  /* Si hay usuarios para eliminar */
  if (!empty($imagenesAnadir)) {

    /* Recorro cada uno de los usuarios*/
    foreach($imagenesAnadir as  $imagen) {

      /* Si existe el archivo o directorio*/
      if(file_exists($imagen)){

        if (!is_dir($imagen)){

            /* Elimino la imagen o directorio */
            anadirImagen($imagen);
            $parent = dirname($imagen);
            while (strcmp($parent, 'Repositorio') != 0) {
              anadirImagen($parent);
              $parent = dirname($parent);
            }

         }else{/* Recorro el directorio para borrar todo el contenido */


           recursiveDirectory($imagen);


         }


      }

    }

  }

}

function deleteImages(){

  global $userName, $conection;

  /* Recojo los usuarios a eliminar */
  $imagenesAnadir = $_POST['imagenesAnadir'];


  /* Establezco conexion con la base de datos */
  $conection = establecerConexionDB();

  /* Si hay usuarios para eliminar */
  if (!empty($imagenesAnadir)) {

    /* Recorro cada uno de los usuarios*/
    foreach($imagenesAnadir as  $imagen) {

      /* Si existe el archivo o directorio*/
      if(file_exists($imagen)){

        if (!is_dir($imagen)){

            /* Elimino la imagen o directorio */
            deleteImagen($imagen);

         }else{/* Recorro el directorio para borrar todo el contenido */


           recursiveDirectoryDelete($imagen);


         }


      }

    }

  }

}

function deleteImagen($imagen){

  //echo("AÑADIR IMAGEN $imagen <br>");
  global $userName, $conection;
  $sentence =
     "SELECT
        *
      FROM
        Imagenes
      WHERE
        ruta='$imagen'";

  /* Ejecuacion de la sentencia */
  $queryImg = mysqli_query($conection, $sentence) or die(ERROR_CONSULTA_DB2);
  $imagenArray = mysqli_fetch_array($queryImg);

  $idImagen = $imagenArray['id_imagen'];

  /* Libera el resultado de la consulta SQL. */
  mysqli_free_result($queryImg);

  if (existeRepPersonal($idImagen,$userName) == 1) {
    //echo("EL ID DE LA IMAGEN ES $idImagen PARA EL USER $userName <BR>");
    $sentenceUser =
       "DELETE FROM RepPersonal
        WHERE
        usuario = '$userName' AND
        imagen = '$idImagen'";

    /* Ejecuacion de la sentencia */
    $queryUser = mysqli_query($conection, $sentenceUser) or die(ERROR_CONSULTA_DB4);
  }




}

function anadirImagen($imagen){

  //echo("AÑADIR IMAGEN $imagen <br>");
  global $userName, $conection;
  $sentence =
     "SELECT
        *
      FROM
        Imagenes
      WHERE
        ruta='$imagen'";

  /* Ejecuacion de la sentencia */
  $queryImg = mysqli_query($conection, $sentence) or die(ERROR_CONSULTA_DB2);
  $imagenArray = mysqli_fetch_array($queryImg);

  $idImagen = $imagenArray['id_imagen'];

  /* Libera el resultado de la consulta SQL. */
  mysqli_free_result($queryImg);

  if (existeRepPersonal($idImagen,$userName) == 0) {
    //echo("EL ID DE LA IMAGEN ES $idImagen PARA EL USER $userName <BR>");
    $sentenceUser =
       "INSERT INTO RepPersonal(
            usuario,
            imagen
          )
        VALUES
          ('$userName',
            '$idImagen'
          )";

    /* Ejecuacion de la sentencia */
    $queryUser = mysqli_query($conection, $sentenceUser) or die(ERROR_CONSULTA_DB3);
  }




}
function existeRepPersonal($idImagen,$userName){
  /* Llamada a las variables globales a utilizar */
  global $conection;

  $sentence =
     "SELECT
        *
      FROM
        RepPersonal
      WHERE
        usuario='$userName'
        AND
        imagen='$idImagen'";

  /* Ejecuacion de la sentencia */
  $query = mysqli_query($conection, $sentence) or die(ERROR_CONSULTA_DB);

  /* Numero de usuarios devueltos por la query*/
  $numeroDatosDevueltos = mysqli_num_rows ( $query);

  return $numeroDatosDevueltos;

}

function recursiveDirectory($directory){

  //echo "RECORRIENDO recorriendo el directorio $directory<br>";
  foreach(glob("{$directory}/*") as $file)
  {
    //echo "recorriendo el FICHERO $file<br>";

      if(is_dir($file)) {
        //echo "directorio $directory fichero $file<br>";
          anadirImagen($file);
          recursiveDirectory($file);
      } else {

          anadirImagen($file);

      }
  }
  anadirImagen($directory);
  $parent = dirname($directory);
  while (strcmp($parent, 'Repositorio') != 0) {
    anadirImagen($parent);
    $parent = dirname($parent);
  }
}
function recursiveDirectoryDelete($directory){

  foreach(glob("{$directory}/*") as $file)
  {

      if(is_dir($file)) {
        //echo "directorio $directory fichero $file<br>";
          deleteImagen($file);
          recursiveDirectoryDelete($file);
      } else {

          deleteImagen($file);

      }
  }
   deleteImagen($directory);
}
?>
