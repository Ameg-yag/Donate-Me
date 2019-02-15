<?php
/**
 * Created by PhpStorm.
 * User: ravindra
 * Date: 20/1/18
 * Time: 12:30 AM
 * @param $name
 * @return bool
 */

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

//if($strTemp !== '')

function checkEmpty($string){
  return (!($string == ''));
}

function validateName($name){
  return ctype_alpha(str_replace(' ', '', $name));
}

function validateSubjectCode($code){
  return ctype_alnum($code);
}

function validateEmail($email)
{
  return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validateMobile($mobile)
{
  return ctype_digit($mobile);
}

function validateRollNo($rollno){
  return preg_match('/^\d{4}[a-zA-Z]{2}\d{6}$/',$rollno);
}

function checkFileUploadedName ($filename)
{
  return (preg_match("`^[-0-9A-Z_\.]+$`i",$filename));
}

function validateImage($file){

  $errors= array();
  $file_size = $file['size'];
  $file_type = mime_content_type($file['tmp_name']);
  $file_ext=strtolower(end(explode('.',$file['name'])));

  $expensions= array("jpeg","jpg");

  if(in_array($file_ext,$expensions)=== false){
    $errors[] = "extension not allowed, please choose a JPG/JPEG file.";
  }

  if(!($file_type=='image/jpeg'))
  {
    $errors[] = "This is not an image";
  }

  if($file_size > 512000) {
    $errors[]='File size must be less than 512 KB';
  }

  if(!(empty($errors)==true)) {
    foreach ($errors as $line => $error)
    {
      echo "<br>" . $error;

    }
    die();
  }
  return true;
}
