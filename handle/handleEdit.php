<?php
require_once '../inc/connection.php';

if(isset($_POST['submit']) && isset($_GET['id'])){
    $id = $_GET['id'];
    $title = htmlspecialchars(trim($_POST['title']));
    $body = htmlspecialchars(trim($_POST['body']));
    //validation 
    $errors = [];
    //title : 
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
     $query = " select * from posts  where id=$id " ;
      $runQuery = mysqli_query($conn,$query);
      if(mysqli_num_rows($runQuery)==1){

    $oldImage = mysqli_fetch_assoc($runQuery)['image'];
         
     
    

    

    // image :
    if( isset($_FILES['image']) && $_FILES['image']['name']){
    $image = $_FILES['image'];
    $imageName = $image['name'];
    $imagetmpName = $image['tmp_name'];
    $size = $image['size'] / (1024 * 1024);
    $ext = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
    $error = $image['error'];

    $arr_ext = ['png', 'jpg', 'jpeg', 'gif'];

        if ($error != 0) {
            $errors[] = "image is required";
        } elseif (!in_array($ext, $arr_ext)) {
            $errors[] = "image not correct";
        } elseif ($size > 1) {
            $errors[] = "image large size ";
        }
    $newName = uniqid() . "." . $ext;

    }else{
        $newName = $oldImage;
    }
        
    if(empty($errors)){
        $query = "update posts set `title` = '$title' , `body`= '$body' , `image`= '$newName' where id=$id ";
        $runQuery =  mysqli_query($conn,$query);
        if($runQuery){
    if( isset($_FILES['image']) && $_FILES['image']['name']){
        unlink("../uploads/$oldImage");
        move_uploaded_file($imagetmpName,"../uploads/$newName");
    }

            $_SESSION['success'] = "post updated successfuly ";
            header("location: ../viewPost.php?id=$id");
        }else{
            $_SESSION['errors'] = ["error while update"];
            header("location: ../editPost.php?id=$id");
        }
        
    }else{
        $_SESSION['errors'] = $errors;
        header("location: ../editPost.php?id=$id");
    }



      }else{
        $_SESSION['errors'] = ["post not found"];
        header("location: ../index.php");
      }
}else{
    header("location: ../index.php");
}





?>