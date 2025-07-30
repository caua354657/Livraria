function validar(input) 
{
    if(input.value < 0) 
    {
       input.value = 0;
    }
       input.form.submit();
}