<?php
session_start();
$sql = new PDO('mysql:host=localhost; dbname=food_diary', "root", "****");
if (isset($_POST['register'])) {
    $username = htmlspecialchars($_POST['username']);
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    $query = $sql->prepare("SELECT * FROM userinfo WHERE email=:email OR username=:username");
    $query->bindParam("username",$username,PDO::PARAM_STR);
    $query->bindParam("email", $email, PDO::PARAM_STR);
    $query->execute();
    if ($query->rowCount() > 0) {
        include("../HTML_Files/Registration.html");
        echo '<label class="rtitle_err">This email or username is already registered!</label>';
    }
    if ($query->rowCount() == 0) {
        $query = $sql->prepare("INSERT INTO userinfo(username,name,password,email) VALUES (:username,:name,:password_hash,:email)");
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->bindParam("name", $name, PDO::PARAM_STR);
        $query->bindParam("password_hash", $password_hash, PDO::PARAM_STR);
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $_SESSION['username'] = $username;
        include('config.php');
        $result = $query->execute();
        if ($result) {
            include("../HTML_Files/Registration.html");
            echo '<label class="rtitle_success">Registration Success!</label>';
        } else {
            include("../HTML_Files/Registration.html");
            echo '<label class="rtitle_err">Wrong data!</label>';
        }
    }
}
?>