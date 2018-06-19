<?php
/* Inicio de sesion */
session_start();


/*
* En caso de que la variable de sesion del usuario logueado no este inicializada,
* nos retorna al index
*/
if (!isset($_SESSION['user'])){

    header('Location: index.php');
    die();

/*
 * Si el usuario esta logeado hay que revisar que su tipo le permite acceder
 * a esta pagina.
 * Lo hago en else if porque si no hay usuario logeado, este campo tampoco
 * esta lleno, entonces si efectivamente hay usuario logeado reviso su tipo
 */
}

/* Obtengo el directorio actual */
$directory='Repositorio';
$userName = '';


if(isset($_GET['repo'])){

  $directory=$_GET['repo'];

}

if(isset($_GET['user'])){

  $userName=$_GET['user'];

}

global  $directory, $userName;

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

  echo("

  <form  autocomplete='off' class='col s12' name='myForm' action='gestionRepositorio.php?user=$userName'
  accept-charset='utf-8' method='POST'
  enctype='multipart/form-data'>
  <div class='container imagesContainer' >
  <div class='row'>

  <div class='col s12 cards-container'>
  ");

  foreach($archivos as $archivo)
  {



    if($archivo !='..' && $archivo !='.' && $archivo !='.DS_Store'&& $archivo !='._.DS_Store' ){


      echo('<div class="item">');

     if (preg_match("/gif/i", $archivo) || preg_match("/jpg/i", $archivo) || preg_match("/png/i", $archivo)){


       $trozos = explode(".", $archivo);
       $imagen = $directory."/".$archivo;
        echo '<img src="'.$directory."/".$archivo.'">';
        echo "<input type=\"checkbox\" id=\"".$directory."/".$archivo."\" name=\"imagenesAnadir[]\" value=\"".$directory."/".$archivo."\"/>";
        echo('<label for="'.$directory."/".$archivo.'" class="caption">'.$trozos[0].'</label>');


  }else{

    $repositorio = $directory."/".$archivo;
    echo "<a style='position: relative;' onclick=\"addRepo('$repositorio','$userName')\"><img class='miniatura' src=img/carpeta.png><img src='".obtenerImagen($directory."/".$archivo)."'></a>";
    echo "<input id=\"".$directory."/".$archivo."\" type=\"checkbox\" name=\"imagenesAnadir[]\" value=\"".$directory."/".$archivo."\"/>";
    echo("<label for=\"".$directory."/".$archivo."\" class=\"caption\">".$archivo."</label>");


            }

            echo("</div>");
           }
         }

         echo("<input type=\"hidden\" name=\"directorio\" value=\"".$directory."\">");


         echo("</div></div></div>");
         echo("<br><div class='center botonesModificar'>
               <button name='anadir_imagenes' class='btnMargin btn waves-effect waves-light' type='submit' name='action'>Añadir imagenes
                 <i class='material-icons right'>add</i>
               </button>
               </form>");
        mostrarIconosCasaReturn();

        function obtenerImagen($ruta){

          foreach(glob("{$ruta}/*") as $file)
          {
              if(is_dir($file)) {

                return obtenerImagen($file);


              } else {

                  return $file;

              }
          }

        }

        function mostrarIconosCasaReturn(){

          global $directory, $userName;


          /* Si esta variable existe, es que se ha producido un error */
          if(strcmp ($directory,"Repositorio")!=0){

            /*Desplazarme el directorio root*/
            $home = "Repositorio";
            $parent = dirname($directory);

            echo("<div id=\"floatHomeModal\">
                  <a onclick=\"addRepo('$home','$userName')\" class=\"btn-floating btn-large teal\">
                    <i class=\"material-icons\">home</i>
                  </a>
                </div>");
            echo("<div id=\"floatBackModal\">
                  <a onclick=\"addRepo('$parent','$userName')\"
                  class=\"btn-floating btn-large teal\">
                    <i class=\"material-icons\">arrow_back</i>
                  </a>
                </div>");

          }
        }
