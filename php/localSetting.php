<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>UseIt - LocalSetting</title>
    <style>
        div
        {
            display: none;
        }
    </style>
</head>
<body>
<div>
    <span id="name"><?php echo $_COOKIE['name'] ?></span><br>
    <span id="fname"><?php echo $_COOKIE['fname'] ?></span><br>
    <span id="mname"><?php echo $_COOKIE['mname'] ?></span><br>
    <span id="lname"><?php echo $_COOKIE['lname'] ?></span><br>
    <span id="branch"><?php echo $_COOKIE['branch'] ?></span><br>
    <span id="college"><?php echo $_COOKIE['college'] ?></span><br>
    <span id="ban"><?php echo $_COOKIE['ban'] ?></span><br>
    <span id="flag"><?php echo $_COOKIE['flag'] ?></span><br>
    <span id="helped_others"><?php echo $_COOKIE['helped_others'] ?></span><br>
    <span id="got_help"><?php echo $_COOKIE['got_help'] ?></span><br>
</div>
redirecting...
</body>

<script>
    localStorage.setItem("name", document.getElementById("name").innerText);
    localStorage.setItem("fname", document.getElementById("fname").innerText);
    localStorage.setItem("mname", document.getElementById("mname").innerText);
    localStorage.setItem("lname", document.getElementById("lname").innerText);
    localStorage.setItem("branch", document.getElementById("branch").innerText);
    localStorage.setItem("college", document.getElementById("college").innerText);
    localStorage.setItem("ban", document.getElementById("ban").innerText);
    localStorage.setItem("flag", document.getElementById("flag").innerText);
    localStorage.setItem("helped_others", document.getElementById("helped_others").innerText);
    localStorage.setItem("got_help", document.getElementById("got_help").innerText);

    window.location="./home.php";

    // var Image = document.getElementById('coverget');
    // var Image64= getBase64Image(Image);
    //
    // localStorage.setItem("cover", Image64);
    //
    // function getBase64Image(img) {
    //     var canvas = document.createElement("canvas");
    //     canvas.width = img.width;
    //     canvas.height = img.height;
    //
    //     var ctx = canvas.getContext("2d");
    //     ctx.drawImage(img, 0, 0);
    //
    //     var dataURL = canvas.toDataURL("image/png");
    //
    //     return dataURL.replace(/^data:image\/(png|jpg);base64,/, "");
    // }
    //
    // var ImageLS = localStorage.getItem('cover');
    // ImageN = document.getElementById('coverset');
    // ImageN.src = "data:image/png;base64," + ImageLS;

</script>
</html>