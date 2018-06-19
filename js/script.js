/******************************************************************************/
/*                                                                             /
/*                         CONSTANTES JAVASCRIPT                               /
/*                                                                             /
/******************************************************************************/

const RELLENAR_CAMPOS = "Se deben rellenar todos los campos."
const ERROR_ELIMINACION = "Se debe seleccionar un producto, lote o subasta para poder eliminar."
const SELECCIONAR_ITEM = "Debe seleccionar un producto o lote para subastar."
const PASS_ERROR = "Las contraseñas deben coincidir."
const PASS_ERROR_LONGITUD = "La contraseña debe tener mínimo 6 caracteres."
const ERROR_LOTE = "Se deben seleccionar al menos dos productos para crear un lote."
const CAD_VACIA = ""

/******************************************************************************/
/*                                                                             /
/*                            VARIABLES GLOBALES                               /
/*                                                                             /
/******************************************************************************/

/******************************************************************************/
/*                                                                             /
/*                                 FUNCIONES                                   /
/*                                                                             /
/******************************************************************************/


/*
 * Funcion utilizada para validar que en el inicio de sesion todos los campos
 * tengan un valor introducido.
 */
function validateInicioSesion(){

var nombre_usuario, pass;

/* Obtengo todos los datos introducidos en el formulario */
nombre_usuario = document.forms["myForm"]["nombre_usuario"].value;
/* Calculo el md5 de la contraseña */
pass = document.forms["myForm"]["pass"].value;
/* Cambio el valor para que se envio encriptada */
document.forms["myForm"]["pass"].value = pass;

/* Si alguno de los campos esta vacio no se admite inicio de sesion,
 * se devuelve false.
 */
if (nombre_usuario == CAD_VACIA || pass == CAD_VACIA) {

  alert(RELLENAR_CAMPOS);
  return false;
}

return true;

}

function validateModificarUsuario(){

  var nombre_usuario, pass1, pass2, nombre, apellidos;

  /* Obtengo todos los datos introducidos en el formulario */
  pass = document.forms["myForm"]["pass"].value;
  nombre = document.forms["myForm"]["nombre"].value;
  apellidos = document.forms["myForm"]["apellidos"].value;


  /* Si alguno de los campos esta vacio no se admite el registro de ese usuario,
   * se devuelve false.
   */
   if (nombre == CAD_VACIA || apellidos == CAD_VACIA) {

     alert(RELLENAR_CAMPOS);
     return false;

   }

   /*
    * Si las contraseñas no coinciden no es valida la creacion de ese usuario.
    */
   if (pass != "" && pass.length < 6) {

     alert(PASS_ERROR_LONGITUD);
     return false;

   }

  return true;

}

/*
 * Funcion utilizada para validar que en el registro de un nuevo usuario
 * todos los campos estan llenos y las contraseñas coinciden.
 */
function validateRegistroUsuario(){

var nombre_usuario, pass1, pass2, nombre, apellidos;

/* Obtengo todos los datos introducidos en el formulario */
nombre_usuario = document.forms["myForm"]["nombre_usuario"].value;
pass1 = document.forms["myForm"]["pass1"].value;
pass2 = document.forms["myForm"]["pass2"].value;
nombre = document.forms["myForm"]["nombre"].value;
apellidos = document.forms["myForm"]["apellidos"].value;

/* Si alguno de los campos esta vacio no se admite el registro de ese usuario,
 * se devuelve false.
 */
 if (nombre_usuario == CAD_VACIA || pass1 == CAD_VACIA || pass2 == CAD_VACIA ||
     nombre == CAD_VACIA || apellidos == CAD_VACIA) {

   alert(RELLENAR_CAMPOS);
   return false;
 }

 /*
  * Si las contraseñas no coinciden no es valida la creacion de ese usuario.
  */
 if (pass1 != pass2) {

   alert(PASS_ERROR);
   return false;

 }else if(pass1.length < 6){

   alert(PASS_ERROR_LONGITUD);
   return false;

 }


return true;

}


function addRepo(dir, user)
{
   $.ajax({

     type: "GET",
     url: 'mostrarImagenes.php',
     data: "repo=" + dir+"&user="+user, // appears as $_GET['id'] @ your backend side
     success: function(data) {
           // data is ur summary
          $('#imagesModal').html(data);
     }

   });

}
function deleteRepo(dir, user)
{
   $.ajax({

     type: "GET",
     url: 'mostrarImagenesDelete.php',
     data: "repo=" + dir+"&user="+user, // appears as $_GET['id'] @ your backend side
     success: function(data) {
           // data is ur summary
          $('#imagesModalDelete').html(data);
     }

   });

}


