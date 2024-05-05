<?php
    require_once("data.php");
    $no_of_users = mysqli_num_rows($con->query("select * from usernames"));
    $usernames = $con->query("select * from usernames");
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
            <p id="hook_text">Welcome to<span>CREzER</span><br>Your Gateway to<br>Keep Credit<br>Records</p>
            <div id="usercount">
                <p id="count"></p>
                USERS
            </div>
            <button id="sign_up" style="margin-left:20px;">Sign Up</button>
        </div>
        <div id="data_content">
            <div id="recent_users" class="card">
                <p>Recent Users</p>
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
            <div id="analytics" class="card">
                <img src="images/logo.svg" alt="">
                <p><span>CREzER</span> ONE WAY TO DIVE INTO DIGITAL KHATA</p>
            </div>
        </div>
    </section>
    <div class="html" id="usecaseScroller"></div>
    <section id="useCase">
        <img src="images/record.svg">
    </section>
    <div class="html" id="aboutScroller"></div>
    <section id="about-section">hello</section>
    <div class="html" id="contactScroller"></div>
    <section id="contact-section">contactme</section>
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
    
    
    document.getElementById("get_started_button").onclick=function()
    {
        window.location.href = "http://localhost/khata/register.php";
    }
    document.getElementById("sign_up").onclick=function()
    {
        window.location.href = "http://localhost/khata/register.php";
    }
</script>
</html>