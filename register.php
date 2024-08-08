<?php
    ob_start();
    session_unset();
    session_start();
    require_once("data.php");
    if(isset($_SESSION['logged_in'])) header("Location:main.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles/register.css">
    <link rel="stylesheet" href="styles/style.css">
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
                <input id="register_username" type="text" name="username" placeholder="Username" autocomplete="off" required>
                <input type="text" name="name" placeholder="Name" autocomplete="off" required>
                <input type="tel" name="phone" placeholder="Phone" autocomplete="off" required>
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
            <input type="text" id="login_username" name="login_username" placeholder="Username/Phone" autocomplete="off" required>
            <input type="password" name="login_password" placeholder="Password" autocomplete="off" required>
            <p id="already">New User? <a onclick="register()">Register</a></p>
            <button id="register_button" name="login">Login</button>
            <div id="social_media">
                <a href="https://www.instagram.com/Krishna_kkk_908/" target="_blank"><img src="./images/instagram-icon.svg" alt=""></a>
                <a href="https://twitter.com/Krishnkantkkk" target="_blank"><img src="./images/twitter-icon.svg" alt=""></a>
                <a href="https://mail.google.com/mail/u/0/#inbox?compose=DmwnWrRlQQNVSPhNbjfQqNwkjRtSjVrjxjmQXBcstrTzBBnWnVvsDGcMXFZQpwMpgFXSXcSLHTJg" target="_blank"><img src="./images/gmail-icon.svg" alt=""></a>
                <a href="https://github.com/krishnkantkkkk" target="_blank"><img src="./images/github-icon.svg" alt=""></a>
                <a href="https://www.linkedin.com/in/krishn-kant-kumar-9630861a0/" target="_blank"><img src="./images/linkedin-icon.svg" alt=""></a>
            </div>
        </form>
    </div>
    <script src="scripts/register.js"></script>
</body>
</html>

<?php
    if(isset($_POST['register']))
    {
        $username = $_POST['username'];
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $cpassword = $_POST['confirmPass'];
        $check_username = $users->query("select * from users where username =  '$username'");
        $check_phone = $users->query("select * from users where phone =  '$phone'");

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
            else if(mysqli_num_rows($check_phone))
            {
                $is_username_null = mysqli_fetch_assoc($users->query("SELECT * FROM users WHERE phone = $phone"))['username'];
                if($is_username_null)
                {
                    echo "  <script>
                            if(window.history.replaceState)
                            {
                                window.history.replaceState(null, null, window.location.href);
                            }
                            document.getElementById('error').innerText='Phone Already Registered.';
                            </script>";
                }
                else
                {
                    if($password === $cpassword)
                    {
                        $users->query("UPDATE users SET username='$username', name='$name', password='$password' WHERE(phone = $phone)");
                        $user_id = mysqli_fetch_assoc($users->query("select * from users where username = '$username'"))['user_id'];
                        $_SESSION['logged_in'] = $user_id;
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
                        echo "<script>document.getElementById('error').innerText='Password and Confirm Password Mismatched.'</script>";
                    }
                }
            }
            else 
            {
                if($password === $cpassword)
                {
                    $users->query("insert into users values(NULL, '$username', '$name', '$phone', '$password')");
                    $user_id = mysqli_fetch_assoc($users->query("select * from users where username = '$username'"))['user_id'];
                    $_SESSION['logged_in'] = $user_id;
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
                    echo "<script>document.getElementById('error').innerText='Password and Confirm Password Mismatched.'</script>";
                }
            }  
    }

    if(isset($_POST["login"]))
    {
        $input = $_POST["login_username"];
        $password = $_POST["login_password"];
        $username = mysqli_fetch_assoc($users->query("select * from users where username = '$input' or phone = '$input'"))["username"];
        $user_id = mysqli_fetch_assoc($users->query("select * from users where username = '$input' or phone = '$input'"))["user_id"];

        $check_username = $users->query("select * from users where username = '$input'");
        $check_phone = $users->query("select * from users where phone = '$input'");
        if(mysqli_num_rows($check_username)||mysqli_num_rows($check_phone))
        {
            $check_password = mysqli_fetch_assoc($users->query("select * from users where username = '$input' or phone = '$input'"))["password"];
            if($password === $check_password)
            {
                $_SESSION['logged_in'] = $user_id;
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