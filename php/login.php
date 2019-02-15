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

session_start();
session_regenerate_id(true);

if(isset($_POST["submit"]))
{
  $email = $_POST['email'];
  $password = $_POST['password'];

  require_once ('./imports/validation.php');

  if (!validateEmail($email)) {
    die("Email address '$email' is considered invalid.\n");
  }

  require_once ("./imports/conn.php");

  $SQL = "
SELECT " .  COLLEGE_TABLE . ".name,
" .  BRANCH_TABLE . ".name,
" .  STUDENT_TABLE . ".fname,
" .  STUDENT_TABLE . ".mname,
" .  STUDENT_TABLE . ".lname,
" .  STUDENT_TABLE . ".rollno,
" .  STUDENT_TABLE . ".mobile,
" .  STUDENT_TABLE . ".flag,
" .  STUDENT_TABLE . ".hash,
" .  STUDENT_TABLE . ".dob,
" .  STUDENT_TABLE . ".ban,
" .  STUDENT_TABLE . ".flag,
" .  STUDENT_TABLE . ".helped_others,
" .  STUDENT_TABLE . ".got_help
FROM " .  COLLEGE_TABLE . " 
INNER JOIN " .  STUDENT_TABLE . " ON " .  COLLEGE_TABLE . ".code=" .  STUDENT_TABLE . ".college
INNER JOIN " .  BRANCH_TABLE . " ON " .  STUDENT_TABLE . ".branch=" .  BRANCH_TABLE . ".code
WHERE " .  STUDENT_TABLE . ".email=?";

  if (!($stmt = $mysqli->prepare($SQL))) {
    echo "PF: Login Failed";
  }

  if (!$stmt->bind_param("s", $email)) {
    echo "BF: Login Failed";
  }

  if (!$stmt->execute()) {
    echo "EF: Login Failed";
  }

  if(!$stmt->bind_result()) {
    $stmt->bind_result($college, $branch, $fname, $mname, $lname, $rollno, $mobile, $flag, $hash, $dob, $ban, $flag, $helped_others, $got_help);
  }
  $stmt->fetch();
  $stmt->close();

  if($ban==true)
  {
    header('location: ../html/banned.html');
    setcookie("ban", $ban, time() + (30 * 24 * 60 * 60), NULL,NULL,NULL, TRUE);
    die();
  }

  if(password_verify($password, $hash)){
    $_SESSION['login'] = md5($_SERVER['HTTP_USER_AGENT']);
    $_SESSION['email'] = $email;
    $_SESSION['rollno'] = $rollno;
    setcookie("name", "$fname $mname $lname", time()+1800);
    setcookie("fname", $fname, time()+1800, NULL,NULL,NULL, TRUE);
    setcookie("mname", $mname, time()+1800, NULL,NULL,NULL, TRUE);
    setcookie("lname", $lname, time()+1800, NULL,NULL,NULL, TRUE);
    setcookie("branch", $branch, time()+1800, NULL,NULL,NULL, TRUE);
    setcookie("college", $college, time()+1800, NULL,NULL,NULL, TRUE);
    setcookie("dob", $dob, time()+1800, NULL,NULL,NULL, TRUE);
    setcookie("mobile", $mobile, time()+1800, NULL,NULL,NULL, TRUE);
    setcookie("ban", $ban, time()+1800, NULL,NULL,NULL, TRUE);
    setcookie("flag", $flag, time()+1800, NULL,NULL,NULL, TRUE);
    setcookie("helped_others", $helped_others, time()+1800, NULL,NULL,NULL, TRUE);
    setcookie("got_help", $got_help, time()+1800, NULL,NULL,NULL, TRUE);

    $_SESSION['time'] = time();
    header('Location: ./localSetting.php');
    die();
  }
  else{
    $msg =  "Login failed: Details Incorrect";
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

  <title>UseIt - Login</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="../assets/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="../assets/css/main.css" type="text/css" rel="stylesheet" media="screen,projection"/>

</head>
<body>

<nav>
  <div class="nav-wrapper">
    <a href="#" class="brand-logo">UseIt<i class="material-icons right">event_note</i></a>
    <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
    <ul class="right hide-on-med-and-down">
      <li><a href="../index.html">Home</a></li>
      <li><a href="../php/sign-up.php">Register</a></li>
      <li><a href="../html/gallery.html">Gallery</a></li>
      <li><a href="../html/about.html">About Us</a></li>
      <li><a href="../html/contacts.html">Contacts</a></li>
    </ul>
    <ul class="side-nav" id="mobile-demo">
      <li><a href="../index.html">Home</a></li>
      <li><a href="../php/sign-up.php">Register</a></li>
      <li><a href="../html/gallery.html">Gallery</a></li>
      <li><a href="../html/about.html">About Us</a></li>
      <li><a href="../html/contacts.html">Contacts</a></li>
    </ul>
  </div>
</nav>

<br><br>

<!--Log In FORM-->
<div class="container">
  <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" class="">
    <div class="row">
      <fieldset>
        <legend>Login Details</legend>

        <div class="input-field col s10 offset-s1 m6 offset-m3 l4 offset-l4 xl4 offset-xl4">
          <i class="material-icons prefix">mail</i>
          <input id="email" name="email" type="email" class="validate" data-length="25" maxlength="30" required>
          <label for="email" data-error="Validation failed" data-success="Validation Successful">Email</label>
        </div>

        <div class="input-field col s10 offset-s1 m6 offset-m3 l4 offset-l4 xl4 offset-xl4">
          <i class="material-icons prefix">enhanced_encryption</i>
          <input id="password" name="password" type="password" class="validate" data-length="70" minlength="8" maxlength="70" autocomplete="current-password" required>
          <label for="password" data-error="Validation failed" data-success="Validation Successful">Password</label>
        </div>

        <div class="input-field col s10 offset-s1 m6 offset-m3 l4 offset-l4 xl4 offset-xl4">
          <strong><?php echo $msg ?></strong>
        </div>

        <div class="input-field col s10 offset-s1 m6 offset-m3 l4 offset-l4 xl4 offset-xl4">
          <button class="btn waves-effect waves-light right" type="submit" name="submit">Submit
            <i class="material-icons right">send</i>
          </button>
        </div>
      </fieldset>
    </div>

  </form>
</div>
<!--  Scripts-->
<!--<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>-->
<script src="../assets/js/jquery-2.1.1.min.js"></script>
<script src="../assets/js/materialize.min.js"></script>
<script src="../assets/js/main.js"></script>
</body>
</html>
