$( document ).ready(function() {

  $('.ui.fluid.search.selection.dropdown').dropdown();
 // $( "#datepicker" ).datepicker();
  $('table').tablesort();


  var dateToday = new Date(); 
$(function() {
    $( "#datepicker" ).datepicker({
        numberOfMonths: 1,
        minDate: dateToday
    });
});



  $('.ui.button.flight_details')
  .popup({
    inline   : true,
    hoverable: true,
    position : 'bottom right',
    delay: {
      show: 100,
      hide: 100
    }
  });
  $('.ui.simple.dropdown.item').dropdown();



  $( '.login-signup-popup' ).click(function() {
    $('.popup-signin').show();
  });


 

  $('#checkout_continue').click(function() {
    $('.flight_booking_steps .review').removeClass('active');
$('.flight_booking_steps .passengers_details').addClass('active');
$('.flight_booking_steps .review').addClass('completed');



   $('.checkout1').replaceWith($('.checkout2'));
   $('.checkout2').removeClass('inactive');
   $('.checkout2').show();
   $('#promo_code').hide();
   $(this).hide();




 });


$('.login-signup-popup')
  .popup({
    popup : $('.signin-signup-form'),
    hoverable: true
    
  })
;






if (typeof originCity !== 'undefined' && typeof destinationCity !== 'undefined') {


$('.flight_search .originCityDropdown .city').val(originCity);
$('.flight_search .originCityDropdown .default.text').html(originCityName);

$('.flight_search .destinationCityDropdown .city').val(destinationCity);
$('.flight_search .destinationCityDropdown .default.text').html(destinationCityName);

$('.flight_search .travelClass select').val(travelClass);
$('.flight_search .noOfTravellers input').val(noOfTravellers);
$('.flight_search .departureDate input').val(departureDate);


}




$('.ui.form')
  .form({
    fields: {
      fname     : 'empty',
      email : 'email',
      password : 'empty',
      cpassword : 'match[password]',

      address   : 'empty',
      terms    : 'checked'
      
      }
  });
$('.ui.radio.checkbox')
  .checkbox()
;
  
 
     $( '.signup-form' ).hide();

 
  $( '.signin-form .signup_button' ).click(function() {
 
    $( '.signin-form' ).hide();
    $('.signup-form').show();;
 
  });

  $( '.signup-form .signin_button' ).click(function() {
 
    $( '.signup-form' ).hide();
    $('.signin-form').show();
 
  });













});




