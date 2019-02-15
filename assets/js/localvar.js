//For setting localStorage on login

window.onload = function () {
    var i;
    var fname = document.getElementsByClassName("fname");
    for (i = 0; i < fname.length; i++) {
        fname[i].innerText = localStorage.getItem("fname");
    }

    var mname = document.getElementsByClassName("mname");
    for (i = 0; i < mname.length; i++) {
        mname[i].innerText = localStorage.getItem("mname");
    }

    var lname = document.getElementsByClassName("lname");
    for (i = 0; i < lname.length; i++) {
        lname[i].innerText = localStorage.getItem("lname");
    }

    var branch = document.getElementsByClassName("branch");
    for (i = 0; i < branch.length; i++) {
        branch[i].innerText = localStorage.getItem("branch");
    }

    var college = document.getElementsByClassName("college");
    for (i = 0; i < college.length; i++) {
        college[i].innerText = localStorage.getItem("college");
    }

    var name = document.getElementsByClassName("full_name");
    for (i = 0; i < name.length; i++) {
        name[i].innerText = localStorage.getItem("name");
    }
};