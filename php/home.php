<?php
/**
 * Created by PhpStorm.
 * User: ravindra
 * Date: 24/1/18
 * Time: 7:18 PM
 */
require_once('./imports/login-gate.php');

if(isset($_POST["submit"])) {
    $rollno = $_POST['rollno'];
}
$dp="../uploads/dp/" . $rollno .".jpg";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <link rel="shortcut icon" href="../favicon.ico" >
    <link rel="icon" href="../animated_favicon.gif" type="image/gif" >

    <title>UseIt - Homepage</title>

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="../assets/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="../assets/css/main.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="../assets/css/home.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>

<?php require_once ('./imports/menu.html');?>

<div class="cover s12 m12 l12 xl12">
    <div class="top">
        <hr>
        <span id="cover-college" class="college"></span>
        <div><span id="cover-branch" class="branch"></span></div>
    </div>
    <div class="center">
        <span class="dp-container"><img src='../uploads/dp/<?php if(file_exists($dp)){echo $rollno;} else {echo "default";}?>.jpg' alt="Display Picture" class="dp"></span>
        <div><span id="cover-rollno"><?php echo $rollno ?></span></div>
        <div><span id="cover-full-name" class="full_name"></span></div>
    </div>
    <div class="bottom">
        <hr>
    </div>
</div>
<div class="container">
</div>
<br>

<!--  Scripts-->
<!--<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>-->
<script>
    if(sessionStorage.getItem("fullReset")) {
        sessionStorage.removeItem("fullReset");
        alert("Please logout once for resetting local values");
        location.reload(true);
    }

</script>
<script src="../assets/js/jquery-2.1.1.min.js"></script>
<script src="../assets/js/materialize.js"></script>
<script src="../assets/js/main.js"></script>
<script src="../assets/js/localvar.js"></script>

</body>
</html>

