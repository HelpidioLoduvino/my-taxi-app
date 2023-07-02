document.addEventListener("DOMContentLoaded", function () {
 
    var verPedido = new bootstrap.Modal(document.getElementById("verPedido"));
    
    var emAndamento = new bootstrap.Modal(document.getElementById("emAndamento"));
    
    var registerModal = new bootstrap.Modal(document.getElementById("registerModal"));
    
    document.querySelector("a[data-target='#verPedido']").addEventListener("click", function () {
        verPedido.show();
    });
    
    document.querySelector("a[data-target='#emAndamento']").addEventListener("click", function () {
        emAndamento.show();
    });
    
    document.querySelector("a[data-target='#registerModal']").addEventListener("click", function () {
        registerModal.show();
    });  
});
