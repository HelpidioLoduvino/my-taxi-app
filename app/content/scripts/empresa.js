document.addEventListener("DOMContentLoaded", function () {

    var inserirViatura = new bootstrap.Modal(document.getElementById("inserirViatura"));

    var inserirCategoria = new bootstrap.Modal(document.getElementById("inserirCategoria"));

    document.querySelector("a[data-target='#inserirViatura']").addEventListener("click", function () {
        inserirViatura.show();
    });

    document.querySelector("a[data-target='#inserirCategoria']").addEventListener("click", function () {
        inserirCategoria.show();
    });

});
