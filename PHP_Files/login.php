<?php
session_start();
$sql = new PDO('mysql:host=localhost; dbname=food_diary', "root", "****");
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = $sql->prepare("SELECT * FROM userinfo WHERE username=:username");
    $query->bindParam("username", $username, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    if (!$result) {
        include('../HTML_Files/Login.html');
        echo '<label class="title_err">Wrong password or username!</label>';

    } else {
        if (password_verify($password, $result['password'])) {
            $_SESSION['user_id'] = $result['idUsers'];
            $_SESSION['name'] = $result['name'];
            $_SESSION['LogName'] = $result['username'];
            echo '<meta http-equiv="refresh" content="0; url= ../HTML_Files/WebSite.html">';
        } else {
            echo '<label class="title_err">Wrong password or username!</label>';
        }
    }
}

?>