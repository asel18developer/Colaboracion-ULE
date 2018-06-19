<?php

/* Abro la sesión, por si no estaba abierta no cerrarla de forma innecesaria */
session_start();

/* Destruyo la sesión */
session_destroy();

/* Libero la memoria para las variables de sesión empleadas */
unset($_SESSION['user']);
unset($_SESSION['error']);

/* Redirigo la ventana a la pagina principal*/
header("Location: index.php");

?>
