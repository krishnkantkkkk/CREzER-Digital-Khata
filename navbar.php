<?php
    require_once('data.php');
    if(isset($_SESSION['logged_in'])) $user_id = $_SESSION['logged_in'];
    else $user_id = "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <link rel="icon" type="image/x-icon" href="/images/logo.svg">
    <link rel="stylesheet" href="styles/navbar.css">
    <link rel="stylesheet" href="styles/style.css">
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
            <form id="search" class="search">
                <input type="text" id="input_search" name ="search" placeholder="Search Borrowers" autocomplete="off">
            </form>
            <div id="search_icon" class="search"><img id="search_icon_image" src="images/search-icon.svg" alt=""></div>
            <div id="user"><img src="./images/user-icon.svg" alt=""><p id="user_name"><?php $name = mysqli_fetch_assoc($users->query("select * from users where user_id='$user_id'"))['name']; echo strlen($name)<10 ? ucwords($name) : ucwords(substr($name, 0, 10))."..."; ?></p></div>
            <button id="get_started_button">Get Started</button>
        </div>
    </nav>
</body>

<script src="scripts/navbar.js"></script>
</html>