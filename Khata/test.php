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
        <div id="menus">
            <a href="index.php#html">Home</a>
            <a href="index.php#usecase">UseCase</a>
            <a href="">About</a>
            <a href="">Contact</a>
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
</script>
</html>
