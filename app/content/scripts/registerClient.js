document.addEventListener("DOMContentLoaded", function () {
 
    var signupModal = new bootstrap.Modal(document.getElementById("signupModal"));
    
    document.querySelector("a[data-target='#signupModal']").addEventListener("click", function () {
        signupModal.show();
    });
    
});


