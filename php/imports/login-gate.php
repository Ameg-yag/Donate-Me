<?php
/**
 * Created by PhpStorm.
 * User: ravindra
 * Date: 25/1/18
 * Time: 1:20 PM
 */
session_start();
session_regenerate_id(true);

if($_COOKIE['ban'])
{
  header('location:../html/banned2.html');
  die();
}

if (($_SESSION['time'] + 3600 < time()) || ($_SESSION['login'] !== md5($_SERVER['HTTP_USER_AGENT']))) {
  session_destroy();
  header('Location: ./login.php');
  die();
} else {
  $_SESSION['time'] = time();
}

if (isset($_GET['logout'])){
  session_destroy();
  header('Location: /index.html');
  die();
}

$email = $_SESSION['email'];
$rollno = $_SESSION['rollno'];