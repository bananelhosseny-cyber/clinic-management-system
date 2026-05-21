let passConfirmAlert = document.getElementById("emailAlert");
let btn = document.getElementById("btn");
btn.addEventListener("click", function () {
    window.location.href = "resetpassword.html";
});
document.getElementById("btn").addEventListener("click", async function() {
    let email = document.getElementById("mail").value;

    let response = await fetch(
        `http://127.0.0.1:8000/send-reset-link?email=${email}`
    );

    let data = await response.json();

    if (response.ok) {
        alert("Verification code sent!");
        window.location.href = "resetpassword.html?email=" + email;
    } else {
        document.getElementById("emailAlert").style.display = "block";
    }
});
