document.addEventListener("DOMContentLoaded", function () {
 
    var listarViagem = new bootstrap.Modal(document.getElementById("listarViagem"));
    
    document.querySelector("a[data-target='#listarViagem']").addEventListener("click", function () {
        listarViagem.show();
    });
    
});

