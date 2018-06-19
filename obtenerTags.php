<?php


/* Inicio de sesion si esta no esta iniciada */
if (!isset($_SESSION)) {
  session_start();
}

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
}else if ($_SESSION['tipo'] != 0){

  header('Location: index.php');
  die();


}


/* Incluyo el php que tiene la funcion para conectarse con la base de datos */
Include('conectorBase.php');


/* Establezco conexion con la base de datos */
$conection = establecerConexionDB();
$directoryImg = $_GET['img'];
$directory = $_GET['directorio'];

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <script type="text/javascript" src="js/script.js"></script>
    <title></title>
  </head>
  <body>
<?php $sentence = "SELECT * FROM Imagenes WHERE ruta='$directoryImg'";

/*
 * Ejecucion de la sentencia anterior, si se produce algun error se muestra
 * un mensaje y se detiene la ejecucion
 */
$queryTags = mysqli_query($conection, $sentence) or die("ERROR_CONSULTA_DB");

/* Obtencion del numero de usuarios devueltos por la query ejecutada*/
$imagen = mysqli_fetch_array($queryTags);
$idImagen = $imagen["id_imagen"];

$sentence = "SELECT * FROM ImgTag WHERE id_imagen='$idImagen'";

/*
 * Ejecucion de la sentencia anterior, si se produce algun error se muestra
 * un mensaje y se detiene la ejecucion
 */
$queryImgTag = mysqli_query($conection, $sentence) or die("ERROR_CONSULTA_DB");

/* Obtencion del numero de usuarios devueltos por la query ejecutada*/
//$tags = mysqli_fetch_array($queryImgTag);
echo('

<form name="myForm" action="modificarImagen.php"
accept-charset="utf-8" method="POST" enctype="multipart/form-data">
<br>

<div>');

while($tag = mysqli_fetch_array($queryImgTag)){
  echo('<div class="chip">
      '.$tag["tag"].'
      <i class="close material-icons">close</i>
      </div>');


}

echo "<input type='hidden' name='directorio' id='directorio' value = '$directory'>";
echo "<input type='hidden' name='repo-group' id='repo-group' value = '$directoryImg'>";
echo('</div>
<input type="hidden" name="tagsDelete" id="tagsDelete">

<div class="center">');


    echo "<br><button name='eliminar' onClick='rellenarTags()' class='btn waves-effect waves-light' type='submit' name='action'>Guardar";

    echo('</button>



</div></form>'); ?>
  </body>
</html>
