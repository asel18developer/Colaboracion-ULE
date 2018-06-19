<?php

  /* Comienzo de la sesion*/
  session_start();

  /* Incluyo la función necesaria para establecer la sesión */
  Include('conectorBase.php');


/*****************************************************************************/
/*                                                                           */
/*                        EJECUCION PRINCIPAL DEL PHP                        */
/*                                                                           */
/*****************************************************************************/

  /* Obtengo el usuario que esta en sesion iniciada */
  $usuarioActual = $_SESSION['user'];

  /* Recojo los usuarios a eliminar */
  $usuariosParaEliminar = $_POST['usuariosEliminar'];

  /* Establezco conexion con la base de datos */
  $conection = establecerConexionDB();

  /* Si hay usuarios para eliminar */
  if (!empty($usuariosParaEliminar)) {

    /* Recorro cada uno de los usuarios*/
    foreach($usuariosParaEliminar as  $usuarioEliminar) {

      /* No permito que se borre el usuario que esta logeado actualmente */
      if($usuarioActual != $usuarioEliminar){

        /* Sentencia para eliminar el usuario con dicho nombre de usuario */
        $sentence = "DELETE FROM Usuarios WHERE nombre_usuario='".$usuarioEliminar."'";

        /* Ejecucion de la sentencia anterior */
        $query = mysqli_query($conection, $sentence) or die(ERROR_CONSULTA_DB);

      }

    }

  }

  /* Redirección a la pagina de administrador */
  header('Location: paginaEliminarUsuarios.php');

 ?>
