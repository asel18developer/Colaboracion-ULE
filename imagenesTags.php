<?php
/*
 * Inicio de sesion, si ya esta iniciada con anterioridad, no se vuelve a
 * iniciar, se obvia.
 */
session_start();

/*
 * Incluyo el php que tiene la funcion para conectarse con la base de datos.
 */
Include('conectorBase.php');

/* Establezco conexion con la base de datos */
$conection = establecerConexionDB();

/* Obtengo los valores insertados en el form */
$rutaImagen = $_GET['imagen'];

$idImagen = obtenerIDImagen($rutaImagen);

$sentence =
   "SELECT
      tag
    FROM
      ImgTag
    WHERE
      id_imagen='$idImagen'";

/* Ejecuacion de la sentencia */
$query = mysqli_query($conection, $sentence) or die(ERROR_CONSULTA_DB);


function obtenerIDImagen($rutaImagen){

    global $conection;

    $sentence =
       "SELECT
          id
        FROM
          Imagenes
        WHERE
          ruta='$rutaImagen'";

    /* Ejecuacion de la sentencia */
    $query = mysqli_query($conection, $sentence) or die(ERROR_CONSULTA_DB);

}
 ?>
