<?php
/**
 * Created by PhpStorm.
 * User: Ravindra Sisodia
 * Date: 8/1/18
 * Time: 8:24 PM
 */

if($_COOKIE['ban'])
{
  header('location:../html/banned2.html');
  die();
}

if(isset($_POST["submit"]))
{
  require_once ('./imports/validation.php');
  require_once ('./imports/conn.php');

  $full_name = test_input($_POST['full_name']);
  $email = test_input($_POST['email']);
  $rollno = test_input($_POST['rollno']);

  $password = $_POST['password'];
  $passwordr = $_POST['password_repeat'];

  $hash="";
  $branch ="";
  $college="";

  //Processing Data
  if(!(validateName($full_name)))
  {
    die("Name contains invalid characters");
  }

  $f="";
  $m="";
  $l="";
  $name = explode(" ", $full_name);


  if (count($name)<3 || count($name)==1)
  {
    $f = $full_name;
  }

  if (count($name)==2)
  {
    list($f, $l) = $name;
  }

  if (count($name)==3)
  {
    list($f, $m, $l) = $name;
  }

  if (!validateEmail($email)) {
    die("Email address '$email' is considered invalid.\n");
  }

  if($password==$passwordr){
    $hash = password_hash($password, PASSWORD_DEFAULT);
  }
  else{
    die("password didn't match.\n");
  }

  if(!(validateRollNo($rollno)))
  {
    die("Roll number contains invalid characters");
  }
  else{
    $rollno = strtoupper($rollno);
    $college = substr($rollno,0,4);
    $branch = strtoupper(substr($rollno,4,2));
  }

  $mysqli= new mysqli(HOST,USER,PASSWORD,DB);

  $SQL = "INSERT INTO " . STUDENT_TABLE . "(rollno, fname, mname, lname, email, branch, college, hash) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

  if (!($stmt = $mysqli->prepare($SQL))) {
    die("PF: Something went wrong");
  }

  if (!$stmt->bind_param("ssssssss", $rollno, $f, $m, $l, $email, $branch, $college, $hash)) {
    die("BP: Something went wrong");
  }

  if (!$stmt->execute()) {
    die("E: Please check your inputs");
  }

  $stmt->close();

  ob_start();
  header('Location: ./login.php');
  ob_end_flush();
  die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>

  <link rel="shortcut icon" href="../favicon.ico" >
  <link rel="icon" href="../animated_favicon.gif" type="image/gif" >

  <title>UseIt - Register</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="../assets/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="../assets/css/main.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <script src="../assets/js/json/college.js"></script>

</head>
<body>

<nav>
  <div class="nav-wrapper">
    <a href="#" class="brand-logo">UseIt<i class="material-icons right">event_note</i></a>
    <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
    <ul class="right hide-on-med-and-down">
      <li><a href="../index.html"><i class="material-icons right">home</i></a></li>
      <li><a href="login.php"><i class="material-icons right">insert_emoticon</i>Login</a></li>
      <li><a href="../html/gallery.html">Gallery</a></li>
      <li><a href="../html/about.html">About Us</a></li>
      <li><a href="../html/contacts.html">Contacts</a></li>
    </ul>
    <ul class="side-nav" id="mobile-demo">
      <li><a href="login.php">Login</a></li>
      <li><a href="sign-up.php">Register</a></li>
      <li><a href="../html/gallery.html">Gallery</a></li>
      <li><a href="../html/about.html">About Us</a></li>
      <li><a href="../html/contacts.html">Contacts</a></li>
    </ul>
  </div>
</nav>

<br><br>
<!--SIGN UP FORM-->
<div class="container">
  <div class="row">
    <form id="signup-form" action="<?php $_SERVER['PHP_SELF'] ?>" method="post" class="col s12">
      <fieldset>
        <legend>Personal Details</legend>

        <div class="input-field col s12 m12 l6 xl6">
          <i class="material-icons prefix">account_circle</i>
          <input id="full_name" name="full_name" type="text" class="validate" data-length="30" minlength="2" maxlength="30" pattern="[A-Z a-z]{2,30}" required>
          <label for="full_name" data-error="Validation failed" data-success="Validation Successful">Full Name</label>
        </div>

        <div class="input-field col s12 m12 l6 xl6">
          <i class="material-icons prefix">mail</i>
          <input id="email" name="email" type="email" class="validate" data-length="50" maxlength="50" required>
          <label for="email" data-error="Validation failed" data-success="Validation Successful">Email</label>
        </div>

        <div class="input-field col s12 m12 l6 xl6">
          <i class="material-icons prefix">enhanced_encryption</i>
          <input id="password" name="password" type="password" class="validate" data-length="72" minlength="8" maxlength="72" required>
          <label for="password">Password</label>
          <p id="feedback"></p>

        </div>

        <div class="input-field col s12 m12 l6 xl6">
          <i class="material-icons prefix">enhanced_encryption</i>
          <input id="password_repeat" name="password_repeat" type="password" class="validate" data-length="72" minlength="8" maxlength="72" required>
          <label for="password_repeat" data-error="Validation failed" data-success="Validation Successful">Repeat Password</label>
        </div>

      </fieldset>
      <br>

      <fieldset>
        <legend>Academic Details</legend>

        <div class="input-field col s12 m12 l6 xl6">

          <i class="material-icons prefix">format_list_numbered</i>
          <input id="rollno" name="rollno" type="text" class="validate" data-length="12" min="12" max="12" pattern="\d{4}[a-zA-Z]{2}\d{6}" required>
          <label for="rollno" data-error="Validation failed" data-success="Validation Successful">Roll. No</label>
        </div>

        <div class="input-field col s12 m12 l6 xl6">
          <i class="material-icons prefix">school</i>
          <input id="college" name="college" type="text" placeholder="College name will autocomplete" disabled>
          <label for="college" data-error="Validation failed" data-success="Validation Successful" >College Name</label>
        </div>

        <p id="oops"></p>

        <button class="btn waves-effect waves-light right" type="submit" name="submit">Submit
          <i class="material-icons right">send</i>
        </button>
      </fieldset>
    </form>
  </div>
</div>
<!--  Scripts-->
<!--<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>-->
<script src="../assets/js/jquery-2.1.1.min.js"></script>
<script src="../assets/js/materialize.js"></script>
<script src="../assets/js/main.js"></script>
<script src="../assets/js/zxcvbn.js"></script>
<script src="../assets/js/sign-up.js"></script>

<!-- Modal Structure -->
<div id="passgd" class="modal modal-fixed-footer">
  <div class="modal-content">
    <h4>Password guidlines</h4>
    <p>Minimum 8 characters</p>
    <p>Must score 4</p>
    <p>Password must match when you repeat</p>
  </div>
  <div class="modal-footer">
    <a href="#" class="modal-action modal-close waves-effect waves-green btn-flat ">Okay</a>
  </div>
</div>
</body>
</html>
