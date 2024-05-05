<?php
    require_once('data.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <link rel="icon" type="image/x-icon" href="/images/logo.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <div id="logo"><img src="./images/logo.svg" alt="">CREzER</div>
        <div id="slider-menu">
            <div id="menus">
                <a id="home"  onclick="slide(this.id)">Home</a>
                <a id="usecase"  onclick="slide(this.id)">UseCase</a>
                <a id="about"  onclick="slide(this.id)">About</a>
                <a id="contact" onclick="slide(this.id)">Contact</a>
            </div>
            <div id="slide"><div id="slider"></div></div>
        </div>
        <div id="user_status">
            
            <form id="search"><input type="text" id="input_search" name ="search" placeholder="Search Borrowers" autocomplete="off"></form>
            <div id="search_icon"><img id="search_icon_image" src="./images/search-icon.svg" alt=""></div>
            <div id="user"><img src="./images/user-icon.svg" alt=""><p id="user_name"></p></div>
            <div id="get_started_button">Get Started</div>
        </div>
    </nav>
</body>

<script>
    document.getElementById("logo").onclick =function(){window.location.href="index.php";}
    document.getElementById("search").style = "display:none;";
    document.getElementById("search_icon").style = "display:none;";
    document.getElementById("user").style = "display:none;";

    function slide(id) {
    var shiftLength = 0;
    if(id=="home"){
        window.location.href="index.php#introScroller";
        shiftLength = 0;
    }else if(id=="usecase"){
        window.location.href="index.php#usecaseScroller";
        shiftLength = 75;
    }else if(id=="about"){
        window.location.href="index.php#aboutScroller";
        shiftLength = 150;
    }else{
        window.location.href="index.php#contactScroller";
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
    rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
    rect.right <= (window.innerWidth || document.documentElement.clientWidth)
  );
}

// Function to handle scroll event
function handleScroll() {
  var useCase = document.getElementById("useCase");
  var home =document.getElementById("intro");
  var about =document.getElementById("about-section");
  var contact =document.getElementById("contact-section");
  if (isInViewport(useCase)) {
    document.getElementById("slider").style.transform = `translateX(75px)`;
  }else if(isInViewport(home)){
    document.getElementById("slider").style.transform = "translateX(0px)"
  }else if(isInViewport(about)){
    document.getElementById("slider").style.transform = "translateX(150px)"
  }else if(isInViewport(contact)){
    document.getElementById("slider").style.transform = "translateX(225px)"
  }
}

// Add scroll event listener
window.addEventListener('scroll', handleScroll);

// Initial check on page load
handleScroll();
</script>
</html>
