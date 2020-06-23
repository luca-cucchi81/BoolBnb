$('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:5
        }
    }
})

$('img').dblclick(function() {
  var clone = $(this).clone();
  // console.log(clone);
  $('.tendina-bottom').empty();
  $('.tendina-bottom').addClass('altezza');
  $('.tendina-bottom').append(clone);
  $('.tendina-bottom').append('<div class="close"><i class="fas fa-times"></i></div>');
  $(clone).addClass('big');

})

$('').click(function() {
  $('.tendina-bottom').removeClass('altezza');

})
$(document).on('click', '.fas', function(){
  $('.tendina-bottom').empty();
  $('.tendina-bottom').removeClass('altezza');
});
