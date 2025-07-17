document.querySelector("form").addEventListener("submit", function(){
    document.getElementById("spinner").classList.remove("d-none");
    document.querySelectorAll("button").forEach(btn => btn.disabled = true);
});