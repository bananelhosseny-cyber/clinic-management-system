let Password = document.getElementById("password");
let passwordConfirmation = document.getElementById("passwordConfirmation");
let Label = document.getElementById("passlabel");
let passConfirmAlert = document.getElementById("passConfirmAlert");
function show() {
  if (Password.type == "password") {
    Password.type = "text";
    document.getElementById("eyeslash-icon").style = "visibility: hidden;";
    document.getElementById("eye-icon").style =
      "visibility: visible; color: black;";
    Label.style = "top: -1px;;";
  } else {
    Password.type = "password";
    document.getElementById("eye-icon").style = "visibility: hidden;";
    document.getElementById("eyeslash-icon").style = "visibility: visible;";
    Label.style = "top: -1px;;";
  }
}

passwordConfirmation.addEventListener(
  "input",
  function () {
    if (Password.value != passwordConfirmation.value) {
      passConfirmAlert.style = "display: block;";
    } else {
      passConfirmAlert.innerHTML = `<span><i class="fa-solid fa-check"></i></span><span>Passwords Are Matches</span>`;
      passConfirmAlert.style = "display: block; color:green;";
    }
  }
);
passwordConfirmation.addEventListener("blur", function () {
  passConfirmAlert.style = "display: none;";
});
document.getElementById("updatePassword").addEventListener("click", async function() {

    let params = new URLSearchParams(window.location.search);
    let email = params.get("email");

    let code = document.getElementById("verficationCode").value;
    let password = document.getElementById("password").value;
    let confirm = document.getElementById("passwordConfirmation").value;

    let response = await fetch(
        `http://127.0.0.1:8000/reset-password?email=${email}&verification_code=${code}&password=${password}&password_confirmation=${confirm}`
    );

    let data = await response.json();

    if (response.ok) {
        alert("Password updated successfully!");
        window.location.href = "index.html";
    } else {
        alert("Error updating password!");
    }
});
