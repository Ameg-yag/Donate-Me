<?php
/**
 * Created by PhpStorm.
 * User: ravindra
 * Date: 24/1/18
 * Time: 7:18 PM
 */
require_once ('./imports/login-gate.php');
require_once ('./imports/validation.php');
require_once ('./imports/conn.php');

if (isset($_POST['submit'])){
    $code = test_input($_POST['code']);
    $location1 = test_input($_POST['location1']);
    $location2 = test_input($_POST['location2']);
    $type = test_input($_POST['type']);

    $SQL = "INSERT INTO " . UPLOAD_TABLE . "(code, uploader, type, location1, location2) VALUES(?, ?, ?, ?, ?)";

    if (!($stmt = $mysqli->prepare($SQL))) {
        die("PF: Something went wrong");
    }

    if (!$stmt->bind_param("sssss", $code, $rollno, $type, $location1, $location2)) {
        die("BP: Something went wrong");
    }

    if (!$stmt->execute()) {
        die("E: Please check your inputs");
    }

    $stmt->close();
    $msg = "Upload Successfull";
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <link rel="shortcut icon" href="../favicon.ico" >
    <link rel="icon" href="../animated_favicon.gif" type="image/gif" >

    <title>UseIt - Share</title>

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="../assets/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="../assets/css/main.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
<?php require_once ('./imports/menu.html');?>

<br>
<!--UPLOAD FORM-->
<div class="container">
    <div class="center">
        <h3>Share A Book</h3>
        <a href="viewBook.php" class="btn">View The Book List</a><br><br>
        <strong>NOTE: If a book is not available in the list then you must add it first</strong><br>
        <h5><?php echo $msg ?></h5>
    </div>
    <br>
    <div class="row">
        <form id="signup-form" action="<?php $_SERVER['PHP_SELF'] ?>" method="post" class="col s12">
            <fieldset>
                <legend>Upload Details</legend>

                <div class="input-field col s12 m12 l6 xl6">
                    <i class="material-icons prefix">looks_one</i>
                    <input id="code" name="code" type="text" class="validate" data-length="7" minlength="4" maxlength="7" pattern="[A-Z0-9$]{2,7}" required>
                    <label for="code" data-error="Validation failed" data-success="Validation Successful">Subject Code</label>
                </div>

                <div class="input-field col s12 m12 l6 xl6">
                    <i class="material-icons prefix">book</i>
                    <input id="name" name="name" type="text" placeholder="Subject name will autocomplete" data-length="70" maxlength="70" disabled>
                    <label for="name" data-error="Validation failed" data-success="Validation Successful">Subject Name</label>
                </div>

                <div class="input-field col s12">
                    <i class="material-icons prefix">location_on</i>
                    <textarea id="location1" name="location1" class="materialize-textarea" placeholder="Suggestion: Use your college address if possible"></textarea>
                    <label for="location1">Location 1</label>
                </div>

                <div class="input-field col s12">
                    <i class="material-icons prefix">location_on</i>
                    <textarea id="location2" name="location2" class="materialize-textarea" placeholder="Suggestion: Use nearest safe and famous place near your home"></textarea>
                    <label for="location2">Location 2</label>
                </div>

                <div class="input-field col s12 m12 l12 xl12">
                    <select name="type">
                        <option value="" disabled selected>Choose your option</option>
                        <option value="1">Books / Shivani</option>
                        <option value="2">Notes (Handwritten)</option>
                        <option value="3">Other</option>
                    </select>
                    <label>Type</label>
                </div>

                <button class="btn waves-effect waves-light submit" type="submit" name="submit">Share
                </button>

                <a href="./home.php"><input type="button" class="btn waves-effect waves-light" value="cancel">
                    </input></a>

            </fieldset>
        </form>
    </div>
</div>

<!--  Scripts-->
<!--<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>-->

<script src="../assets/js/json/subject.js"></script>
<script>
    if(sessionStorage.getItem("reset")){
        sessionStorage.removeItem("reset");
        location.reload(true);
    }

    document.getElementById("code").onblur = function () {
        var code = this.value;
        var found = false;
        if(this.value!=""){
            for(var key in subjectlist)
            {
                if(key === code)
                {
                    document.getElementById("name").value=subjectlist[key];
                    found = true;
                }
            }

            if(!found)
            {
                alert("This subject is not available please add it first");
                sessionStorage.setItem("code",document.getElementById("code").value);
                window.location="./addBook.php";
            }
        }
    };

    var loc1 = document.getElementById("location1");
    var loc2 = document.getElementById("location2");

    loc1.onblur = function () {
        localStorage.setItem("location1", loc1.value);
    };
    loc2.onblur = function () {
        localStorage.setItem("location2", loc2.value);
    };

    if(loc1.value=="")
    {
        loc1.value = localStorage.getItem("location1");
    }

    if(loc2.value=="")
    {
        loc2.value = localStorage.getItem("location2");
    }
</script>
<script src="../assets/js/jquery-2.1.1.min.js"></script>
<script src="../assets/js/materialize.js"></script>
<script src="../assets/js/main.js"></script>
<script src="../assets/js/localvar.js"></script>
<script>

    capitalize($("#code"));
    capitalize($("#location1"));
    capitalize($("#location2"));

    function capitalize(element) {
        element.on('input', function() {
            var input = $(this);
            var start = input[0].selectionStart;
            $(this).val(function (_, val) {
                return val.toUpperCase();
            });
            input[0].selectionStart = input[0].selectionEnd = start;
        });
    }
</script>
</body>
</html>

