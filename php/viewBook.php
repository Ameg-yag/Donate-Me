<?php require_once ('./imports/login-gate.php')?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>

  <link rel="shortcut icon" href="../favicon.ico" >
  <link rel="icon" href="../animated_favicon.gif" type="image/gif" >

  <title>UseIt - The Book List</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="../assets/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="../assets/css/main.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
<?php require_once ('./imports/menu.html')?>
<div class="container">
  <div class="center">
    <h3>The Book List</h3>
    <a href="addBook.php" class="btn"><i class="material-icons left">add</i>Add More In The List</a>
  </div>
  <br><br>
  <div id="table"></div>
</div>
<!--  Scripts-->
<!--<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>-->
<script src="../assets/js/json/subject.js"></script>
<script>
    var table = document.createElement("table");
    var thead = document.createElement("thead");
    var tbody = document.createElement("tbody");
    var tr = document.createElement("tr");
    var thCode = document.createElement("th");
    var thName = document.createElement("th");

    thCode.innerText = "CODE";
    thName.innerText = "NAME";

    table.setAttribute("class", "bordered centered highlight");

    tr.appendChild(thCode);
    tr.appendChild(thName);
    thead.appendChild(tr);
    table.appendChild(thead);
    table.appendChild(tbody);

    document.getElementById("table").appendChild(table);

    for(var key in subjectlist)
    {
        var r = document.createElement("tr");
        var d1 = document.createElement("td");
        var d2 = document.createElement("td");

        d1.innerText = key;
        d2.innerText = subjectlist[key];

        r.appendChild(d1);
        r.appendChild(d2);

        tbody.appendChild(r);

        console.log(key + subjectlist [key]);
    }
</script>
<script src="../assets/js/jquery-2.1.1.min.js"></script>
<script src="../assets/js/materialize.js"></script>
<script src="../assets/js/main.js"></script>
</body>
</html>

