document.getElementById('inputimagem').addEventListener('change', function() 
{
    const img = document.getElementById('preview');
    const file = this.files[0];
    if (file) 
    {
      img.src = URL.createObjectURL(file);
    }
});

window.onload = function() 
{
    var alerta = document.getElementById("alerta");
    if(alerta) 
    {
        alerta.style.display = "flex";
        setTimeout(() => {alerta.style.display = "none";}, 3000);
    }
}