function getRepoUser(dir)
{
   $.ajax({

     type: "GET",
     url: 'mostrarImagenesUser.php',
     data: "repo=" + dir, // appears as $_GET['id'] @ your backend side
     success: function(data) {
           // data is ur summary
          $('#imagesModal').html(data);
     }

   });

}

function getTags(img,directorio)
{
   $.ajax({

     type: "GET",
     url: 'obtenerTags.php',
     data: "img=" + img+"&directorio="+directorio, // appears as $_GET['id'] @ your backend side
     success: function(data) {
           // data is ur summary
          $('#contenedorTags').html(data);
     }

   });

}


function obtainUser(){

  var user = document.getElementsByClassName('selected');
  var userName;

  for (var i = 0; i < user.length; i++) {

    userName = user[i].id;
  }


  modifyUser(userName);
}

function modifyUser(userName)
{
   $.ajax({

     type: "GET",
     url: 'modificacionUsuario.php',
     data: "nombreUsuario=" + userName, // appears as $_GET['id'] @ your backend side
     success: function(data) {
           // data is ur summary
          $('#userModal').html(data);
     }

   });

}

function seleccionar(id)
{


  var imgSelected = document.getElementsByClassName('selected');

  for (var i = 0; i < imgSelected.length; i++) {

    imgSelected[i].className = 'unselected'

  }

  var imgClicked = document.getElementById(id)
  imgClicked.className = 'selected';


}

function seleccionarUsuario(id)
{


  var userSelected = document.getElementsByClassName('selected');

  for (var i = 0; i < userSelected.length; i++) {

    userSelected[i].className = 'unselected'

  }

  var userClicked = document.getElementById(id)
  userClicked.className = 'selected';


}

function changeImage(img){


  var imgSelected = document.getElementsByClassName('selected');


  for (var i = 0; i < imgSelected.length; i++) {

    imgSelected[i].src = img;
    imgSelected[i].className = 'unselected'


  }
cerrarModal()

}

function cerrarModal(){
   $('#modal1').modal('close');
}

function anadirTags(){

  var tags = $('#insert-tags').material_chip('data');
  if (tags.length != 0) {
      var tagsString = "";
      for (var i = 0; i < tags.length; i++) {

          tagsString = tagsString + tags[i].tag;

          if (i != tags.length-1 ) {

            tagsString = tagsString + ", ";


          }

      }

      var tagsInput = document.getElementById('tags')
      tagsInput.value = tagsString;
      /*$('#tags').value = tagsString;
      alert(  $('#tags').value)*/
  }
}

function anadirDiapositiva(){



    var elementos = document.getElementById("diapositiva").getElementsByClassName("imgText");

    for(var i=0; i<elementos.length; i++) {
      //alert("Elemento dice "+elementos[i].value);
      elementos[i].setAttribute("value", elementos[i].value);
      }

    var diapositivas = document.getElementById("diapositivas");
    var diapositivaActual = document.getElementById("diapositiva").innerHTML;

    if (diapositivas.value.length == 0) {
        diapositivas.value = diapositivaActual;
    }else{
        diapositivas.value = diapositivas.value + "," + diapositivaActual;
    }

    //alert(diapositivas.value);



}

function guardarDiapositiva(idDiapositiva){

  /* Cambio el valor del input por el introducido nuevamente */
  var elementos = document.getElementById("diapositiva").getElementsByClassName("imgText");


  for(var i=0; i<elementos.length; i++) {
    elementos[i].setAttribute("value", elementos[i].value);
    }

  var diapositivas = document.getElementById("diapositivas");
  var diapositivaActual = document.getElementById("diapositiva").innerHTML;


  var arrayDiapositivas = diapositivas.value.split(',');
  arrayDiapositivas[idDiapositiva] = diapositivaActual;


  for (var i = 0; i < arrayDiapositivas.length; i++) {

    if (i == 0) {
        diapositivas.value = arrayDiapositivas[i];

    }else{

        diapositivas.value = diapositivas.value + "," + arrayDiapositivas[i];

    }

  }

}
function rellenarTags(){

  /* Cambio el valor del input por el introducido nuevamente */
  var chips = document.getElementsByClassName("chip");
  var tags = "";

  for(var i=0; i<chips.length; i++) {
    /* Para obtener el tag actual capturo el contenido de cada chip en html puro
       y le cojo antes del <i.... a la vez que elimino todos sus saltos de linea
       o espacios en blanco*/
    var tagActual = chips[i].innerHTML.split("<")[0].replace(/\s/g,'');

    tags += tagActual +",";


    }
  var tagsInput = document.getElementById('tagsDelete')
  tagsInput.value = tags;




}
function seleccionarDiapositiva(serie, idDiapositiva, idActual){

  document.formCuento.action="paginaCreacionCuentos.php?serie="+serie+"&idDiapositiva="+idDiapositiva+"&idActual="+idActual
  document.formCuento.submit();

}
