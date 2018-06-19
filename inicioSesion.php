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


/*****************************************************************************/
/*                                                                           */
/*                        EJECUCION PRINCIPAL DEL PHP                        */
/*                                                                           */
/*****************************************************************************/


  /* Obtengo los valores insertados en el form */
	$nombre_usuario = $_POST['nombre_usuario'];
	$pass = $_POST['pass'];

  /* Variable global para almacenar la query*/
  $query;

  /* Establezco conexion con la base de datos */
  $conection = establecerConexionDB();

  /*
   * Obtengo si existe un usuario con dicho nombre de usuario y contraseña
   */
  $usuarioCorrecto = esUsuarioCorrecto();

  /*
   * Si usuarioCorrecto es 0 quiere decir que no hay ningun usuario, que
   * coincida con la información introducida
   */
  if ($usuarioCorrecto == 0) {

    /* Cierre de la conexion a la base de datos */
    mysqli_close($conection);

    /* Creo una variable de sesión que almacene el error producido */
    $_SESSION[ERROR] = ERROR_LOGIN;

    /*
     * Redirijo al usuario a la misma pagina y ahora mostrara el ERROR
     * almacenado en la variable de sesion.
     */
    header(INDEX);

    /* ---- OJO --- En caso de que despues del header tenga
     * codigo que no queremos que se ejecute debemos hacer un
     * die() ya que si no cambia de pestaña pero el codigo
     * sigue su ejecucion
     */
     die();

  /*
   * Si usuarioCorrecto es 1, debo fijarme en el tipo de usuario, para así
   * redirigir al usuario a su correspondiente pagina.
   */
  } else {

    accesoCuenta();

  }

/* Cierre de la conexión a la base de datos. */
mysqli_close($conection);

/*****************************************************************************/
/*                                                                           */
/*                           DEFINICION FUNCIONES                            */
/*                                                                           */
/*****************************************************************************/


/*
 * Función que redirige al usuario a su pagina correspondiente en función
 * del tipo de dicho usuario.
 */
function accesoCuenta(){

  /* Llamada a las variables globales a utilizar */
  global $query, $nombre_usuario;

  /* Guardo en la variable sesion el nombre de usuario */
  $_SESSION['user'] = $nombre_usuario;

  /* Obtencion de los valores de la query en forma de array */
  $array_resultados = mysqli_fetch_array($query);

  /* Obtencion del valor pedido, en este caso es el tipo de usuario*/
  $tipo_usuario = $array_resultados[0];

  /* Guardo el tipo de usuario que inicia sesion */
  $_SESSION['tipo'] = $tipo_usuario;

  /* En función del tipo de usuario, se abre la pagina correspondiente. */
  if ($tipo_usuario == 0) {


    header('Location: paginaAdministrador.php');


  } else if($tipo_usuario == 1 || $tipo_usuario == 2){

    header('Location: indexUser.php');

  }


  /* Libera el resultado de la consulta SQL. */
  mysqli_free_result($query);

}


/*
 * Funcion que devuelve 0 o 1 en función de los datos introducidos por el
 * usuario:
 *  -> Devuelve 0 si no existe ningun usuario con dicho nombre y pass.
 *  -> Devuelve 1 si existe un usuario con dicho nombre y pass.
 */
function esUsuarioCorrecto(){

  /* Llamada a las variables globales a utilizar */
  global $query, $conection,$nombre_usuario, $pass;
  $pass = md5($pass);
  /*
   * Creacion de una sentencia para recoger el tipo de usuario, para un usuario
   * con el nombre y contraseña introducidos en el form.
   */
  $sentence =
     "SELECT
        tipo
      FROM
        Usuarios
      WHERE
        nombre_usuario='$nombre_usuario'
        AND
        pass='$pass'";

  /* Ejecuacion de la sentencia */
  $query = mysqli_query($conection, $sentence) or die(ERROR_CONSULTA_DB);

  /* Numero de usuarios devueltos por la query*/
  $numeroDatosDevueltos = mysqli_num_rows ( $query);

  return $numeroDatosDevueltos;

}
