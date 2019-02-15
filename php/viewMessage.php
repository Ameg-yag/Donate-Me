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

$SQL = "SELECT " . MESSAGE_TABLE . ".id, " . MESSAGE_TABLE . ".message, " . MESSAGE_TABLE . ".sender, " . MESSAGE_TABLE . ".sent_time, " . STUDENT_TABLE . ".fname, " . STUDENT_TABLE . ".mname, " . STUDENT_TABLE . ".lname FROM " . MESSAGE_TABLE . " INNER JOIN " . STUDENT_TABLE . " ON " . STUDENT_TABLE . ".rollno=" . MESSAGE_TABLE . ".sender WHERE receiver = ?";

if (!($stmt = $mysqli->prepare($SQL))) {
  echo "PF: Message Checking Failed";
}

if (!$stmt->bind_param("s", $rollno)) {
  echo "BF: Message Checking Failed";
}

if (!$stmt->execute()) {
  echo "EF: Message Checking Failed";
}

$result = mysqli_stmt_get_result($stmt);

$response = array();
$posts = array();

while ($row = mysqli_fetch_array($result)){
  $msg = $row['message'];
  $id= $row['id'];
  $sender = $row['sender'];
  $time = $row['sent_time'];
  $name = $row['fname'] . " " . $row['mname'] . " " .  $row['lname'];
  $posts[] = array('sender'=>$sender, 'name'=>$name, 'msg'=>$msg, 'time'=>$time, 'id'=>$id);
}
$response['messages'] = $posts;

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>

  <link rel="shortcut icon" href="../favicon.ico" >
  <link rel="icon" href="../animated_favicon.gif" type="image/gif" >

  <title>UseIt - Received Messages</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="../assets/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="../assets/css/main.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
<?php require_once ('./imports/menu.html');?>
<br>
<div class="container">

  <div class="center">
    <h3>Received Messages</h3>
    <a href="sendMessage.php" class="btn">Send A Message</a>
    <br><br>
  </div>
  <iframe name="theFrame" style="display: none" id="theFrame"></iframe>
  <br>
  <div id="messages">
  </div>
</div>

<!--  Scripts-->
<!--<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>-->
<script src="../assets/js/json/subject.js"></script>
<script src="../assets/js/jquery-2.1.1.min.js"></script>
<script src="../assets/js/materialize.js"></script>
<script src="../assets/js/main.js"></script>
<script src="../assets/js/localvar.js"></script>
<script>

    var messagesJSON = <?php echo json_encode($response); ?>;
    var msg = messagesJSON.messages;

    var messages = document.getElementById("messages");

    for(var i = 0; i < msg.length; i++)
    {
        var p1 = document.createElement("div");
        var p2 = document.createElement("div");
        var p3 = document.createElement("div");
        var title = document.createElement("span");
        var nameSpan = document.createElement("span");
        var small = document.createElement("small");
        var link = document.createElement("a");
        var br1 = document.createElement("br");
        var br2 = document.createElement("br");
        var br3 = document.createElement("br");
        var strongTime = document.createElement("strong");
        var sent_time = document.createElement("time");
        var strongMessage = document.createElement("strong");
        var message = document.createElement("p");
        var p4 = document.createElement("div");
        var reply = document.createElement("a");
        var deleteMsg = document.createElement("a");

        nameSpan.innerText = msg[i].name + " ";
        link.innerText = " [ " + msg[i].sender + " ]";
        strongTime.innerText = "TIME";
        strongMessage.innerText = "MESSAGE";
        sent_time.innerText = msg[i].time;
        message.innerText = msg[i].msg;
        reply.innerText = "Reply";
        deleteMsg.innerText = "Delete";

        p1.setAttribute("class", "col s12 m6");
        p2.setAttribute("class", "card deep-purple darken-1");
        p3.setAttribute("class", "card-content white-text");
        p4.setAttribute("class", "card-action");
        title.setAttribute("class", "card-title");
        link.setAttribute("href","#!");
        // link.setAttribute("href","./profile.php?rollno=" + link.innerText.substr(3,13));
        reply.setAttribute("href","#!");
        deleteMsg.setAttribute("href","#!");
        deleteMsg.setAttribute("class","deleteMsg");
        deleteMsg.setAttribute("data-target", "./deleteMessage.php?id=" + msg[i].id);

        title.appendChild(nameSpan);
        title.appendChild(small);
        small.appendChild(link);
        p4.appendChild(reply);
        p4.appendChild(deleteMsg);
        p3.appendChild(title);
        p3.appendChild(strongTime);
        p3.appendChild(br1);
        p3.appendChild(sent_time);
        p3.appendChild(br2);
        p3.appendChild(br3);
        p3.appendChild(strongMessage);
        p3.appendChild(message);
        p2.appendChild(p3);
        p2.appendChild(p4);
        p1.appendChild(p2);
        messages.appendChild(p1);

        reply.onclick = function () {
            sessionStorage.setItem("who", this.parentNode.previousSibling.firstChild.firstChild.nextSibling.innerText.substr(2,12));
            window.location ='./sendMessage.php';
        };

        link.onclick = function () {
            var frame = document.getElementById("theFrame");
            frame.style.display = "block";
            frame.style.top = "0";
            frame.style.bottom = "0";
            frame.style.left = "0";
            frame.style.right = "0";
            frame.style.border = "0";
            frame.style.width = "100%";
            frame.style.minHeight = "100vmin";
            // frame.style.display = "none";
            window.open("./profile.php?rollno=" + this.innerText.substr(2,12), "theFrame");
        }
    }
</script>
<script>
    $(".deleteMsg").on('click', function () {
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

