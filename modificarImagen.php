<?php

/*****************************************************************************/
/*                                                                           */
/*                           DEFINICION CONSTANTES                           */
/*                                                                           */
/*****************************************************************************/

define ('REDIRECT', 'Location: paginaModificarImagen.php?directorio=');


/*****************************************************************************/
/*                                                                           */
/*                        EJECUCION PRINCIPAL DEL PHP                        */
/*                                                                           */
/*****************************************************************************/

/* Comienzo de la sesion*/
session_start();

/*
 * Incluyo el php que tiene la funcion para conectarse con la base de datos y registrar entrada en
 * el log.
 */
Include('conectorBase.php');


  /* Establezco conexion con la base de datos */
  $conection = establecerConexionDB();
  $rutaArchivo = $_POST['repo-group'];
  $directorio = $_POST['directorio'];

  /* Detecto el boton que se ha pulsado */
  if (isset($_POST['renombrar'])){

    renombrar();

  }

  if (isset($_POST['anadir'])){

    anadirTags();

  }

  if (isset($_POST['eliminar'])){

    eliminarTags();

  }

  /* Cierre de la conexion a la base de datos */
  mysqli_close($conection);

/*****************************************************************************/
/*                                                                           */
/*                           DEFINICION FUNCIONES                            */
/*                                                                           */
/*****************************************************************************/


function renombrar(){

  global $conection, $rutaArchivo, $directorio;

  $nuevo_nombre = $_POST['nombre'];
  $rutaNueva = $directorio."/".$nuevo_nombre;

  /*
   * Hay que comprobar que no exista ningun usuario con el mismo nombre, por
   * lo que busco en la base de datos el numero de usuarios con ese nombre.
   */
  $rutaExistente = archivoExistente($rutaNueva);

  /* No hay ninguna ruta igual */
  if ($rutaExistente==0 && $nuevo_nombre != '') {

    /* Cambiar nombre de la ruta */
    modificarRuta($rutaNueva, $nuevo_nombre);

  /* Existe algun usuario con ese nombre. */
  } else {

    /* Creo una variable de sesión que almacene el error producido */
    $_SESSION['error'] = "Ya existe una carpeta o imagen con ese nombre";


  }

header(REDIRECT.$directorio);


}

/*
 * Funcion que devuelve el numero de usuarios que tienen el nombre de usuario
 * introducido en el formulario.
 *
 */
function anadirTags(){
  /* Llamada a las variables globales a utilizar */
  global $conection, $rutaArchivo, $directorio;
  $tags = $_POST['tags'];

  /*Limpieza de datos*/
  $tags = str_replace(' ', '', $tags);

  /*Separación de los diferentes tags*/
  $tagsArray = explode(",",$tags);

  /*Recorrer todos los tags para ver cuales ya existen y cuales no para crealos
    si fuera necesario */
    foreach($tagsArray as $tag) {

      echo('Tag pasado --> '.$tag.'<br>');
      $tagExistente = tagExistente($tag);

      /* No existe ese tag hay que crearlo */
      if ($tagExistente == 0) {

        crearTag($tag);

      }

      /* Una vez creados, hay que añadirlos a la tabla de los tags e imagenes */

      /* Si es una carpeta se debe añadir a todas las imagenes y subcarpetas */
      if (!is_dir($rutaArchivo)){


          crearImgTag($tag, $rutaArchivo);

      }else{ /* Al ser un directorio debo recorrerlo y añadir el tag a todas*/

          recursiveCrearImagenTag($tag, $rutaArchivo);
          echo("Termine de recorrer las imagenes");

      }

    }


  /*Si es una imagen*/
header(REDIRECT.$directorio);
}


function eliminarTags(){
  /* Llamada a las variables globales a utilizar */

  global $conection, $rutaArchivo, $directorio;
  $tags = $_POST['tagsDelete'];


  /*Limpieza de datos*/
  $tags = str_replace(' ', '', $tags);

  /*Separación de los diferentes tags*/
  $tagsArray = explode(",",$tags);

  /* Obtener el id de la imagen */
  $sentence = "SELECT * FROM Imagenes WHERE ruta='$rutaArchivo'";
  //ECHO('La ruta de la imagen es '.$rutaArchivo.' se quiere añadir el tag '.$tag.'<br>');
  /*
   * Ejecucion de la sentencia anterior, si se produce algun error se muestra
   * un mensaje y se detiene la ejecucion
   */
  $query = mysqli_query($conection, $sentence) or die("ERROR_CONSULTA_DB");



  /* Obtencion del numero de usuarios devueltos por la query ejecutada*/
  $imagen = mysqli_fetch_array($query);
  $idImagen = $imagen["id_imagen"];

  $sentence = "SELECT * FROM ImgTag WHERE id_imagen='$idImagen'";

  /*
   * Ejecucion de la sentencia anterior, si se produce algun error se muestra
   * un mensaje y se detiene la ejecucion
   */
  $queryImgTag = mysqli_query($conection, $sentence) or die("ERROR_CONSULTA_DB");

  while($tag = mysqli_fetch_array($queryImgTag)){

        $tagActual = $tag["tag"];
        $eliminarTag = True;
        /*Recorrer todos los tags para ver cuales ya existen y cuales no para crealos
          si fuera necesario */
          foreach($tagsArray as $tag) {
            if ($tag!="" && $tag == $tagActual) {


              $eliminarTag = False;

            }



          }

          if ($eliminarTag) {

            echo('Tag que tengo que eliminar --> '.$tagActual.'<br>');
            eliminarImgTag($tagActual, $idImagen);
          }

  }



  /*Si es una imagen*/
header(REDIRECT.$directorio);
}

