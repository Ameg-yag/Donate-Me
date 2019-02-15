<?php
/**
 * Created by PhpStorm.
 * User: ravindra
 * Date: 15/1/18
 * Time: 5:52 PM
 */
 
//Localhost
//define("HOST", "localhost");
//define("USER","root");
//define("PASSWORD","9098109892");
//define("DB","UseIt");

//Hostinger
//define("HOST", "mysql.hostinger.in");
//define("USER","u637286506_useit");
//define("PASSWORD","9098109892Ut");
//define("DB","u637286506_useit");

//Googiehost
//define("HOST", "206.72.206.122");
//define("USER","ravindra_UseIt");
//define("PASSWORD","9098109892@Ut");
//define("DB","ravindra_UseIt");

//000webhost
//define("HOST", "databases.000webhost.com");
//define("HOST", "localhost");
//define("USER","id4645632_ravindra");
//define("PASSWORD","9098109892@Ut");
//define("DB","id4645632_useit");

//InfinityFree
define("HOST", "sql302.epizy.com");
define("USER","epiz_21547961");
define("PASSWORD","9098109892Ie");
define("DB","epiz_21547961_UseIt");

//Tables
define("COLLEGE_TABLE","CollegesBE");
define("BRANCH_TABLE","BranchesBE");
define("STUDENT_TABLE","StudentsBE");
define("SUBJECT_TABLE","SubjectsBE");
define("MESSAGE_TABLE","MessagesBE");
define("UPLOAD_TABLE","UploadsBE");

$mysqli= new mysqli(HOST,USER,PASSWORD,DB);
