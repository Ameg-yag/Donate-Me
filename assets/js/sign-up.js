//Most Of Client Side Validation

$( document ).ready(function(){

    var full_name = $("#full_name");
    var email = $("#email");
    var password = $("#password");
    var feedback_p = $('#feedback');
    var passwordr = $("#password_repeat");
    var rollno = $("#rollno");
    var college = $("#college");
    var form = $("#signup-form");

    full_name.blur(function(){
        camel(full_name);
        isValid($(this));
    });

    email.blur(function(){
        email.val(email.val().toLowerCase().trim());
        isValid($(this));
    });

    password.keyup(function () {
        var result = zxcvbn($(this).val());
        feedback_p.text("Score:" + result.score + "/4\n" + result.feedback.warning);
        feedback_p.html(feedback_p.html().replace(/\n/g,'<br/>'));
    });

    password.blur(function () {
        feedback_p.text("");
    });

    passwordr.blur(function () {
        if (passwordr.val() !== ''){
            if( password.val() !== $(this).val()) {
                Materialize.toast('Not Matched', 5000);
            }
            else {
                Materialize.toast('Matched', 2000);
            }
        }
    });

    rollno.blur(function(){

        isValid($(this));

        var rollval = rollno.val();
        var code = rollval.substring(0,4);

        for(var key in collegelist)
        {
            if(key==code)
            {
                college.val(collegelist[key]);
            }
        }
    });

    form.on('submit', function (e) {
        e.preventDefault();
        if(full_name.is(':valid') && email.is(':valid') && password.is(':valid') && passwordr.is(':valid') && rollno.is(':valid')){
            var result = zxcvbn($(password).val());
            if(result.score!==4 && (password.val() !== passwordr.val())){
                $('#passgd').modal('open');
                materialize.toast("Check Passwords", 4000);
            }
            else {
                form.off();
                form.submit();
            }
        }
    });

    function camel(element) {
        var x = element.val().split(' ');
        var y = "";
        for (var i = 0; i<x.length; i++)
        {
            y+= x[i].substring(0,1).toUpperCase()+x[i].substring(1)+' ';
        }
        element.val(y.trim());
    }

    function isValid(element) {
        if (element.val() !== '' && element.is(":invalid")) {
            Materialize.toast('Input is Invalid', 2000);
        }
    }
});
