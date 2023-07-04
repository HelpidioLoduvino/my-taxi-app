document.addEventListener("DOMContentLoaded", function () {
    
    var pedidoSolicitado = new bootstrap.Modal(document.getElementById("pedidoSolicitado"));

    document.querySelector("a[data-target='#pedidoSolicitado']").addEventListener("click", function () {
        pedidoSolicitado.show();
    });
    
});
