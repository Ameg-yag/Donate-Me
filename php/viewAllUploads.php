<?php
/**
 * Created by PhpStorm.
 * User: ravindra
 * Date: 24/1/18
 * Time: 7:18 PM
 */
require_once('./imports/login-gate.php');

if(isset($_GET['rollno'])){

    require_once('./imports/conn.php');
    require_once ('./imports/validation.php');

    $user = test_input($_GET['rollno']);
    $dp="../uploads/dp/" . $user . ".jpg";

    if(!validateRollNo($user))
    {
        die("Something went wrong");
    }

    $SQL = "
SELECT " .  COLLEGE_TABLE . ".name,
" .  BRANCH_TABLE . ".name,
" .  STUDENT_TABLE . ".fname,
" .  STUDENT_TABLE . ".mname,
" .  STUDENT_TABLE . ".lname,
" .  STUDENT_TABLE . ".ban,
" .  UPLOAD_TABLE . "code
FROM " .  COLLEGE_TABLE . " 
INNER JOIN " .  STUDENT_TABLE . " ON " .  COLLEGE_TABLE . ".code=" .  STUDENT_TABLE . ".college
INNER JOIN " .  BRANCH_TABLE . " ON " .  STUDENT_TABLE . ".branch=" .  BRANCH_TABLE . ".code
INNER JOIN " .  UPLOAD_TABLE. " ON " .  STUDENT_TABLE . ".rollno=" .  UPLOAD_TABLE. ".uploader
WHERE " .  STUDENT_TABLE . ".rollno=?";
    echo $SQL;

    if (!($stmt = $mysqli->prepare($SQL))) {
        echo "PF: User Information Retrieval Failed";
    }

    if (!$stmt->bind_param("s", $user)) {
        echo "BF: User Information Retrieval Failed";
    }

    if (!$stmt->execute()) {
        echo "EF: User Information Retrieval Failed";
    }

    if(!$stmt->bind_result()) {
        $stmt->bind_result($college, $branch, $fname, $mname, $lname, $ban);
    }

    $stmt->fetch();
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

    <title>UseIt - User Information</title>

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="../assets/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="../assets/css/main.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="../assets/css/profile.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>

<div class="cover s12 m12 l12 xl12">
    <div class="top">
        <hr>
        <span><?php echo $college ?></span>
        <div><span><?php echo $branch ?></span></div>
    </div>
    <div class="center">
        <span class="dp-container"><img src='../uploads/dp/<?php if(file_exists($dp)){echo $user;} else {echo "default";}?>.jpg' alt="Display Picture" class="dp"></span>
        <div><span id="cover-rollno"><?php echo $user?></span></div>
        <div><span id="cover-full-name"><?php echo $fname . " " .$mname . " " .$lname ?></span></div>
    </div>
    <div class="bottom">
        <hr>
    </div>
</div>
<br>

<!--  Scripts-->
<!--<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>-->
<script src="../assets/js/jquery-2.1.1.min.js"></script>
<script src="../assets/js/materialize.js"></script>
<script src="../assets/js/main.js"></script>
</body>
</html>

