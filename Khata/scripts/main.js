let targetPopup = document.getElementById("body");
let popup_background = document.getElementsByClassName("popup_background")[0];
let createButton = document.getElementById("create_button");
let increaseAmountButton = document.getElementById("increase_button");
let decreaseAmountButton = document.getElementById("decrease_button");
let inputName = document.getElementById("name_input");
let inputAmount = document.getElementById("amount_input");
let targetButton = document.getElementById("buttons");
let popup_form = document.getElementsByClassName("popup_form")[0];
let confirm_button = document.getElementById("confirm_button");
let cancel_button = document.getElementById("cancel_button");
let popup_container = document.getElementsByClassName("popup_container")[0];
let popup_close_button =
  document.getElementsByClassName("popup_close_button")[0];
let user_name = document.getElementById("user_name");
let transaction = document.getElementsByClassName("transaction")[0];
let memo_input = document.getElementById("memo_input");
let command_text = document.getElementsByClassName("command_text")[0];

function createPopup() {
  popup_container.appendChild(popup_form);
  targetPopup.appendChild(popup_background);
  targetButton.innerHTML = "";
  popup_form.appendChild(targetButton);
  if (!popup_form.querySelector("#name_input"))
    popup_form.insertBefore(inputName, popup_form.childNodes[2]);
  if (!popup_form.querySelector("#amount_input"))
    popup_form.insertBefore(inputAmount, popup_form.childNodes[3]);
  targetButton.appendChild(createButton);
  command_text.innerText = "New Borrower";
  inputName.focus();
}

function popdown(event) {
  if (
    event.target === popup_close_button ||
    event.target === popup_background
  ) {
    if (targetPopup.contains(popup_background))
      targetPopup.removeChild(popup_background);
    if (popup_container.contains(popup_form))
      popup_container.removeChild(popup_form);
    if (popup_container.contains(transaction)) {
      popup_container.removeChild(transaction);
      window.location.href = "main.php";
    }
    memo_input.style = "display:inline;";
    popup_container.style = "height:350px;";
  }
}

let decreases = document.querySelectorAll(".modify_button");
decreases.forEach(function (element) {
  element.onclick = function () {
    popup_container.appendChild(popup_form);
    targetPopup.appendChild(popup_background);
    targetButton.innerHTML = "";
    document.getElementById("hidden_input").value = element.id;
    if (popup_form.querySelector("#name_input"))
      popup_form.removeChild(inputName);
    if (!popup_form.querySelector("#amount_input"))
      popup_form.appendChild(inputAmount);
    popup_form.appendChild(targetButton);
    targetButton.appendChild(increaseAmountButton);
    targetButton.appendChild(decreaseAmountButton);
    command_text.innerText = "Modify Amount";
    inputAmount.focus();
  };
});

function pay_or_borrow(event) {
  if (popup_form.contains(increaseAmountButton)) {
    if (event.key === "+") increaseAmountButton.click();
    else if (event.key === "-") decreaseAmountButton.click();
  }
}

function confirm(nth) {
  popup_container.appendChild(popup_form);
  targetPopup.appendChild(popup_background);
  targetButton.innerHTML = "";
  if (popup_form.querySelector("#name_input"))
    popup_form.removeChild(inputName);
  if (popup_form.querySelector("#amount_input"))
    popup_form.removeChild(inputAmount);
  memo_input.style = "display:none;";
  command_text.innerText = "Has amount paid?";
  popup_form.appendChild(targetButton);
  targetButton.appendChild(confirm_button);
  targetButton.appendChild(cancel_button);
  document.getElementById("confirm_button").href = `?delId=${nth}`;
}

function showTransaction(event, id) {
  let parent = document.getElementById("box" + id);
  if (event.target === parent) {
    window.location.href = `?transaction_id=${id}`;
  }
}

if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}

// Navbar
var logout = document.getElementById("get_started_button");
logout.innerText = "Log Out";
logout.onclick = function () {
  window.location.href = "?logout=yes";
};

document.getElementById("search").style = "display:inline;";
document.getElementById("search_icon").style = "display:inline;";
document.getElementById("user").style = "display:flex;";
document.getElementById("slider-menu").style = "display:none;";
document.getElementById("search_icon_image").onclick = function () {
  var search_value = document.getElementById("input_search").value;
  window.location.href = `?search=${search_value}`;
};
