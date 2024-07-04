var count = document.getElementById("count");

if (no_of_users > 50) {
  var start = no_of_users - 50;
  var duration = 30;
} else {
  var start = 0;
  var duration = 100;
}
let counter = setInterval(() => {
  count.innerText = start++;
  if (start == no_of_users + 1) {
    clearInterval(counter);
  }
}, duration);

function slide(id) {
  var shiftLength = 0;
  var div = document.getElementById("slider");
  if (id == "home") {
    window.location.href = "#intro_scroller";
    shiftLength = 0;
  } else if (id == "usecase") {
    window.location.href = "#usecase_scroller";
    shiftLength = 75;
  } else if (id == "about") {
    window.location.href = "#about_scroller";
    shiftLength = 150;
  } else {
    window.location.href = "#contact_scroller";
    shiftLength = 225;
  }
  div.style.transform = `translateX(${shiftLength}px)`;
}

// scroll
function isInViewport(element) {
  var rect = element.getBoundingClientRect();
  return (
    rect.top >= 0 &&
    rect.left >= 0 &&
    rect.bottom <=
      (window.innerHeight || document.documentElement.clientHeight) &&
    rect.right <= (window.innerWidth || document.documentElement.clientWidth)
  );
}

// Function to handle scroll event
function handleScroll() {
  var useCase = document.getElementById("useCase");
  var home = document.getElementById("intro");
  var about = document.getElementById("about-section");
  var contact = document.getElementById("contact-section");
  if (isInViewport(useCase)) {
    document.getElementById("slider").style.transform = `translateX(75px)`;
  } else if (isInViewport(home)) {
    document.getElementById("slider").style.transform = "translateX(0px)";
  } else if (isInViewport(about)) {
    document.getElementById("slider").style.transform = "translateX(150px)";
  } else if (isInViewport(contact)) {
    document.getElementById("slider").style.transform = "translateX(225px)";
  }
}

// Add scroll event listener
window.addEventListener("scroll", handleScroll);

// Initial check on page load
handleScroll();

document.getElementById("get_started_button").onclick = function () {
  window.location.href = "register.php";
};
