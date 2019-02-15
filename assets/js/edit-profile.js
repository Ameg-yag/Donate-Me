//JS File To Autofill Values on Edit Profile Page Using LocalStorage

$( document ).ready(function(){
    sessionStorage.setItem("fullReset", true);

    $("#fname").val(localStorage.getItem("fname"));
    $("#mname").val(localStorage.getItem("mname"));
    $("#lname").val(localStorage.getItem("lname"));
});
