
$(window, document, undefined).ready(function() {

  $('input').blur(function() {
    var $this = $(this);
    if ($this.val())
      $this.addClass('used');
    else
      $this.removeClass('used');
  });

  var $ripples = $('.ripples');

  $ripples.on('click.Ripples', function(e) {

    var $this = $(this);
    var $offset = $this.parent().offset();
    var $circle = $this.find('.ripplesCircle');

    var x = e.pageX - $offset.left;
    var y = e.pageY - $offset.top;

    $circle.css({
      top: y + 'px',
      left: x + 'px'
    });

    $this.addClass('is-active');

  });

  $ripples.on('animationend webkitAnimationEnd mozAnimationEnd oanimationend MSAnimationEnd', function(e) {
  	$(this).removeClass('is-active');
  });

});


(function($) {
		$(function() {

$('.dropdown-button').dropdown({
      inDuration: 300,
      outDuration: 225,
      hover: true, // Activate on hover
      belowOrigin: true, // Displays dropdown below the button
      alignment: 'right' // Displays dropdown with edge aligned to the left of button
    }
  );

		}); // End Document Ready
})(jQuery); // End of jQuery name space

(function($){
  $(function(){

    $('.button-collapse').sideNav();
    $('.parallax').parallax();

  }); // end of document ready
})(jQuery); // end of jQuery name space

$(document).ready(function() {
  $('select').material_select();
});

 $(document).ready(function(){
    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
    $('.modal').modal();
  });

  $( document ).ready(function() {
    $(".button-collapse").sideNav();
  });

  $(document).ready(function() {
  Materialize.updateTextFields();
})
$(window).load(function(){
    $('input:-webkit-autofill').each(function(){
        if ($(this).val().length !== "") {
            $(this).siblings('label, i').addClass('active');
        }
    });
});
$('.chips').material_chip();
$('.chips-initial').material_chip({
  data: [{
    tag: 'Apple',
  }, {
    tag: 'Microsoft',
  }, {
    tag: 'Google',
  }],
});
$('.chips-placeholder').material_chip({
  placeholder: 'Enter a tag',
  secondaryPlaceholder: 'Introducir Tags',
});
$('.chips-autocomplete').material_chip({
  autocompleteData: {
    'Apple': null,
    'Microsoft': null,
    'Google': null
  }
});


//
// $(window).load($.debounce(200,function(){
//     $('input:-webkit-autofill').each(function(){
//         if ($(this).val().length !== "") {
//             $(this).siblings('label, i').addClass('active');
//         }
//     });
// }));
