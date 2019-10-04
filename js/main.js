$(document).ready(function() {

  //	Плавная прокрутка
  $('.parallax').on('click', function(event) {
    event.preventDefault();
    $('html, body').animate({scrollTop: ($($(this).attr('href')).eq(0).offset().top)/*-$('header').height()*/}, 500);
  });

}