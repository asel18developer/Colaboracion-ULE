<?php

require_once('ImageManipulator.php');

/* Inicio de sesion */
session_start();

Include('conectorBase.php');

/* Establezco conexion con la base de datos */
$conection = establecerConexionDB();

$nombre = $_POST['nombre'];
$directorio = $_POST['directorio'];
$redireccion = "paginaSubirImagen.php";
echo("Nombre ".$nombre."<br>");
echo("Directorio ".$directorio."<br>");


if (isset($directorio)) {

  $redireccion="paginaSubirImagen.php?directorio=".$directorio;

}

if (isset($_POST['crear_carpeta'])){

  echo("Creación de una carpeta nueva si es posible.<br>");
  crearCarpeta();

}

if (isset($_POST['subir_imagen'])){

  echo("Subida de una imagen nueva.<br>");
  subirImagen();

}

/* Redirección a la pagina donde se elimino el archivo */
header('Location:'.$redireccion);


function subirImagen(){

  global $directorio,$nombre, $conection;

  echo("Procesando imagen subida...");


  /* Obtengo la imagen subida, la cual se almacena en la variable $_FILES */
  if (isset($_FILES['imagen'])){

	  $cantidad= count($_FILES["imagen"]["tmp_name"]);

    for ($i=0; $i<$cantidad; $i++){


      /* Obtencion del nombre temporal que usa php */
      $tmpName  = $_FILES['imagen']['tmp_name'][$i];
      /* Obtencion del nombre del archivo subido*/
      $fileName = $_FILES['imagen']['name'][$i];
      echo("EL NOMBRE DEL FICHERO SUBIDO ES ".$fileName."<BR>");
      /* Obtencion del tamaño de la imagen */
      $fileSize = $_FILES['imagen']['size'][$i];
      /* Obtencion del tipo de imagen*/
      $fileType = $_FILES['imagen']['type'][$i];

      $imagen = $directorio."/".$fileName;


      if ($nombre!=""&& $cantidad==1) {

        echo("La imagen recibe el nombre ".$nombre."<br>");
        $trozos = explode(".", $fileName);
        $extension = end($trozos);
        $imagen = $directorio."/".$nombre.".".$extension;
        $fileName = $nombre;
      }else{/* Nombre original sin extension */

        $trozos = explode(".", $fileName);
        $fileName = $trozos[0];

      }


      echo("Ruta de la imagen: ".$imagen." y nombre ".$fileName."<br>");


      if (!file_exists($imagen)) {



        $manipulator = new ImageManipulator($tmpName);
        // resizing to 200x200
        $newImage = $manipulator->resample(500, 500, false);
        // saving file to uploads folder
        $manipulator->save($imagen);
        echo 'Done ...';

        $sentence = " INSERT INTO Imagenes(
          nombre_imagen,
          ruta
        )
        VALUES (
          '$nombreImagen',
          '$imagen'
        )";

        $query = mysqli_query($conection, $sentence) or die("ERROR_CONSULTA_DB");

        /* Liberacion de la query */
        mysqli_free_result($query);
        //copy($tmpName, $imagen);

      }else{

        $_SESSION['error']='Ya existe una imagen con ese nombre.';
      }


    }
  }

}

function crearCarpeta(){

  global $nombre,$directorio;
  $directorio = $directorio."/".$nombre;

  if (!file_exists($directorio)) {

    mkdir($directorio, 0777, true);

  }else{

    $_SESSION['error']='Ya existe una carpeta con ese nombre.';
  }




}


?>
