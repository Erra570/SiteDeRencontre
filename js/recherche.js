document.addEventListener("DOMContentLoaded", function() {
    var menuButton = document.getElementById("moreButton");
    var formContainer = document.getElementById("formMore");

    menuButton.addEventListener("click", function() {
        if (formContainer.style.display === "none") {
            formContainer.style.display = "block";
        } else {
            formContainer.style.display = "none";
        }
    });
});