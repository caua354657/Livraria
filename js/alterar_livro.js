document.getElementById('inputimagem').addEventListener('change', function () 
  {
    const img = document.getElementById('preview');
    const file = this.files[0];
    if(file) 
    {
      img.src = URL.createObjectURL(file);
    }
  });