function eliminarImgTag($tag, $idImagen){

  /* Llamada a las variables globales a utilizar */
  global $conection;


  /* Obtener el id de la imagen */
  $sentence = "DELETE FROM ImgTag WHERE id_imagen='$idImagen' AND tag='$tag'";
  //ECHO('La ruta de la imagen es '.$rutaArchivo.' se quiere añadir el tag '.$tag.'<br>');
  /*
   * Ejecucion de la sentencia anterior, si se produce algun error se muestra
   * un mensaje y se detiene la ejecucion
   */
  $query = mysqli_query($conection, $sentence) or die("ERROR_CONSULTA_DB");

}
/*
 * Funcion que devuelve el numero de usuarios que tienen el nombre de usuario
 * introducido en el formulario.
 *
 */
function archivoExistente($ruta){

  /* Llamada a las variables globales a utilizar */
  global $conection;
  echo("La ruta a renombrar es ".$ruta);
  /*
   * Selecciono todos los datos de la tabla Usuarios donde el nombre de usuario
   * es el mismo que el introducido en el formulario
   */
  $sentence = "SELECT * FROM Imagenes WHERE ruta='$ruta'";

  /*
   * Ejecucion de la sentencia anterior, si se produce algun error se muestra
   * un mensaje y se detiene la ejecucion
   */
  $query = mysqli_query($conection, $sentence) or die(ERROR_CONSULTA_DB);

  /* Obtencion del numero de usuarios devueltos por la query ejecutada*/
  $numeroDatosDevueltos = mysqli_num_rows( $query);
  echo("Numero de involucradoes es ".$numeroDatosDevueltos);
  /* Liberacion de la query */
  mysqli_free_result($query);

  return $numeroDatosDevueltos;

}

/*
 * Funcion que devuelve el numero de usuarios que tienen el nombre de usuario
 * introducido en el formulario.
 *
 */
function tagExistente($tag){

  /* Llamada a las variables globales a utilizar */
  global $conection;

  /*
   * Selecciono todos los datos de la tabla Usuarios donde el nombre de usuario
   * es el mismo que el introducido en el formulario
   */
  $sentence = "SELECT * FROM Tags WHERE nombre='$tag'";

  /*
   * Ejecucion de la sentencia anterior, si se produce algun error se muestra
   * un mensaje y se detiene la ejecucion
   */
  $query = mysqli_query($conection, $sentence) or die("ERROR_CONSULTA_DB");

  /* Obtencion del numero de usuarios devueltos por la query ejecutada*/
  $numeroDatosDevueltos = mysqli_num_rows( $query);

  /* Liberacion de la query */
  mysqli_free_result($query);

  return $numeroDatosDevueltos;

}

/*
 * Funcion que devuelve el numero de usuarios que tienen el nombre de usuario
 * introducido en el formulario.
 *
 */
function tagImgExistente($tag,$idImagen){

  /* Llamada a las variables globales a utilizar */
  global $conection;

  /*
   * Selecciono todos los datos de la tabla Usuarios donde el nombre de usuario
   * es el mismo que el introducido en el formulario
   */
  $sentence = "SELECT * FROM ImgTag WHERE tag='$tag' AND id_imagen='$idImagen'";

  /*
   * Ejecucion de la sentencia anterior, si se produce algun error se muestra
   * un mensaje y se detiene la ejecucion
   */
  $query = mysqli_query($conection, $sentence) or die("ERROR_CONSULTA_DB");

  /* Obtencion del numero de usuarios devueltos por la query ejecutada*/
  $numeroDatosDevueltos = mysqli_num_rows( $query);

  /* Liberacion de la query */
  mysqli_free_result($query);

  return $numeroDatosDevueltos;

}

