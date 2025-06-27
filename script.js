var show = document.querySelector(".show");
var menu = document.getElementById("menu");


show.style.display = "none";

menu.onclick = function() {
    if (show.style.display === "none" || show.style.display === "") {
        show.style.display = "block"; 
        menu.src = "source/quitter.png"; 
    } else {
        show.style.display = "none";
        menu.src = "source/menu.png";
    }
};