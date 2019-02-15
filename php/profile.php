<?php
/**
 * Created by PhpStorm.
 * User: ravindra
 * Date: 24/1/18
 * Time: 7:18 PM
 */
require_once('./imports/login-gate.php');

if(isset($_GET['rollno'])){

    $requested = 0;

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
" . BRANCH_TABLE . ".name,
" . STUDENT_TABLE . ".fname,
" . STUDENT_TABLE . ".mname,
" . STUDENT_TABLE . ".lname,
" . STUDENT_TABLE . ".ban,
" . UPLOAD_TABLE . ".id,
" . UPLOAD_TABLE . ".code,
" . UPLOAD_TABLE . ".type,
" . UPLOAD_TABLE . ".requested 
FROM " .  COLLEGE_TABLE . " 
INNER JOIN " .  STUDENT_TABLE . " ON " .  COLLEGE_TABLE . ".code=" .  STUDENT_TABLE . ".college
INNER JOIN " .  BRANCH_TABLE . " ON " .  STUDENT_TABLE . ".branch=" .  BRANCH_TABLE . ".code
INNER JOIN " .  UPLOAD_TABLE. " ON " .  STUDENT_TABLE . ".rollno=" .  UPLOAD_TABLE . ".uploader
WHERE " .  STUDENT_TABLE . ".rollno = ? AND " . UPLOAD_TABLE . ".uploader = ? AND " . UPLOAD_TABLE . ".requested = ?";

    if (!($stmt = $mysqli->prepare($SQL))) {
        echo "PF: User Information Retrieval Failed";
    }

    if (!$stmt->bind_param("ssi", $user, $user, $requested)) {
        echo "BF: User Information Retrieval Failed";
    }

    if (!$stmt->execute()) {
        echo "EF: User Information Retrieval Failed";
    }

    $result = mysqli_stmt_get_result($stmt);

    $response = array();
    $posts = array();

    while ($row = mysqli_fetch_array($result)){
        $college = $row[0];
        $branch = $row[1];
        $fname = $row[2];
        $mname  = $row[3];
        $lname  = $row[4];

        $id = $row['id'];
        $code = $row['code'];
        $type = $row['type'];
        $posts[] = array('id'=> $id, 'code'=> $code, 'type'=>$type);
    }

    $response['posts'] = $posts;
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
<br><br><br><br>
<div class="container">
    <fieldset id="result">
        <legend>
            All uploads...
        </legend>
    </fieldset>
</div>
<br>

<!--  Scripts-->
<!--<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>-->
<script>
    var subjectJSON = <?php echo json_encode($response); ?>;
    if(subjectJSON!==null)
    {
        var subject = subjectJSON.posts;

        if(subject.length)
        {
            result.style.display = "block";
        }
        else {
            result.style.display = "block";
            var h5 = document.createElement("h5");
            h5.innerText = "No books are available now...";
            result.appendChild(h5);
        }

        for(var i = 0; i < subject.length; i++) {
            var p1 = document.createElement("div");
            var p2 = document.createElement("div");
            var p3 = document.createElement("div");
            var title = document.createElement("span");
            var br1  = document.createElement("br");
            var br2  = document.createElement("br");
            var br3  = document.createElement("br");
            var br4  = document.createElement("br");
            var br5  = document.createElement("br");
            var br6  = document.createElement("br");
            var br7  = document.createElement("br");
            var br8  = document.createElement("br");
            var br9  = document.createElement("br");
            var br10  = document.createElement("br");
            var br11  = document.createElement("br");
            var br12  = document.createElement("br");
            var br13  = document.createElement("br");
            var br14  = document.createElement("br");
            var strongBy  = document.createElement("strong");
            var strongLocation1  = document.createElement("strong");
            var strongLocation2  = document.createElement("strong");
            var strongType  = document.createElement("strong");
            var spanUploader  = document.createElement("span");
            var spanName  = document.createElement("span");
            var spanLocation1  = document.createElement("span");
            var spanLocation2  = document.createElement("span");
            var spanType  = document.createElement("span");
            var p4 = document.createElement("div");
            var request = document.createElement("a");

            title.innerText = subject[i].code;
            strongBy.innerText = "By";
            strongLocation1.innerText = "Location 1";
            strongLocation2.innerText = "Location 2";
            spanName.innerText = subject[i].name;
            spanLocation1.innerText = subject[i].location1;
            spanLocation2.innerText = subject[i].location2;
            strongType.innerText = "Type";
            spanUploader.innerText = subject[i].uploader;
            request.innerText = "Request";

            switch (subject[i].type){
                case "1":
                    spanType.innerText = "Books/Shivani";
                    break;
                case "2":
                    spanType.innerText = "Handwritten Note";
                    break;
                case "3":
                    spanType.innerText = "We don't know";
                    break;
                default:
                    spanType.innerText = "We don't know";
                    break;
            }

            p1.setAttribute("class", "col s10 offset-s1 m10 offset-m1 l10 offset-l1 xl10 offset-xl1");
            p2.setAttribute("class", "card red lighten-2");
            p3.setAttribute("class", "card-content white-text");
            p4.setAttribute("class", "card-action");
            title.setAttribute("class", "card-title");
            request.setAttribute("data-target", "./request.php?id=" + subject[i].id);
            request.setAttribute("href", "#!");
            request.setAttribute("class", "request yellow-text");

            p4.appendChild(request);
            p3.appendChild(title);

            p3.appendChild(strongType);
            p3.appendChild(br8);
            p3.appendChild(spanType);

            p2.appendChild(p3);
            p2.appendChild(p4);
            p1.appendChild(p2);
            result.appendChild(p1);
        }
    }
</script>
<script src="../assets/js/jquery-2.1.1.min.js"></script>
<script src="../assets/js/materialize.js"></script>
<script src="../assets/js/main.js"></script>
<script>
    $(".request").on('click', function () {
        var url = $(this).attr("data-target");
        var me = $(this);
        function hideMe() {
            me.parent().parent().delay(1000).hide(500);
        }
        $.ajax({
            url: url,
            success: function(data){
                Materialize.toast(data, 4000);
                hideMe();
            }
        });
    });
</script>
</body>
</html>

