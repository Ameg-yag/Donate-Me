 <?php
/**
 * Created by PhpStorm.
 * User: ravindra
 * Date: 24/1/18
 * Time: 7:18 PM
 */
require_once ('./imports/validation.php');
require_once ('./imports/image-meta-remover.php');
require_once ('./imports/login-gate.php');
require_once ('./imports/module_info.php');
require_once ('./imports/conn.php');

$destination = '../uploads/dp/';

if(isset($_POST['submit']))
{
  if($_FILES['image']['name']!=='')
  {
    if(validateImage($_FILES['image']))
    {
      if(move_uploaded_file($_FILES['image']['tmp_name'],$destination . $rollno . ".jpg"))
      {
        if (phpHasImagick())
        {
          stripMetaImagick($destination . $rollno . ".jpg");
        }
        elseif (phpHasGD())
        {
          stripMetaGD($destination . $rollno . ".jpg");
        }
      }
    }
  }
  $fname = test_input($_POST['fname']);
  $mname = test_input($_POST['mname']);
  $lname = test_input($_POST['lname']);
  $mobile = test_input($_POST['mobile']);
//  $date = test_input($_POST['date']);
  $date = "1995/04/04/";
  $branch="CS";

  if((validateName($fname) && checkEmpty($fname)) && ((!checkEmpty($mname)) || validateName($mname)) && ((!checkEmpty($mname)) || validateName($lname)) && ((!checkEmpty($mname)) || validateMobile($mobile)))
  {
    $mysqli= new mysqli(HOST,USER,PASSWORD,DB);

    $SQL = "UPDATE " . STUDENT_TABLE . " SET fname = ?, mname = ?, lname = ?, branch = ?, mobile = ?, dob = ? WHERE rollno = ?";

    if (!($stmt = $mysqli->prepare($SQL))) {
      die("PF: Something went wrong");
    }

    if (!$stmt->bind_param("sssssss", $fname, $mname, $lname, $branch, $mobile, $date, $rollno)) {
      die("BP: Something went wrong");
    }

    if (!$stmt->execute()) {
      die("E: Please check your inputs");
    }

    $stmt->close();

    header('Location: ./home.php');
    die();
  }
  else
  {
    die("Invalid Input");
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

  <title>UseIt - Edit Profile</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="../assets/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="../assets/css/main.css" type="text/css" rel="stylesheet" media="screen,projection"/>

</head>
<body>
<?php require_once ('./imports/menu.html');?>

<br>
<div class="container">
  <h4>Edit Profile</h4>
  <form id="edit-form" action="<?php $_SERVER['PHP_SELF'] ?>" method="post" class="col s12 m12 l12 xl12" enctype="multipart/form-data">
    <fieldset>
      <legend>Personal Details</legend>
      <div class="row">
        <div class="input-field col s12 m12 l4 xl4">
          <i class="material-icons prefix">account_circle</i>
          <input id="fname" name="fname" type="text" value="" class="validate" data-length="30" minlength="2" maxlength="30" pattern="[A-Z a-z]{2,30}" required autocomplete='given-name'>
          <label for="fname" data-error="Validation failed" data-success="Validation Successful">First Name</label>
        </div>

        <div class="input-field col s12 m12 l4 xl4">
          <i class="material-icons prefix">account_circle</i>
          <input id="mname" name="mname" type="text" value="" class="validate" data-length="30" minlength="2" maxlength="30" pattern="[A-Za-z]{2,30}" placeholder="Optional" autocomplete='additional-name'>
          <label for="mname" data-error="Validation failed" data-success="Validation Successful">Middle Name</label>
        </div>

        <div class="input-field col s12 m12 l4 xl4">
          <i class="material-icons prefix">account_circle</i>
          <input id="lname" name="lname" type="text" value="" class="validate" data-length="30" minlength="2" maxlength="30" pattern="[A-Z a-z]{2,30}" placeholder="Optional" autocomplete='family-name'>
          <label for="lname" data-error="Validation failed" data-success="Validation Successful">Last Name</label>
        </div>
      </div>

      <div class="row">
        <div class="input-field col s12 m12 l4 xl4">
          <i class="material-icons prefix">mail</i>
          <input id="email" name="email" type="email" value="<?php echo $email ?>" class="validate" data-length="50" maxlength="50" disabled autocomplete='email'>
          <label for="email" data-error="Validation failed" data-success="Validation Successful"></label>
        </div>

        <div class="input-field col s12 m12 l4 xl4">
          <i class="material-icons prefix">account_box</i>
          <input id="mobile" name="mobile" type="tel" class="validate" data-length="10" minlength="10" maxlength="10" pattern="[0-9]{10}" value="<?php echo $_COOKIE['mobile'] ?>" placeholder="Required" autocomplete='tel' required>
          <label for="mobile" data-error="Validation failed" data-success="Validation Successful">Mobile</label>
        </div>

        <div class="input-field col s12 m12 l4 xl4">
          <i class="material-icons prefix">date_range</i>
          <input type="text" class="datepicker" name="date" id="date" value="<?php echo $_COOKIE['dob'] ?>" >
          <label for="date">Date of Birth</label>
        </div>
      </div>

      <div class="row">
        <div class="file-field input-field s12 m12 l4 xl4">
          <div class="btn file-upload">
            <span>Display Picture</span>
            <input type="file" accept=".jpg, .jpeg" name="image" id="image" placeholder="Only 512KB or less JPG is allowed">
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text" placeholder="Only 512KB or less JPG is allowed">
          </div>
        </div>
      </div>

      <button class="btn waves-effect waves-light submit" type="submit" name="submit">Submit
      </button>

      <a href="./home.php"><input type="button" class="btn waves-effect waves-light" value="cancel">
        </input></a>

    </fieldset>
  </form>
</div>

<!--  Scripts-->
<!--<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>-->
<script src="../assets/js/jquery-2.1.1.min.js"></script>
<script src="../assets/js/materialize.js"></script>
<script src="../assets/js/edit-profile.js"></script>
<script src="../assets/js/localvar.js"></script>
<script src="../assets/js/main.js"></script>
</body>
</html>

