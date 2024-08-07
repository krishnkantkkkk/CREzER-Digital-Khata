let targetPopup = document.getElementById("body");
let popup_background = document.getElementsByClassName("popup_background")[0];
let createButton = document.getElementById("create_button");
let payButton = document.getElementById("payButton");
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
  command_text.innerText = "New Borrower";
  popup_container.appendChild(popup_form);
  targetPopup.appendChild(popup_background);
  targetButton.innerHTML = "";
  input_userid.style = "display : inline";
  popup_form.appendChild(targetButton);
  if (!popup_form.querySelector("#amount_input"))
    popup_form.insertBefore(inputAmount, memo_input);
  if (!popup_form.querySelector("#name_input"))
    popup_form.insertBefore(inputName, inputAmount);
  targetButton.appendChild(createButton);
  input_userid.setAttribute('required', 'true');
  input_userid.focus();
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
      window.location.href = "lenders.php";
    }
    memo_input.style = "display:inline;";
    popup_container.style = "height:350px;";
    input_userid.style = "display : none";
    input_userid.removeAttribute('required');
  }
}

let decreases = document.querySelectorAll(".pay_button");
decreases.forEach(function (element) {
  element.onclick = function () {
    popup_container.appendChild(popup_form);
    targetPopup.appendChild(popup_background);
    targetButton.innerHTML = "";
    document.getElementById("hidden_input").value = element.id;
    if (!popup_form.querySelector("#amount_input"))
      popup_form.insertBefore(inputAmount, memo_input);
    popup_form.appendChild(targetButton);
    targetButton.appendChild(payButton);
    command_text.innerText = "Pay Amount";
    inputAmount.focus();
  };
});

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

document.getElementById("user").style = "display:flex;";
document.getElementById("slider-menu").style = "display:none;";
document.getElementById("search_icon_image").onclick = function () {
  var search_value = document.getElementById("input_search").value;
  window.location.href = `?search=${search_value}`;
};
