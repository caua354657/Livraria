function mostrarOcultarSenha(icone)
{
    var campo = document.getElementById("senha");
    var visivel = campo.type === "text";
    if(visivel)
    {
        campo.type = "password";
        icone.textContent = "🙈";
    } 
    else 
    {
        campo.type = "text";
        icone.textContent = "👁️";
    }
}

window.onload = function() 
{
    var alerta = document.getElementById("alerta");
    if(alerta) 
    {
        alerta.style.display = "flex";
        setTimeout(() => {alerta.style.display = "none";}, 3000);
    }
}