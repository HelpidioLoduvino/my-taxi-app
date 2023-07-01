document.addEventListener("DOMContentLoaded", function () {
 
    var getTripModal = new bootstrap.Modal(document.getElementById("getTripModal"));
    var registerModal = new bootstrap.Modal(document.getElementById("registerModal"));
    
    document.querySelector("button[data-target='#getTripModal']").addEventListener("click", function () {
        getTripModal.show();
    });
    
    document.querySelector("a[data-target='#registerModal']").addEventListener("click", function () {
        registerModal.show();
    });
    
});
