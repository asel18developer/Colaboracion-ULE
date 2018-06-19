<?php

  /* Comienzo de la sesion*/
  session_start();

  /* Incluyo la función necesaria para establecer la sesión */
  Include('conectorBase.php');

  /* Establezco conexion con la base de datos */
  $conection = establecerConexionDB();

/*****************************************************************************/
/*                                                                           */
/*                        EJECUCION PRINCIPAL DEL PHP                        */
/*                                                                           */
/*****************************************************************************/

  /* Obtengo el usuario que esta en sesion iniciada */
  $usuarioActual = $_SESSION['user'];


  /* Recojo los usuarios a eliminar */
  $imagenesParaEliminar = $_POST['imagenesEliminar'];

  /* Establezco conexion con la base de datos */
  $conection = establecerConexionDB();

  /* Si hay usuarios para eliminar */
  if (!empty($imagenesParaEliminar)) {

    /* Recorro cada uno de los usuarios*/
    foreach($imagenesParaEliminar as  $imagenEliminar) {

      /* Si existe el archivo o directorio lo elimino */
      if(file_exists($imagenEliminar)){

        if (!is_dir($imagenEliminar)){

            /* Elimino la imagen o directorio */
            eliminarImagenDB($imagenEliminar);
            unlink($imagenEliminar);


         }else{/* Recorro el directorio para borrar todo el contenido */

           recursiveRemoveDirectory($imagenEliminar);


         }


      }

    }

  }


  /* Redirección a la pagina donde se elimino el archivo */
  $directorio = "paginaEliminarImagen.php";
  if (isset($_POST['directorio'])) {
    $directorio="paginaEliminarImagen.php?directorio=".$_POST['directorio'];
  }
  header('Location:'.$directorio);



function eliminarImagenDB($imagenEliminar){

    global $conection;

    $sentence = "DELETE FROM  Imagenes
    where ruta = '$imagenEliminar'";

    $query = mysqli_query($conection, $sentence) or die("ERROR_CONSULTA_DB");

    /* Liberacion de la query */
    mysqli_free_result($query);
}

  function recursiveRemoveDirectory($directory)
  {
      foreach(glob("{$directory}/*") as $file)
      {
          if(is_dir($file)) {
              recursiveRemoveDirectory($file);
          } else {

              eliminarImagenDB($file);
              unlink($file);
          }
      }
      rmdir($directory);
  }

 ?>
