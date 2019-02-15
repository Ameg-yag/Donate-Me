<?php

require_once ('../imports/conn.php');

$mysqli= new mysqli(HOST,USER,PASSWORD,DB);

if(isset($_POST['CreateCollegeTable']))
{
    $SQL = "CREATE TABLE " . COLLEGE_TABLE . "(code CHAR(4) NOT NULL, name VARCHAR(80) NOT NULL, PRIMARY KEY(code))";

    if (!$mysqli->query("DROP TABLE IF EXISTS " . COLLEGE_TABLE ) || !$mysqli->query($SQL)) {
        echo "Table creation failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    echo "College Table Created";
}

if(isset($_POST['AddCollegeTable']))
{
    $SQL = "INSERT INTO " . COLLEGE_TABLE . "(code, name) VALUES (?, ?)";

    if (!($stmt = $mysqli->prepare($SQL))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }

    if (!$stmt->bind_param("ss", $code, $name)) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    $file = new SplFileObject("CollegeList.txt");

    while (!$file->eof())
    {
        $line = $file->fgets();
        list($code, $name) = explode(":", $line);

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
    }

    $file = null;
    $stmt->close();

    echo "College List Added";
}

if(isset($_POST['DeleteCollegeTable']))
{
    $SQL = "DROP TABLE IF EXISTS " . COLLEGE_TABLE;

    if (!$mysqli->query($SQL)) {
        echo "Table deletion failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    echo "College Table Deleted";
}


if(isset($_POST['CreateBranchTable']))
{
    $SQL = "CREATE TABLE " . BRANCH_TABLE . "(id INT(4), code CHAR(2) NOT NULL, name VARCHAR(80) NOT NULL, PRIMARY KEY(id), CONSTRAINT UNIQUE UC_" . BRANCH_TABLE . "(code))";

    if (!$mysqli->query("DROP TABLE IF EXISTS " . BRANCH_TABLE) || !$mysqli->query($SQL)) {
        echo "Table creation failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    echo "Branches Table Created";
}

if(isset($_POST['AddBranchTable']))
{
    $SQL = "INSERT INTO " . BRANCH_TABLE . "(id, name, code) VALUES (?, ?, ?)";

    if (!($stmt = $mysqli->prepare($SQL))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }

    if (!$stmt->bind_param("iss", $id,$code, $name)) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    $file = new SplFileObject("BranchList.txt");

    while (!$file->eof())
    {
        $line = $file->fgets();
        list($id, $code, $name) = explode(":", $line);

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
    }

    $file = null;
    $stmt->close();

    echo "Branch List Added";
}

if(isset($_POST['DeleteBranchTable']))
{
    $SQL = "DROP TABLE IF EXISTS " . BRANCH_TABLE;

    if (!$mysqli->query($SQL)) {
        echo "Table deletion failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    echo "Branches Table Deleted";
}


if(isset($_POST['CreateStudentTable']))
{
    $SQL =
        "CREATE TABLE " . STUDENT_TABLE . "(
rollno CHAR (12) NOT NULL,
fname VARCHAR (70) NOT NULL,
mname VARCHAR (30),
lname VARCHAR (40),
email VARCHAR (60) NOT NULL,
verified BOOL DEFAULT FALSE,
mobile CHAR(10) DEFAULT '9876543210',
dob DATE,
branch CHAR(2) NOT NULL,
college CHAR(4) NOT NULL,
hash VARCHAR(256) NOT NULL,
flag TINYINT DEFAULT 0,
ban BOOL DEFAULT FALSE,
helped_others TINYINT DEFAULT 0,
got_help TINYINT DEFAULT 0,
PRIMARY KEY(rollno),
CONSTRAINT UNIQUE UC_" . STUDENT_TABLE . "(email),
FOREIGN KEY(college) REFERENCES " . COLLEGE_TABLE . "(code),
FOREIGN KEY(branch) REFERENCES " . BRANCH_TABLE . "(code)
)";

    if (!$mysqli->query("DROP TABLE IF EXISTS " . STUDENT_TABLE) || !$mysqli->query($SQL)) {
        echo "Table creation failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    echo "Students Table Created";
}

if(isset($_POST['DeleteStudent']))
{
    $SQL = "TRUNCATE TABLE " . STUDENT_TABLE;

    if (!$mysqli->query($SQL)) {
        echo "Table cleaning failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    echo "Students Table Cleaned";
}

if(isset($_POST['DeleteStudentTable']))
{
    $SQL = "DROP TABLE IF EXISTS " . STUDENT_TABLE;

    if (!$mysqli->query($SQL)) {
        echo "Table deletion failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    echo "Students Table Deleted";
}


if(isset($_POST['CreateSubjectTable']))
{
    $SQL =
        "CREATE TABLE " . SUBJECT_TABLE . "(
code VARCHAR (7) NOT NULL,
name VARCHAR (70) NOT NULL,
PRIMARY KEY(code)
)";

    if (!$mysqli->query("DROP TABLE IF EXISTS " . SUBJECT_TABLE) || !$mysqli->query($SQL)) {
        echo "Table creation failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    echo "Subject Table Created";
}

if(isset($_POST['DeleteSubject']))
{
    $SQL = "TRUNCATE TABLE " . SUBJECT_TABLE;

    if (!$mysqli->query($SQL)) {
        echo "Table cleaning failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    echo "Subject Table Cleaned";
}

if(isset($_POST['DeleteSubjectTable']))
{
    $SQL = "DROP TABLE IF EXISTS " . SUBJECT_TABLE;

    if (!$mysqli->query($SQL)) {
        echo "Table deletion failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    echo "Subject Table Deleted";
}


if(isset($_POST['CreateUploadTable']))
{
    $SQL =
        "CREATE TABLE " . UPLOAD_TABLE . "(
id INT NOT NULL AUTO_INCREMENT,
code VARCHAR(7),
uploader CHAR(12),
type CHAR(1),
location1 VARCHAR(300) NOT NULL,
lat1 FLOAT(10, 6),
lat2 FLOAT(10, 6),
lng1 FLOAT(10, 6),
lng2 FLOAT(10, 6),
location2 VARCHAR(300),
requested BOOL DEFAULT FALSE,
requestedBy CHAR(12),
approved BOOL DEFAULT FALSE,
PRIMARY KEY(id),
FOREIGN KEY(code) REFERENCES " . SUBJECT_TABLE . "(code),
FOREIGN KEY(uploader) REFERENCES " . STUDENT_TABLE. "(rollno),
FOREIGN KEY(requestedBy) REFERENCES " . STUDENT_TABLE. "(rollno)
)";

    if (!$mysqli->query("DROP TABLE IF EXISTS " . UPLOAD_TABLE) || !$mysqli->query($SQL)) {
        echo "Table creation failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    echo "Upload Table Created";
}

if(isset($_POST['DeleteUpload']))
{
    $SQL = "TRUNCATE TABLE " . UPLOAD_TABLE;

    if (!$mysqli->query($SQL)) {
        echo "Table cleaning failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    echo "Upload Table Cleaned";
}

if(isset($_POST['DeleteUploadTable']))
{
    $SQL = "DROP TABLE IF EXISTS " . UPLOAD_TABLE;

    if (!$mysqli->query($SQL)) {
        echo "Table deletion failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    echo "Upload Table Deleted";
}


if(isset($_POST['CreateMessageTable']))
{
    $SQL =
"CREATE TABLE " . MESSAGE_TABLE . "(
id INT AUTO_INCREMENT,
message VARCHAR(1024) NOT NULL,
sender CHAR(12) NOT NULL,
receiver CHAR(12) NOT NULL,
sent_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY(id),
FOREIGN KEY(sender) REFERENCES " . STUDENT_TABLE . "(rollno),
FOREIGN KEY(receiver) REFERENCES " . STUDENT_TABLE. "(rollno)
)";

    if (!$mysqli->query("DROP TABLE IF EXISTS " . MESSAGE_TABLE) || !$mysqli->query($SQL)) {
        echo "Table creation failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    echo "Message Table Created";
}

if(isset($_POST['DeleteMessage']))
{
    $SQL = "TRUNCATE TABLE " . MESSAGE_TABLE;

    if (!$mysqli->query($SQL)) {
        echo "Table cleaning failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    echo "Message Table Cleaned";
}

if(isset($_POST['DeleteMessageTable']))
{
    $SQL = "DROP TABLE IF EXISTS " . MESSAGE_TABLE;

    if (!$mysqli->query($SQL)) {
        echo "Table deletion failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    echo "Message Table Deleted";
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="<?php $_SERVER['PHP_SELF']?>" method="post">
    <h1>College List Table</h1>
    <button name = 'CreateCollegeTable'>Create College Table</button>
    <button name = 'AddCollegeTable'>Add College List To Table</button>
    <button name = 'DeleteCollegeTable'>Delete College Table</button>

    <h1>Branch List Table</h1>
    <button name = 'CreateBranchTable'>Create Branches Table</button>
    <button name = 'AddBranchTable'>Add Branch List To Table</button>
    <button name = 'DeleteBranchTable'>Delete Branch Table</button>
    <br>

    <h1>Students Table</h1>
    <button name = 'CreateStudentTable'>Create Students Table</button>
    <button name = 'DeleteStudent'>Delete All Entries</button>
    <button name = 'DeleteStudentTable'>Delete Students Table</button>

    <h1>Subjects Table</h1>
    <button name = 'CreateSubjectTable'>Create Subjects Table</button>
    <button name = 'DeleteSubject'>Delete All Entries</button>
    <button name = 'DeleteSubjectTable'>Delete Subjects Table</button>

    <h1>Upload Table</h1>
    <button name = 'CreateUploadTable'>Create Uploads Table</button>
    <button name = 'DeleteUpload'>Delete Upload Entries</button>
    <button name = 'DeleteUploadTable'>Delete Uploads Table</button>

    <h1>Messages Table</h1>
    <button name = 'CreateMessageTable'>Create Messages Table</button>
    <button name = 'DeleteMessage'>Delete All Messages</button>
    <button name = 'DeleteMessageTable'>Delete Messages Table</button>

</form>

</body>
</html>
