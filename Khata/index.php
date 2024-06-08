<?php
    require_once("data.php");
    $users->query("CREATE TABLE IF NOT EXISTS usernames(sno INT PRIMARY KEY AUTO_INCREMENT, username VARCHAR(20), name VARCHAR(20), email VARCHAR(20), password VARCHAR(20))");
    $no_of_users = mysqli_num_rows($users->query("select * from usernames"));
    $usernames = $users->query("select * from usernames");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body id="mainBody">
    <?php include("navbar.php"); ?>
    <div class="html" id="introScroller"></div>


    <section id="intro">
        <div id="hook_content">
            <div>
                <p id="hook_text">Welcome to<span>CREzER</span><br>Your Gateway to<br>Keep Credit<br>Records</p>
                <div id="usercount">
                <p id="count"></p>
                USERS
                </div>
                <button id="sign_up">Sign Up</button>
            </div>
        </div>
        <div id="data_content">
            <div id="recent_users" class="card">
                <p>Recent Users</p>
                <div id="table_container">
                    <table>
                        <th>Username</th>
                        <th>Name</th>
                        <?php
                            $i = 0;
                            while($row = mysqli_fetch_array($usernames))
                            { 
                                if($no_of_users-$i<=3){
                            ?>
                                <tr>
                                    <td><?php echo $row['username'] ?></td>
                                    <td><?php echo $row['name'] ?></td>
                                </tr>
                        <?php } $i++;}?>
                    </table>
                </div>
            </div>
            <div id="analytics" class="card">
                <img src="images/logo.svg" alt="">
                <p><span>CREzER</span> ONE WAY TO DIVE INTO DIGITAL KHATA</p>
            </div>
        </div>
    </section>
    <div class="html" id="usecaseScroller"></div>


    <section id="useCase">
        <div id="usecase_text" class="heading"><p>USE CASE</p></div>
        <div id="physical">
            <img src="images/record.svg">
            <p>Physical Entry</p>
        </div>
        <div id="to">
            <img src="images/to.svg" alt="">
        </div>
        <div id="digital">
            <img src="images/Digital_write.svg" alt="">
            <p>Digital Entry</p>
        </div>
    </section>
    <div class="html" id="aboutScroller"></div>


    <section id="about-section">
        <div id="about_text" class="heading"><p>ABOUT ME</p></div>
        <div id="aboutinfo"><p>HI, I AM<br><span>KRISHN KANT KUMAR</span><br>IN THE MIDST OF MY B.TECH JOURNEY SPECIALIZING IN COMPUTER SCIENCE AND ENGINEERING</p></div>
        <div id="imgandname">
            <img id="my_image" src="images/Krishna_image.png" alt="">
            <p>KRISHNA</p>
        </div>
        <div id="qualification">
            <div id="row1">
                <img src="images/html.svg" alt="" title="HTML">
                <img src="images/css.svg" alt="" title="CSS">
            </div>
            <img src="images/python.svg" alt="" title="PYTHON">
            <div id="row3">
                <img src="images/sql.svg" alt="" title="SQL">
                <img src="images/solidity.svg" alt="" title="SOLIDITY">
            </div>
        </div>
    </section>

    
    <div class="html" id="contactScroller"></div>
    <section id="contact-section">

    </section>
</body>

<script>

    var count = document.getElementById("count");

    var no_of_users = <?php echo $no_of_users; ?>;
    if(no_of_users>50){
        var start =no_of_users-50;
        var duration = 30;
    }else{
        var start = 0;
        var duration = 100;
    }
    let counter =setInterval(()=>{
        count.innerText =start++;
        if(start==no_of_users +1){
            clearInterval(counter);
        }
    },duration)


    function slide(id) {
    var shiftLength = 0;
    var div =document.getElementById("slider");
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
    
    
    document.getElementById("get_started_button").onclick=function()
    {
        window.location.href = "register.php";
    }
</script>
</html>

<?php
    if(mysqli_num_rows($logged_in->query("select * from username")))
    {
        echo '<script>
            document.getElementById("get_started_button").innerText = "Dashboard";
            let sign_up = document.getElementById("sign_up");
            sign_up.innerText = "Log Out";
            sign_up.onclick = function(){window.location.href="main.php?logout=yes"};
        </script>';
    }
    else echo '<script>document.getElementById("sign_up").onclick=function(){window.location.href="register.php"}</script>';