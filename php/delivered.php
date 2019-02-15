<?php
/**
 * Created by PhpStorm.
 * User: ravindra
 * Date: 4/2/18
 * Time: 2:09 PM
 */

require_once ('./imports/login-gate.php');
require_once ('./imports/validation.php');
require_once ('./imports/conn.php');

$id = test_input($_GET['id']);
$yes = 1;
$approved = 1;

$SQL = "DELETE FROM " . UPLOAD_TABLE . " WHERE id = ? AND requestedBy = ? AND approved = ?";

if (!($stmt = $mysqli->prepare($SQL))) {
    die("PF: Something went wrong");
}

if (!$stmt->bind_param("isi", $id, $rollno, $approved)) {
    die("BP: Something went wrong");
}

if (!$stmt->execute()) {
    die("E: Please check your inputs");
}
echo "Record have been removed successfully";
setcookie("CHARITY");
$stmt->close();
