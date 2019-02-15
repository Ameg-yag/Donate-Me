//Common JavaScript File On All Pages

$( document ).ready(function(){
    $(".button-collapse").sideNav();
    $(".dropdown-button").dropdown();
    $('.carousel.carousel-slider').carousel({fullWidth: true});
    $('.carousel').carousel();
    $('select').material_select();
    $('.modal').modal();
    $(".button-collapse").sideNav();
    $('.parallax').parallax();
    $('.datepicker').pickadate({
        selectMonths: true,
        selectYears: 70,
        today: 'Today',
        clear: 'Clear',
        close: 'Ok',
        closeOnSelect: false
    });
});

