document.addEventListener("DOMContentLoaded", function () {

    var buscarCliente = new bootstrap.Modal(document.getElementById("buscarCliente"));

    document.querySelector("a[data-target='#buscarCliente']").addEventListener("click", function () {
        buscarCliente.show();
    });
});
