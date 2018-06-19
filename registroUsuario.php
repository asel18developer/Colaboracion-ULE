<?php

/* Comienzo de la sesion*/
session_start();

/* Includyo el php que tiene la funcion para conectarse con la base de datos y registrar entrada en
el log.

IMPORTANTE: NO INCLUIR CONECTORBASE PORQUE YA ESTA  INCLUIDO EN ENTRADAS LOG. SI LO INCLUYES DA ERROR.
 */
Include('conectorBase.php');

/*****************************************************************************/
/*                                                                           */
/*                           DEFINICION CONSTANTES                           */
/*                                                                           */
/*****************************************************************************/

define('USUARIO_EXISTENTE', 'Nombre de usuario existente.');

/*****************************************************************************/
/*                                                                           */
/*                        EJECUCION PRINCIPAL DEL PHP                        */
/*                                                                           */
/*****************************************************************************/

  /* Obtengo los valores insertados en el form */
  $nombre = $_POST['nombre'];
  $apellidos = $_POST['apellidos'];
  $nombre_usuario = $pass1 = $pass2 = $tipoRegistro = "";

  /* Establezco conexion con la base de datos */
  $conection = establecerConexionDB();

  if (isset($_POST['modificar_usuario'])){

    modificarUsuario();

  }

  if (isset($_POST['registro'])){

    crearUsuario();

  }

  if (isset($_POST['gestion_imagenes'])){

    gestionImagenes();

  }

  /* Cierre de la conexion a la base de datos */
  mysqli_close($conection);




/*****************************************************************************/
/*                                                                           */
/*                           DEFINICION FUNCIONES                            */
/*                                                                           */
/*****************************************************************************/


function crearUsuario(){

  global $conection,$nombre,$apellidos, $nombre_usuario, $pass1, $pass2, $tipoRegistro;

  $nombre_usuario = $_POST['nombre_usuario'];
  $tipoRegistro = $_POST['tipo_usuario'];
  $pass1 = md5($_POST['pass1']);
  $pass2 = md5($_POST['pass2']);


  /*
   * Hay que comprobar que no exista ningun usuario con el mismo nombre, por
   * lo que busco en la base de datos el numero de usuarios con ese nombre.
   */
  $numeroUsuarios = esUsuarioRegistrado($nombre_usuario);

  /* No hay usuarios con ese nombre, puedo introducir el nuevo usuario */
  if ($numeroUsuarios==0) {

    crearUsuarioRegistrado();


    /* Vuelvo al index */
    header("Location: index.php");

  /* Existe algun usuario con ese nombre. */
  } else {


    /* Creo una variable de sesión que almacene el error producido */
    $_SESSION['error'] = USUARIO_EXISTENTE;

    /*
     * Redirijo al usuario a la misma pagina y ahora mostrara el ERROR
     * almacenado en la variable de sesion.
     */
    header("Location: paginaRegistroUsuario.php");

    /* ---- OJO --- En caso de que despues del header tenga
     * codigo que no queremos que se ejecute debemos hacer un
     * die() ya que si no cambia de pestaña pero el codigo
     * sigue su ejecucion
     */
     //die();


  }


}

/*
 * Funcion que devuelve el numero de usuarios que tienen el nombre de usuario
 * introducido en el formulario.
 *
 */
function esUsuarioRegistrado($nombre_usuario){

  /* Llamada a las variables globales a utilizar */
  global $conection,$nombre,$apellidos, $pass1, $pass2, $tipoRegistro;



  /*
   * Selecciono todos los datos de la tabla Usuarios donde el nombre de usuario
   * es el mismo que el introducido en el formulario
   */
  $sentence = "SELECT * FROM Usuarios WHERE nombre_usuario='$nombre_usuario'";

  /*
   * Ejecucion de la sentencia anterior, si se produce algun error se muestra
   * un mensaje y se detiene la ejecucion
   */
  $query = mysqli_query($conection, $sentence) or die(ERROR_CONSULTA_DB);

  /* Obtencion del numero de usuarios devueltos por la query ejecutada*/
  $numeroDatosDevueltos = mysqli_num_rows( $query);

  /* Liberacion de la query */
  mysqli_free_result($query);

  return $numeroDatosDevueltos;

}


function modificarUsuario(){

  global $conection,$nombre,$apellidos, $nombre_usuario, $pass1, $pass2, $tipoRegistro;

  $nombre_usuario = $_GET['nombreUsuario'];
  $pass = $_POST['pass'];
  $tipoRegistro = $_POST['tipo_usuario'];
  $nombre_usuario_update = $_POST['nombre_usuario_update'];
  $sentenceNombreUsuario = "";
  $sentencePass = "";



  /* Si nombre de usuario no esta vacio es que quieren modificarlo, pero hay
     que comprobar no exista un usuario con dicho nombre ya.*/
if ( $nombre_usuario != $nombre_usuario_update && $nombre_usuario_update!="" && esUsuarioRegistrado($nombre_usuario_update)==0) {

    $sentenceNombreUsuario = "nombre_usuario = '$nombre_usuario_update',";

    if ($_POST['modificacionPropia']==1) {
      $_SESSION['user'] = $nombre_usuario_update;
    }


  }else if($nombre_usuario != $nombre_usuario_update && $nombre_usuario_update!="" && esUsuarioRegistrado($nombre_usuario_update)!=0){


    $_SESSION['error'] = USUARIO_EXISTENTE;
    header("Location: paginaModificacionUsuario.php?nombreUsuario=".$nombre_usuario);
    die();


  }

  /* Si la pass no esta vacia es que quieren modificarla */
  if ($pass != "") {
    $pass = md5($pass);
    $sentencePass = "pass = '$pass',";

  }

  $sentence = "UPDATE Usuarios
      SET $sentenceNombreUsuario $sentencePass tipo ='$tipoRegistro' ,nombre = '$nombre', apellidos ='$apellidos'
      WHERE nombre_usuario = '$nombre_usuario';";


  /* Ejecucion de la sentencia anterior */
  $query = mysqli_query($conection, $sentence) or die(ERROR_INSERTADO_DB);

  /* Liberacion */
  mysqli_free_result($query);

  /* Vuelvo al index */
  header("Location: paginaSeleccionUsuarios.php");





}


function gestionImagenes(){

  /* Llamada a las variables globales a utilizar */
  global $nombre_usuario;


  /* Vuelvo al index */
  header("Location: paginaAñadirImagenes.php?nombre_usuario=".$nombre_usuario."");



}


/*
 * Funcion que introduce en la base de datos el usuario registrado.
 */
function crearUsuarioRegistrado(){

  /* Llamada a las variables globales a utilizar */
  global $conection,$nombre,$apellidos, $nombre_usuario, $pass1, $pass2, $tipoRegistro;



  /* Creacion de la sentencia para introducir el usuario registrado */
  $sentence = "INSERT INTO Usuarios(
      nombre_usuario,
      pass,
      nombre,
      apellidos,
      tipo
    )
    VALUES (
      '$nombre_usuario',
      '$pass1',
      '$nombre',
      '$apellidos',
      '$tipoRegistro'
    )";

  /* Ejecucion de la sentencia anterior */
  $query = mysqli_query($conection, $sentence) or die(ERROR_INSERTADO_DB);

  /* Liberacion */
  mysqli_free_result($query);

}

?>
