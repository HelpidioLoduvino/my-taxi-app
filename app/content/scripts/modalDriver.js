document.addEventListener("DOMContentLoaded", function () {
 
    var verPedido = new bootstrap.Modal(document.getElementById("verPedido"));
    
    document.querySelector("a[data-target='#verPedido']").addEventListener("click", function () {
        verPedido.show();
    });
    
    
});
