<?php
require_once("data.php");
session_start();
$no_of_users = mysqli_num_rows($users->query("select * from users"));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="styles/index.css">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body id="mainBody">
    <?php include("navbar.php"); ?>
    <div class="section_container" id="intro_scroller">
        <section id="intro">
            <div id="hook_content">
                <div>
                    <p id="hook_text">Welcome to<span> CREzER</span><br>Your Gateway to<br>Keep Credit<br>Records</p>
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
                            $usernames = $users->query("select * from users order by user_id desc");
                            while ($row = mysqli_fetch_array($usernames)) {
                                if ($i < 3) {
                            ?>
                                    <tr>
                                        <td>
                                            <?php 
                                                if(strlen($row['username'])<=10) echo ucwords($row['username']);
                                                else echo ucwords(substr($row['username'], 0, 10))."...";
                                            ?>
                                        </td>
                                        <td>
                                            <?php 
                                                if(strlen($row['name'])<=10) echo ucwords($row['name']);
                                                else echo ucwords(substr($row['name'], 0, 10))."...";
                                            ?>
                                        </td>
                                    </tr>
                            <?php }
                                $i++;
                            } ?>
                        </table>
                    </div>
                </div>
                <div id="analytics" class="card">
                    <img src="images/logo.svg" alt="">
                    <p><span>CREzER</span> ONE WAY TO DIVE INTO DIGITAL KHATA</p>
                </div>
            </div>
        </section>
    </div>

    <div class="section_container" id="usecase_scroller">
        <section id="useCase">
            <div id="usecase_text" class="heading">
                <p>USE CASE</p>
            </div>
            <div id="physical" class="usecase-box">
                <img src="images/record.svg">
                <p>Physical Entry</p>
            </div>
            <div id="to">
                <img src="images/to.svg" alt="">
            </div>
            <div id="digital" class="usecase-box">
                <img src="images/Digital_write.svg" alt="">
                <p>Digital Entry</p>
            </div>
        </section>
    </div>


    <div class="section_container" id="about_scroller">
        <section id="about-section">
            <div id="about_text" class="heading">
                <p>ABOUT ME</p>
            </div>
            <div id="aboutinfo">
                <p>HI, I AM<br><span>KRISHN KANT KUMAR</span><br>IN THE MIDST OF MY B.TECH JOURNEY SPECIALIZING IN COMPUTER SCIENCE AND ENGINEERING FROM IIIT KOTA</p>
            </div>
            <div id="imgandname">
                <img id="my_image" src="images/Krishna_image.png" alt="">
                <p>KRISHNA</p>
            </div>
            <div id="qualification">
                <div id="row1">
                    <img src="images/html.svg" alt="" title="HTML">
                    <img src="images/css.svg" alt="" title="CSS">
                    <img src="images/js.svg" alt="" title="JAVASCRIPT">
                </div>
                <div id="row2">
                    <img src="images/django.svg" alt="" title="DJANGO">
                    <img src="images/php.svg" alt="" title="PHP">
                    <img src="images/sql.svg" alt="" title="SQL">
                </div>
                <div id="row3">
                    <img src="images/python.svg" alt="" title="PYTHON">
                    <img src="images/git.svg" alt="" title="GIT">
                    <img src="images/solidity.svg" alt="" title="SOLIDITY">
                </div>
            </div>
        </section>
    </div>
    <div class="section_container" id="contact_scroller">
        <section id="contact-section">

        </section>
    </div>
</body>

<script>
    var no_of_users = <?php echo $no_of_users; ?>;
</script>
<script src="scripts/index.js"></script>

</html>

<?php
if (isset($_SESSION['logged_in'])) {
    echo '<script>
            document.getElementById("get_started_button").innerText = "Dashboard";
            let sign_up = document.getElementById("sign_up");
            sign_up.innerText = "Log Out";
            sign_up.onclick = function(){window.location.href="main.php?logout=yes"};
        </script>';
} else echo '<script>document.getElementById("sign_up").onclick=function(){window.location.href="register.php"}</script>';
