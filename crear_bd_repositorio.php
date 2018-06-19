<?php

/* Incluyo el php que tiene la funcion para conectarse con la base de datos */
Include('conectorBase.php');

$directory='Repositorio';

/* Establezco conexion con la base de datos */
$conection = establecerConexionDB();

/* Obtengo el directorio actual */
$directory='Repositorio';


define ('ERROR_CONSULTA_DB', 'Error al ejecutar la consulta.');

global $conection, $directory;

/* Creacion de la sentencia para introducir el nuevo producto */
//$sentence = "SELECT * FROM Imagenes";

/* Ejecucion de la sentencia anterior */
//$queryUsuario = mysqli_query($conection, $sentence) or die(ERROR_CONSULTA_DB);

/*cojemos todos los usuarios de la base de datos y los mostramos en el
formilario*/
//$tipoUser;

/*Mientras que tengamos una fila mas de la tabla consultar*/
//while($usuario = mysqli_fetch_array($queryUsuario)){


  $dirint = dir($directory);

  while (($archivo = $dirint->read()) !== false)
  {
      $archivos[$archivo] = $archivo;
  }

  $dirint->close();

  /* Ordeno los archivos por orden alfabetico */
  ksort ($archivos);

  $counter = 1;

  foreach($archivos as $archivo)
  {

    if($archivo !='..' && $archivo !='.' ){

    echo("<div id=\"cardImage\" class=\"card grey lighten-4\">
          <div class=\"card-image \">");



     if (preg_match("/gif/i", $archivo) || preg_match("/jpg/i", $archivo) || preg_match("/png/i", $archivo)){

          $trozos = explode(".", $archivo);

          echo '<img src="'.$directory."/".$archivo.'">';
          echo("<br><br>");
          echo("<span class=\"card-title teal-text\">".$trozos[0]."</span>");


      }else{


            echo "<a href=\"paginaSubirImagen.php?directorio=".$directory."/".$archivo."\"><img id=\"cardImage\" src=carpeta.png></a>";
            echo("<br><br>");
            echo("<span class=\"card-title teal-text\">".$archivo."</span>");

      }



      echo("</div>");
      echo("</div>");
     }
   }
   echo("<input type=\"hidden\" name=\"directorio\" value=\"".$directory."\">");


   $dirint->close();




  /* Liberacion */
  mysqli_free_result($queryUsuario);

  /* Cierre de la conexión a la base de datos. */
  mysqli_close($conection);

 ?>
