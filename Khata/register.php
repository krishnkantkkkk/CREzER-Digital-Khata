<?php
    ob_start();
    require_once("data.php");
    if(mysqli_num_rows($logged_in->query("select * from username"))) header("Location:main.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include("navbar.php") ?>
    <main>
        <section id="lady_image">
            <img src="./images/image.svg" alt="">
        </section>
        <section id="register_section">
            <p id="error"></p>
            <form id="register_container" class="rlogin_box" method="post">
                <h1>REGISTER</h1>
                <input id="register_username1" type="text" name="username" placeholder="Username" autocomplete="off" required>
                <input type="text" name="name" placeholder="Name" autocomplete="off" required>
                <input type="email" name="email" placeholder="Email" autocomplete="off" required>
                <input type="password" name="password" placeholder="Password" autocomplete="off" required>
                <input type="password" name="confirmPass" placeholder="Confirm Password" autocomplete="off" required>
                <p id="already">Already Registered? <a onclick="login()">Login</a></p>
                <button id="register_button" name = "register">Register</button>
            </form>
        </section>
    </main>

    <div id="template">
        <form id="register_container" class="rlogin_box" method="post">
            <h1>REGISTER</h1>
            <input type="text" name="username" placeholder="Username" autocomplete="off" required>
            <input type="text" name="name" placeholder="Name" autocomplete="off" required>
            <input type="email" name="email" placeholder="Email" autocomplete="off" required>
            <input type="password" name="password" placeholder="Password" autocomplete="off" required>
            <input type="password" name="confirmPass" placeholder="Confirm Password" autocomplete="off" required>
            <p id="already">Already Registered? <a onclick="login()">Login</a></p>
            <button id="register_button" name = "register">Register</button>
        </form>

        <form id="login_container" class="rlogin_box" method="post">
            <h1>LOGIN</h1>
            <input type="text" name="login_username" placeholder="Username" autocomplete="off" required>
            <input type="password" name="login_password" placeholder="Password" autocomplete="off" required>
            <p id="already">New User? <a onclick="register()">Register</a></p>
            <button id="register_button" name="login">Login</button>
            <div id="social_media">
                <a href="https://www.instagram.com/mr_kkk_908/" target="_blank"><img src="./images/instagram-icon.svg" alt=""></a>
                <a href="https://twitter.com/Krishnkantkkk" target="_blank"><img src="./images/twitter-icon.svg" alt=""></a>
                <a href="https://mail.google.com/mail/u/0/#inbox?compose=DmwnWrRlQQNVSPhNbjfQqNwkjRtSjVrjxjmQXBcstrTzBBnWnVvsDGcMXFZQpwMpgFXSXcSLHTJg" target="_blank"><img src="./images/gmail-icon.svg" alt=""></a>
                <a href="https://github.com/krishnkantkkkk" target="_blank"><img src="./images/github-icon.svg" alt=""></a>
                <a href="https://www.linkedin.com/in/krishn-kant-kumar-9630861a0/" target="_blank"><img src="./images/linkedin-icon.svg" alt=""></a>
            </div>
        </form>
    </div>
    <script>
        let register_section = document.getElementById("register_section");
        let register_container = document.getElementById("register_container");
        let login_container = document.getElementById("login_container");
        let error = document.getElementById("error");
        register_container.onclick =function(){error.innerText=""};
        login_container.onclick =function(){error.innerText=""};
        document.getElementById("register_username1").focus();

        function login()
        {
            register_section.innerHTML = "";
            register_section.appendChild(error);
            register_section.appendChild(login_container);
        }

        function register()
        {
            register_section.innerHTML = "";
            register_section.appendChild(error);
            register_section.appendChild(register_container);
        }

        // Navbar
        document.getElementById("slider-menu").style = "display:none;";
        var get_started_button = document.getElementById("get_started_button");
        get_started_button.style = "display:none";
    </script>
</body>
</html>

<?php
    if(isset($_POST['register']))
    {
        $username = $_POST['username'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $cpassword = $_POST['confirmPass'];
        $check_username = $users->query("select * from usernames where username =  '$username'");

            if(mysqli_num_rows($check_username)) 
            {
                echo "  <script>
                        if(window.history.replaceState)
                            {
                                window.history.replaceState(null, null, window.location.href);
                            }
                    </script>";
                echo "<script>document.getElementById('error').innerText='Username Already Exists.'</script>";
            }
            else 
            {
                if($password === $cpassword)
                {
                    $users->query("insert into usernames values(NULL, '$username', '$name', '$email', '$password')");
                    $users_borrowers->query("CREATE TABLE $username (Id INT PRIMARY KEY NOT NULL AUTO_INCREMENT, Name VARCHAR(50), Amount INT);");
                    $logged_in->query("insert into username values('$username')");
                    header("Location:main.php?username=$username");
                    ob_end_flush();
                }
                else 
                {
                    echo "  <script>
                                if(window.history.replaceState)
                                    {
                                        window.history.replaceState(null, null, window.location.href);
                                    }
                            </script>";
                    echo "<script>document.getElementById('error').innerText='Password and Confirm Password Mismatched.'</script>";
                }
            }  
    }

    if(isset($_POST["login"]))
    {
        $username = $_POST["login_username"];
        $password = $_POST["login_password"];

        $check_username = $users->query("select * from usernames where username = '$username'");
        if(mysqli_num_rows($check_username))
        {
            $check_password = mysqli_fetch_assoc($users->query("select * from usernames where username = '$username'"))["password"];
            if($password === $check_password)
            {
                $logged_in->query("insert into username values('$username')");
                header("Location:main.php");
                ob_end_flush();
            }
            else 
            {
                echo "  <script>
                        if(window.history.replaceState)
                            {
                                window.history.replaceState(null, null, window.location.href);
                            }
                    </script>";
                echo "<script>document.getElementById('error').innerText='Wrong Password, Try Again.';login();</script>";
            }
        }
        else 
        {
            echo "  <script>
                        if(window.history.replaceState)
                            {
                                window.history.replaceState(null, null, window.location.href);
                            }
                    </script>";
            echo "<script>document.getElementById('error').innerText='User Does not Exists.';login();</script>";
        }
    }

?>