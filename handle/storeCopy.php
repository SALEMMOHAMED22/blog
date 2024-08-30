<?php
require_once '../inc/connection.php';
if(isset($_POST['submit'])){

    $tiitle = trim(htmlspecialchars($_POST['title']));
    $body = trim(htmlspecialchars($_POST['body']));

    $image = $_FILES['image'];
    $imageName = $image['name'];
    $imageTmpName = $image['tmp_name'];
    $size = $image['size']/(1024*1024);
    $ext = strtolower(pathinfo($imageName , PATHINFO_EXTENSION));
    $error = $image['error'];
    $newName = uniqid() . "." . $ext;


    $errors = [];
    if (empty($title)) {
        $errors[] = "title is required";
    } elseif (is_numeric($title)) {
        $errors[] = "title must be string ";
    }
    // body:
    if (empty($body)) {
        $errors[] = "body is required";
    } elseif (is_numeric($body)) {
        $errors[] = "body must be string ";
    }

    // image :
    $arr_ext = ['png', 'jpg', 'jpeg', 'gif'];
    if ($error != 0) {
        $errors[] = "image is required";
    } elseif (!in_array($ext, $arr_ext)) {
        $errors[] = "image not correct";
    } elseif ($size > 1) {
        $errors[] = "image large size ";
    }


    if(empty($errors)){
        $query = "insert into posts(`title` , `body` , `image` , `user_id`) values($title ,$body , $newName ,1)";
        $runQuery = mysqli_query($conn , $query);
        if($runQuery){
            move_uploaded_file($imageTmpName , "../uploads/$newName");
            $_SESSION['success'] = "post inserted successfuly";
            header("location: ../index.php");
        }else{
            $_SESSION['errors'] = ["error while inserting"];
            header("location: ../index.php");

        }
    }else {
        $_SESSION['errors'] = $errors;
        $_SESSION['title'] = $title;
        $_SESSION['body'] = $body;
        
        header("location: ../addPost.php");
    }



}else{
    header("location: ../addPost.php");
}