<?php
    session_start();
    if (isset($_POST["send"])){
        $code = $_POST['code'];
        $error = "";
        if ((int)$code != (int)$_SESSION["num_random"]){
            $error = "Неправильный код";
        }else{
            $mysqli = new mysqli("localhost", "a0453884_root", "root", "a0453884_users_site");
            $mysqli->query("SET NAMES 'utf8'");
            $login = $_SESSION['login'];
            $email = $_SESSION['email'];
            $pass = $_SESSION['pass'];
            $repass = $_SESSION['repass'];
            $_SESSION['reg'] = 1;
            $mysqli->query("INSERT INTO `users` (`id`, `login`, `email`, `password`, `repassword`) VALUES (NULL, '$login', '$email', '$pass', '$repass')");
            header("Location: /akkaunt.php");

        }
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Код подтверждения</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3>Введите код подтверждения высланный вам на почту</h3>
    <form action="" method="post">
        <input type="number" name="code" id="code" placeholder="Введите код" class="form-control"><br>
        <span style="color: red"><?=$error?></span><br>
        <input type="submit" name="send" class="btn btn-success" value="Отправить">
    </form>
</div>
</body>
</html>