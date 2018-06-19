<?php

/*****************************************************************************/
/*                                                                           */
/*                           DEFINICION CONSTANTES                           */
/*                                                                           */
/*****************************************************************************/

define ('NOMBRE_USUARIO_DB', 'root');
define ('PASS_USUARIO_DB', '1002');
define ('NOMBRE_DB', 'residencia');
define ('SERVIDOR_DB', 'localhost');
define('INDEX','Location: index.php');

define ('ERROR', 'error');
define ('ERROR_CONEXION_DB', 'No se ha podido establecer conexion.');
define ('ERROR_CONSULTA_DB', 'Error al ejecutar la consulta.');
define ('ERROR_LOGIN', 'Nombre de usuario o contraseña incorrectos.');


/*****************************************************************************/
/*                                                                           */
/*                          DEFINICION DE FUNCIONES                          */
/*                                                                           */
/*****************************************************************************/

/*
 * Funcion para establecer conexion con la base de datos.
 *
 * La funcion devuelve la conexión establecida, si no hay ningun error.
 *
 * Si ocurre algun error, se muestra un pront y automaticamente se
 * detiene la ejecución.
 */
function establecerConexionDB()
{

  /*
   *Conexion a la base de datos, si esta no se establece se muestra un mensaje
   */
  $conection = mysqli_connect(
    SERVIDOR_DB, NOMBRE_USUARIO_DB, PASS_USUARIO_DB, NOMBRE_DB
  ) or die (ERROR_CONEXION_DB);

  /* Cambio de la codificación a utf-8 para obtener los acentos */
  mysqli_set_charset($conection, "utf8");

  /*
   * Devolucion de la conexion establecida, si no se establece conexion la
   * ejecucion muere, por lo tanto no llega a este punto.
   */
  return $conection;

}

?>
