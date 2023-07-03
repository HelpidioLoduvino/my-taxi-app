document.addEventListener("DOMContentLoaded", function () {
 
    var getTripModal = new bootstrap.Modal(document.getElementById("getTripModal"));
    var signupModal = new bootstrap.Modal(document.getElementById("signupModal"));
    
    document.querySelector("button[data-target='#getTripModal']").addEventListener("click", function () {
        getTripModal.show();
    });
    
    document.querySelector("a[data-target='#signupModal']").addEventListener("click", function () {
        signupModal.show();
    });
    
});
