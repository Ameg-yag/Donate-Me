//Designed For Client Side Browser Fingerprinting

function createId() {
    new Fingerprint2().get(function (result) {
        localStorage.setItem("fingerprint", result);
    });
}

function getId() {
    document.getElementById("hidden").value = localStorage.getItem("fingerprint");
}

function removeID() {
    localStorage.removeItem("fingerprint");
}

function createElementID() {
    var x;

}