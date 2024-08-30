<?php
require_once '../inc/connection.php';

if( isset($_POST['submit'])){

    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));

    //check email
    $query = "select * from users where `email` = '$email'";
    $runQuery = mysqli_query($conn,$query);
    if(mysqli_num_rows($runQuery)==1){
        $user = mysqli_fetch_assoc($runQuery);
        $id = $user['id'];
        $name = $user['name'];
        $oldPassword = $user['password'];

        $verify = password_verify($password,$oldPassword);
        if($verify){
            $_SESSION['user_id'] = $id;

            $_SESSION['success'] = "welcome $name";
            header("location: ../index.php");

        }else{
            $_SESSION['errors'] = ["credential not correct"];
             header("location: ../Login.php");

        }

    }else{
        $_SESSION['errors'] = ['this account not exist'];
         header("location: ../Login.php");
    }

}else{
    header("location: ../Login.php");

}