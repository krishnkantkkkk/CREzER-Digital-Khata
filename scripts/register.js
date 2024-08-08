let register_section = document.getElementById("register_section");
let register_container = document.getElementById("register_container");
let login_container = document.getElementById("login_container");
let error = document.getElementById("error");

register_container.onclick = function () {
  error.innerText = "";
};

login_container.onclick = function () {
  error.innerText = "";
};
document.getElementById("register_username").focus();

function login() {
  register_section.innerHTML = "";
  register_section.appendChild(error);
  register_section.appendChild(login_container);
  document.getElementById("login_username").focus();
}

function register() {
  register_section.innerHTML = "";
  register_section.appendChild(error);
  register_section.appendChild(register_container);
  document.getElementById("register_username").focus();
}

// Navbar
document.getElementById("slider-menu").style = "display:none;";
var get_started_button = document.getElementById("get_started_button");
get_started_button.style = "display:none";
