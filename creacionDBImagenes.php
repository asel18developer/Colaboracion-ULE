<?php

/* Inicio de sesion */
session_start();




/* Incluyo el php que tiene la funcion para conectarse con la base de datos */
Include('conectorBase.php');

/* Establezco conexion con la base de datos */
$conection = establecerConexionDB();
/* Obtengo el directorio actual */
$directory='Repositorio';

if(isset($_GET['directorio'])){

  $directory=$_GET['directorio'];

}

  define ('ERROR_CONSULTA_DB', 'Error al ejecutar la consulta.');

    echo("Leyendo repositorio ....");

    listar_directorios_ruta($directory);
    // $dirint = dir($directory);
    //
    //
    // while (($archivo = $dirint->read()) !== false)
    // {
    //     $archivos[$archivo] = $archivo;
    // }
    //
    // $dirint->close();
    //
    // /* Ordeno los archivos por orden alfabetico */
    // ksort ($archivos);
    //
    // $counter = 1;
    //
    // foreach($archivos as $archivo)
    // {
    //
    //   if($archivo !='..' && $archivo !='.' ){
    //
    //     $ruta = $directory."/".$archivo;
    //     $trozos_archivo = explode(".", $archivo);
    //     $nombre_imagen = $trozos_archivo[0];
    //
    //     /* Creacion de la sentencia para introducir el usuario registrado */
    //     $sentence = "INSERT INTO Imagenes(
    //         nombre_imagen,
    //         ruta
    //       )
    //       VALUES (
    //         '$nombre_imagen',
    //         '$ruta'
    //       )";
    //       echo("LEYENDO IMAGEN ".$nombre_imagen." en la ruta ". $ruta."<br>");
    //     /* Ejecucion de la sentencia anterior */
    //     $query = mysqli_query($conection, $sentence) or die(ERROR_INSERTADO_DB);
    //
    //     /* Liberacion */
    //     mysqli_free_result($query);
    //     }
    //
    //    }




       echo("Finalizacion de lectura...");

    /* Liberacion */
    mysqli_free_result($queryUsuario);

    /* Cierre de la conexión a la base de datos. */
    mysqli_close($conection);


    function listar_directorios_ruta($ruta)
     {

       global $conection;
       // abrir un directorio y listarlo recursivo
       if (is_dir($ruta))
       {

         if ($dh = opendir($ruta))
         {

           echo("LEYENDO ruta pasada ".$ruta."<br>");
           while (($file = readdir($dh)) !== false)
           {
           //if (is_dir($ruta . $file) && $file!="." && $file!="..") // Si se desea mostrar solo directorios
           if ($file!="." && $file!="..") // Si se desea mostrar directorios y archivos
           {

             $ruta_imagen = $ruta ."/".$file;
             $trozos_archivo = explode(".", $file);
             $nombre_imagen = $trozos_archivo[0];

             /* Creacion de la sentencia para introducir el usuario registrado */
             $sentence = "INSERT INTO Imagenes(
                 nombre_imagen,
                 ruta
               )
               VALUES (
                 '$nombre_imagen',
                 '$ruta_imagen'
               )";

               echo("LEYENDO IMAGEN ".$nombre_imagen." en la ruta ". $ruta_imagen."<br>");

           //solo si el archivo es un directorio, distinto que "." y ".."
           /* Ejecucion de la sentencia anterior */
           $query = mysqli_query($conection, $sentence) or die(ERROR_INSERTADO_DB);

           /* Liberacion */
           mysqli_free_result($query);
           //ECHO("CULOOOOOSO".$ruta."/".$file."<BR>");
           listar_directorios_ruta($ruta."/".$file); // Ahora volvemos a llamar la función


           }
           }
           closedir($dh);
         }

       }
       echo("Fin de la creacion");
     }
 ?>
