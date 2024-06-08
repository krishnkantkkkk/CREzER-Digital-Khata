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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
    
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
            <button id="get_started_button">Get Started</button>
        </div>
    </nav>
</body>

<script>
    document.getElementById("logo").onclick =function(){window.location.href="index.php";}
    document.getElementById("search").style = "display:none;";
    document.getElementById("search_icon").style = "display:none;";
    document.getElementById("user").style = "display:none;";
</script>
</html>
