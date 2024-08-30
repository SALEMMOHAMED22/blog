<?php
require_once '../../inc/connection.php';

if( isset($_POST['submit'])){

    $name = trim(htmlspecialchars($_POST['name']));
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));
    $phone = trim(htmlspecialchars($_POST['phone']));

    // validation:

    $hashedPassword = password_hash($password,PASSWORD_DEFAULT);

    $query = "insert into users(`name`,`email` ,`password`,`phone`) values('$name','$email','$hashedPassword' ,'$phone')";
    $runQuery = mysqli_query($conn,$query);
    if($runQuery){
        header("location: ../../login.php");

    }else{
        header("location: ../register.php");
    }

}else{
    header("location:../register.php");
}


?>