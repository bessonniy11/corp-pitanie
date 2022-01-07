<?php
session_start();
$users = 'admin';
$pass = '1111';
if ($_POST['submit']) {
    if ($users == $_POST['user'] and $pass == '1111') {
        $_SESSION['admin'] = $users;
        header("Location: admin.php");
        exit;
    } else echo '<p>Логин или пароль неверны!</p>';
}
?>


<br />
<form method="post">
    Username: <input type="text" name="user" /> <br />
    Password: <input type="password" name="pass" /> <br />
    <input type="submit" name="submit" value="Login" />
</form>

<style>
    form {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        padding: 20px;
        box-shadow: 0 0 3px 0 #484848;
        border-radius: 20px;
    }

    input {
        margin-bottom: 10px;
        border-radius: 20px;
        background: #CACACA;
        outline: none;
        border: none;
        padding: 4px 10px;
        width: 100%;
    }

    input:last-child {
        cursor: pointer;
        margin-top: 15px;
        transition: all 0.3s ease 0s;
        padding: 6px 10px;
    }

    input:last-child:hover {}

    input:focus {
        box-shadow: 0 0 3px 0 #484848;
    }
</style>