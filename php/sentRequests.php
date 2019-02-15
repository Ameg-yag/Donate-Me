<?php
/**
 * Created by PhpStorm.
 * User: ravindra
 * Date: 24/1/18
 * Time: 7:18 PM
 */
require_once ('./imports/login-gate.php');
require_once ('./imports/validation.php');
require_once ('./imports/conn.php');

$requested = 1;
$approved = 0;

$SQL = "SELECT * FROM " . UPLOAD_TABLE . " WHERE requested = ? AND requestedBy = ? AND approved = ?";

if (!($stmt = $mysqli->prepare($SQL))) {
    echo "PF: Error in searching Book";
}

if (!$stmt->bind_param("isi", $requested, $rollno, $approved)) {
    echo "BF: Error in searching Book";
}

if (!$stmt->execute()) {
    echo "EF: Error in searching Book";
}

$result = mysqli_stmt_get_result($stmt);

$response = array();
$posts = array();

while ($row = mysqli_fetch_array($result)){
    $id = $row['id'];
    $code = $row['code'];
    $uploader = $row['uploader'];
    $type = $row['type'];

    $location1 = $row['location1'];
    $lat1 = $row['lat1'];
    $lat2 = $row['lat2'];

    $location2 = $row['location2'];
    $lng1 = $row['lng1'];
    $lng2 = $row['lng2'];

    $posts[] = array('id'=> $id, 'uploader'=>$uploader, 'type'=>$type, 'location1'=>$location1, 'location2'=>$location2, 'code'=>$code);
}

$response['posts'] = $posts;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <link rel="shortcut icon" href="../favicon.ico" >
    <link rel="icon" href="../animated_favicon.gif" type="image/gif" >

    <title>UseIt - Requested Items</title>

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
    <div class="center">
        <h3>Sent Requests</h3>
        <a href="receivedRequest.php" class="btn">View Received Requests</a><br><br>
        <strong>NOTE: Please remove duplicate entries</strong>
    </div>
    <div class="row">
        <br><br>
        <fieldset id="result">
            <legend>
                Sent Requests...
            </legend>
        </fieldset>

    </div>
</div>

<!--  Scripts-->
<!--<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>-->
<script src="../assets/js/json/subject.js"></script>
<script>

    var result = document.getElementById("result");
    var nav = document.getElementsByName("nav");
    result.style.display = "none";

    var subjectJSON = <?php echo json_encode($response); ?>;
    if(subjectJSON!==null)
    {
        var subject = subjectJSON.posts;

        if(subject.length)
        {
            result.style.display = "block";
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
            var spanLocation1  = document.createElement("span");
            var spanLocation2  = document.createElement("span");
            var spanType  = document.createElement("span");
            var p4 = document.createElement("div");
            var request = document.createElement("a");

            title.innerText = sessionStorage.getItem("subject");

            strongBy.innerText = "To";
            strongLocation1.innerText = "Location 1";
            strongLocation2.innerText = "Location 2";
            spanLocation1.innerText = subject[i].location1;
            spanLocation2.innerText = subject[i].location2;
            strongType.innerText = "Type";
            spanUploader.innerText = subject[i].uploader;
            request.innerText = "Delete Request";

            var code= subject[i].code;
            for(var key in subjectlist)
            {
                if(key === code)
                {
                    title.innerText=subjectlist[key];
                }
            }

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
            p2.setAttribute("class", "card teal lighten-1");
            p3.setAttribute("class", "card-content white-text");
            p4.setAttribute("class", "card-action");
            title.setAttribute("class", "card-title");
            request.setAttribute("data-target", "./deleteRequest.php?id=" + subject[i].id);
            request.setAttribute("href", "#!");
            request.setAttribute("class", "request yellow-text");

            p4.appendChild(request);
            p3.appendChild(title);

            p3.appendChild(strongBy);
            p3.appendChild(br1);
            p3.appendChild(spanUploader);
            p3.appendChild(br2);
            p3.appendChild(br3);

            p3.appendChild(strongType);
            p3.appendChild(br8);
            p3.appendChild(spanType);
            p3.appendChild(br9);
            p3.appendChild(br10);

            p3.appendChild(strongLocation1);
            p3.appendChild(br4);
            p3.appendChild(spanLocation1);
            p3.appendChild(br5);
            p3.appendChild(br6);

            p3.appendChild(strongLocation2);
            p3.appendChild(br7);
            p3.appendChild(spanLocation2);
            // p3.appendChild(br8);
            // p3.appendChild(br9);

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
<script src="../assets/js/localvar.js"></script>
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