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
    $name = test_input($_POST['name']);

    if(!validateSubjectCode($code))
    {
        die("Invalid Input");
    }

    $mysqli= new mysqli(HOST,USER,PASSWORD,DB);

    $SQL = "SELECT name FROM " . SUBJECT_TABLE . " WHERE code = ?";

    if (!($stmt = $mysqli->prepare($SQL))) {
        echo "PF: Check Existing - Something went wrong";
    }

    if (!$stmt->bind_param("s", $code)) {
        echo "BF: Check Existing - Something went wrong";
    }

    if (!$stmt->execute()) {
        echo "EF: Check Existing - Something went wrong";
    }

    if(!$stmt->bind_result()) {
        $stmt->bind_result($res_name);
    }

    $stmt->fetch();

    if($res_name=='')
    {
        $SQL = "INSERT INTO ". SUBJECT_TABLE. " (code, name) VALUES(?, ?)";

        if (!($stmt = $mysqli->prepare($SQL))) {
            die("PF: Insert New - Something went wrong");
        }

        if (!$stmt->bind_param("ss", $code, $name)) {
            die("BP: Insert New - Something went wrong");
        }

        if (!$stmt->execute()) {
            die("E: Insert New - Please check your inputs");
        }

        $myfile = fopen("../assets/js/json/subject.js", "w");
        $txt = "var subjectlist;\nsubjectlist = {\n";
        fwrite($myfile, $txt);

        $SQL = "SELECT code, name FROM " . SUBJECT_TABLE;
        $res = $mysqli->query($SQL);

        if($res->num_rows>0)
        {
            $line = 0;
            while ($row = $res->fetch_assoc()){

                if($line==0)
                {
                    $txt = "\"" . $row["code"] . "\" : \"" . $row["name"] . "\"";
                    fwrite($myfile, $txt);
                    $line++;
                    continue;
                }
                else
                {
                    $txt = ",\n\"" . $row["code"] . "\" : \"" . $row["name"] . "\"";
                    fwrite($myfile, $txt);
                }
            }
        }
        $txt = "\n};";
        fwrite($myfile, $txt);
        fclose($myfile);
        $msg =  "The book is added";
    }
    else
    {
        $msg =  "This book is already available";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <link rel="shortcut icon" href="../favicon.ico" >
    <link rel="icon" href="../animated_favicon.gif" type="image/gif" >

    <title>UseIt - Add Book Details</title>

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="../assets/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="../assets/css/main.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>

<?php require_once ('./imports/menu.html');?>

<br>
<!--UPLOAD FORM-->
<div class="center">
    <h3>Add a book</h3>
    <a href="viewBook.php" class="btn">View All Books</a>
    <div class="input-field col s10 offset-s1 m6 offset-m3 l4 offset-l4 xl4 offset-xl4">
        <strong><?php echo $msg ?></strong>
    </div>
</div>
<br><br>
<div class="container">
    <div class="row">
        <form id="signup-form" action="<?php $_SERVER['PHP_SELF'] ?>" method="post" class="col s12">

            <fieldset>

                <legend>Book Details</legend>


                <div class="input-field col s12 m12 l6 xl6">
                    <i class="material-icons prefix">looks_one</i>
                    <input id="code" name="code" list="sublist" type="text" class="validate" data-length="7" minlength="4" maxlength="7" pattern="[A-Z0-9$]{2,7}" required>
                    <label for="code" data-error="Validation failed" data-success="Validation Successful">Subject Code</label>
                </div>
                <datalist id="sublist">
                </datalist>

                <div class="input-field col s12 m12 l6 xl6">
                    <i class="material-icons prefix">book</i>
                    <input id="name" name="name" list="sublistname" type="text" class="validate" data-length="70" maxlength="70" pattern="[A-Za-z ]{10,}" required>
                    <label for="name" data-error="Validation failed" data-success="Validation Successful">Subject Name</label>
                </div>

                <button id="submit" class="btn waves-effect waves-light submit" type="submit" name="submit">Add
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
    document.getElementById("code").value = sessionStorage.getItem("code");
    sessionStorage.setItem("reset", true);
    document.getElementById("code").onblur = function () {
        var code = this.value;
        for(var key in subjectlist)
        {
            if(key === code)
            {
                document.getElementById("name").value=subjectlist[key];
                Materialize.toast("This book is already listed", 4000);
            }

        }
    }
</script>
<script src="../assets/js/jquery-2.1.1.min.js"></script>
<script src="../assets/js/materialize.js"></script>
<script src="../assets/js/main.js"></script>
<script src="../assets/js/localvar.js"></script>
<script>

    $("#code").on('input', function() {
        var input = $(this);
        var start = input[0].selectionStart;
        $(this).val(function (_, val) {
            return val.toUpperCase();
        });
        input[0].selectionStart = input[0].selectionEnd = start;
    });
</script>
</body>
</html>

