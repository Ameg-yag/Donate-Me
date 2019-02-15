<?php
/**
 * Created by PhpStorm.
 * User: ravindra
 * Date: 24/1/18
 * Time: 7:18 PM
 */
require_once ('./imports/login-gate.php');


if (isset($_POST['submit'])){
  require_once ('./imports/validation.php');
  require_once ('./imports/conn.php');

  $msg = test_input($_POST['msg']);
  $receiver = test_input($_POST['receiver']);

  if(!validateRollNo($receiver))
  {
    die("Invalid Input");
  }

  $mysqli= new mysqli(HOST,USER,PASSWORD,DB);

  $SQL = "INSERT INTO " . MESSAGE_TABLE . "(message, sender, receiver) VALUES (?, ?, ?)";

  if (!($stmt = $mysqli->prepare($SQL))) {
    $log = "PF: Something went wrong";
  }

  if (!$stmt->bind_param("sss", $msg, $rollno, $receiver)) {
    $log = "BF: Something went wrong";
  }

  if (!$stmt->execute()) {
    $log = "EF: Something went wrong";
  }
  else{
    //TODO: Mail Receiver About Message
    $log = "Message Sent";
  }

  $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>

  <link rel="shortcut icon" href="../favicon.ico" >
  <link rel="icon" href="../animated_favicon.gif" type="image/gif" >

  <title>UseIt - Send Message</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="../assets/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="../assets/css/main.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
<?php require_once ('./imports/menu.html');?>
<br><br>
<!--UPLOAD FORM-->
<div class="container">
  <div class="row">
    <div class="center">
      <h3>Send a message</h3>
      <a href="./viewMessage.php" class="btn">View Received Messages</a>
      <div class="input-field col s12 m12 l12 xl12 ">
        <strong><?php echo $log ?></strong>
      </div>
    </div>
    <br><br>
    <form id="signup-form" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
      <fieldset>
        <legend>Message details</legend>

        <div class="input-field col s10 offset-s1 m18 offset-m2 l6 offset-l3 xl6 offset-xl3">
          <i class="material-icons prefix">book</i>
          <input id="receiver" name="receiver" type="text" class="validate" data-length="12" maxlength="12" pattern="\d{4}[a-zA-Z]{2}\d{6}" required>
          <label for="receiver" data-error="Validation failed" data-success="Validation Successful">Receiver's Roll No</label>
        </div>

        <div class="input-field col s10 offset-s1 m18 offset-m2 l6 offset-l3 xl6 offset-xl3">
          <i class="material-icons prefix">looks_one</i>
          <textarea id="msg" name="msg" class="materialize-textarea validate" data-length="1024" minlength="2" maxlength="1024" required></textarea>
          <label for="msg">Message</label>
        </div>

        <div class="input-field col s10 offset-s1 m18 offset-m2 l6 offset-l3 xl6 offset-xl3">
          <br>
          <button class="btn waves-effect waves-light submit" type="submit" name="submit">Send
          </button>
          <a href="./home.php"><input type="button" class="btn waves-effect waves-light" value="cancel">
            </input></a>
        </div>

      </fieldset>
    </form>
  </div>
</div>

<!--  Scripts-->
<!--<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>-->
<script src="../assets/js/jquery-2.1.1.min.js"></script>
<script src="../assets/js/materialize.js"></script>
<script src="../assets/js/main.js"></script>
<script src="../assets/js/localvar.js"></script>
<script>
    document.getElementById("receiver").value = sessionStorage.getItem("who");
    sessionStorage.removeItem("who");
</script>
</body>
</html>