function modificarRuta($rutaNueva,$nombreNuevo){

  global $conection, $rutaArchivo, $directorio;


  /* Si es una imagen se cambia simplemente */
    if (!is_dir($rutaArchivo)){

      modificarImagen($rutaArchivo,$rutaNueva,$nombreNuevo);


    }else{/* Si es un directorio necesito recorrerlo internamente para poder Cambiar
       la ruta a todos sus hijos */

       recursiveRenameDirectory($rutaArchivo,$rutaNueva,$nombreNuevo);
       //modificarRutaImagen($file,$updateDirectory);//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    }


}

function recursiveCrearImagenTag($tag, $rutaArchivo){


  foreach(glob("{$rutaArchivo}/*") as $file)
  {


      if(is_dir($file)) {

          recursiveCrearImagenTag($tag,$file);

      } else {

        crearImgTag($tag, $file);

      }
  }


}
function recursiveRenameDirectory($directoryOld, $directoryNew, $newName)
{

    global $rutaArchivo;

    foreach(glob("{$directoryOld}/*") as $file)
    {

        $updateDirectory = str_replace($rutaArchivo, $directoryNew, $file);
        // /* Cambio el nombre ya sea archivo o carpeta */
        // ECHO("Directorio viejo ".$directoryOld.'<BR>');
        // ECHO("Directorio nuevo ".$directoryNew.'<BR>');
        // echo("eL FICHERO PROCESADO ES: ".$file."<br>");
        // echo("EL FICHERO NUEVO RENOMBRADO: ".$updateDirectory."<br>");
        // //echo("NEW directory is: ".$updateDirectory."<br>");
        // echo("-------------------------------<br>");

        // echo("NEW directory is: ".$updateDirectory."<br>");
        // echo("-------------------------------");
        /* Si es una carpeta se cambia de nombre y se recorre*/
        if(is_dir($file)) {

            recursiveRenameDirectory($file,$directoryNew,$newName);

        } else {

            //unlink($file);
            modificarRutaImagen($file,$updateDirectory);

        }
    }
    /* Cambio el nombre ya sea archivo o carpeta */

    $carpetaRenombrada = str_replace($rutaArchivo, $directoryNew, $directoryOld);

    rename($directoryOld,$carpetaRenombrada);
}

function crearImgTag($tag, $rutaArchivo){

  global $conection;

  /* Obtener el id de la imagen */
  $sentence = "SELECT * FROM Imagenes WHERE ruta='$rutaArchivo'";
  //ECHO('La ruta de la imagen es '.$rutaArchivo.' se quiere añadir el tag '.$tag.'<br>');
  /*
   * Ejecucion de la sentencia anterior, si se produce algun error se muestra
   * un mensaje y se detiene la ejecucion
   */
  $query = mysqli_query($conection, $sentence) or die("ERROR_CONSULTA_DB");



  /* Obtencion del numero de usuarios devueltos por la query ejecutada*/
  $imagen = mysqli_fetch_array($query);
  $idImagen = $imagen["id_imagen"];
  /* Liberacion */
  mysqli_free_result($query);
  $tagExistente = tagImgExistente($tag, $idImagen);
  if ($tagExistente == 0 && $tag != '') {

    /* Creacion de la sentencia para introducir el usuario registrado */
    $sentence = "INSERT INTO ImgTag(
        tag,
        id_imagen
      )
      VALUES (
        '$tag',
        '$idImagen'
      )";

      /* Ejecucion de la sentencia anterior */
       $query = mysqli_query($conection, $sentence) or die("ERROR_INSERTADO_DB en IMGTAGS");

  }



}

function modificarImagen($rutaAntigua, $rutaNueva,$nombreNuevo){

  global $conection;

  $sentence = "UPDATE Imagenes
      SET  ruta ='$rutaNueva' ,nombre_imagen = '$nombreNuevo'
      WHERE ruta = '$rutaAntigua';";

  /*Cambio el nombre en el servidor, para ello obtengo la extension*/
  $trozos = explode(".", $rutaAntigua);
  $extension = end($trozos);
  rename($rutaAntigua,$rutaNueva.".".$extension);

  /* Ejecucion de la sentencia anterior */
  $query = mysqli_query($conection, $sentence) or die("ERROR_INSERTADO_DB");

  /* Liberacion */
  mysqli_free_result($query);

}

function modificarRutaImagen($rutaAntigua, $rutaNueva){

  global $conection;

  $sentence = "UPDATE Imagenes
      SET  ruta ='$rutaNueva'
      WHERE ruta = '$rutaAntigua';";

  rename($rutaAntigua,$rutaNueva);

  /* Ejecucion de la sentencia anterior */
  $query = mysqli_query($conection, $sentence) or die("ERROR_INSERTADO_DB");

  /* Liberacion */
  mysqli_free_result($query);

}


function crearTag($tag){

  global $conection;
  /* Creacion de la sentencia para introducir el usuario registrado */
  $sentence = "INSERT INTO Tags(
      nombre
    )
    VALUES (
      '$tag'
    )";

    /* Ejecucion de la sentencia anterior */
    $query = mysqli_query($conection, $sentence) or die("ERROR_INSERTADO_DB");

}

function idImagen($rutaArchivo){

  global $conection;

  /* Obtener el id de la imagen */
  $sentence = "SELECT * FROM Imagenes WHERE ruta='$rutaArchivo'";

  /*
   * Ejecucion de la sentencia anterior, si se produce algun error se muestra
   * un mensaje y se detiene la ejecucion
   */
  $query = mysqli_query($conection, $sentence) or die("ERROR_CONSULTA_DB");

  /* Obtencion del numero de usuarios devueltos por la query ejecutada*/
  $imagen = mysqli_fetch_array($query);

  $idImagen = $imagen["id_imagen"];

  /* Liberacion */
  mysqli_free_result($query);

  return $idImagen;


}
