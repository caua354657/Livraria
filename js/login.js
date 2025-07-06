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