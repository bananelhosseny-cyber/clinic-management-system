const container = document.querySelector(".parent");
const registerBtn = document.querySelector(".btn-register");
const loginBtn = document.querySelector(".btn-login");
let passwordConfirmation = document.getElementById("passwordConfirmation");
let passConfirmAlert = document.getElementById("passConfirmAlert");
let passAlert = document.getElementById("passAlert");
let Password = document.getElementById("register-password");
let xmarkCapital = document.getElementById("xmarkCapital");
let xmarkSmall = document.getElementById("xmarkSmall");
let xmarkNumbers = document.getElementById("xmarkNumbers");
let xmarkSymbol = document.getElementById("xmarkSymbol");
let xmarkLength = document.getElementById("xmarkLength");

registerBtn.addEventListener("click", () => {
    container.classList.add("active");
});

loginBtn.addEventListener("click", () => {
    container.classList.remove("active");
});

function show(type) {
    let password = document.getElementById(`${type}-password`);
    let eyeSlash = document.getElementById(`${type}-eye-slash`);
    let eye = document.getElementById(`${type}-eye`);

    if (password.type === "password") {
        password.type = "text";
        eyeSlash.style.visibility = "hidden";
        eye.style.visibility = "visible";
        eye.style.color = "#fff";
    } else {
        password.type = "password";
        eyeSlash.style.visibility = "visible";
        eye.style.visibility = "hidden";
    }
}

Password.addEventListener("keyup", function () {
    var capital = /[A-Z]/;
    var small = /[a-z]/;
    var numbers = /[0-9]/;
    var symbols = /\W/;
    passAlert.style = "display: block;   opacity: 1;";
    if (capital.test(Password.value) != true) {
        xmarkCapital.innerHTML = `<span ><i class="fa-solid fa-xmark"></i></span><span>One Capital Letter</span>`;
        xmarkCapital.style.color = "red";
    } else {
        xmarkCapital.innerHTML = `<span ><i class="fa-solid fa-check"></i></span><span>One Capital Letter</span>`;
        xmarkCapital.style.color = "green";
    }
    // ================================================
    if (small.test(Password.value) != true) {
        xmarkSmall.innerHTML = `<span ><i class="fa-solid fa-xmark"></i></span><span>One Small Letter</span>`;
        xmarkSmall.style.color = "red";
    } else {
        xmarkSmall.innerHTML = `<span ><i class="fa-solid fa-check"></i></span><span>One Small Letter</span>`;
        xmarkSmall.style.color = "green";
    }
    // ================================================

    if (numbers.test(Password.value) != true) {
        xmarkNumbers.innerHTML = `<span ><i class="fa-solid fa-xmark"></i></span><span>One Number</span>`;
        xmarkNumbers.style.color = "red";
    } else {
        xmarkNumbers.innerHTML = `<span ><i class="fa-solid fa-check"></i></span><span>One Number</span>`;
        xmarkNumbers.style.color = "green";
    }
    // ================================================

    if (symbols.test(Password.value) != true) {
        xmarkSymbol.innerHTML = `<span ><i class="fa-solid fa-xmark"></i></span><span>One Symbol</span>`;
        xmarkSymbol.style.color = "red";
    } else {
        xmarkSymbol.innerHTML = `<span ><i class="fa-solid fa-check"></i></span><span>One Symbol</span>`;
        xmarkSymbol.style.color = "green";
    }
    // ================================================
    if (Password.value.length < 8) {
        xmarkLength.innerHTML = `<span ><i class="fa-solid fa-xmark"></i></span><span>8 digits length</span>`;
        xmarkLength.style.color = "red";
    } else {
        xmarkLength.innerHTML = `<span ><i class="fa-solid fa-check"></i></span><span>8 digits length</span>`;
        xmarkLength.style.color = "green";
    }
    // ================================================

    Password.addEventListener("blur", function () {
        if (
            capital.test(Password.value) == true &&
            small.test(Password.value) == true &&
            numbers.test(Password.value) == true &&
            symbols.test(Password.value) == true &&
            Password.value.length >= 8
        ) {
            passAlert.style = "display: none;";
        }
    });
});

passwordConfirmation.addEventListener("keyup", function () {
    if (Password.value != passwordConfirmation.value) {
        passConfirmAlert.innerHTML = `<span><i class="fa-solid fa-xmark"></i></span><span> Passwords do not match</span>`;
        passConfirmAlert.style = "display:block; color:red;";
    } else {
        passConfirmAlert.innerHTML = `<span><i class="fa-solid fa-check"></i></span><span> Passwords match</span>`;
        passConfirmAlert.style = "display:block; color:green;";
    }
});

passwordConfirmation.addEventListener("blur", function () {
    passConfirmAlert.style = "display:none;";
});
