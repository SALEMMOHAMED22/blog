
<?php
require_once '../inc/connection.php';
if(! isset($_SESSION['user_id'])){
    header("location: ../Login.php");
}else{

?>

<?php
  

  if(isset($_POST['submit']) && isset($_GET['id'])){
    $id = $_GET['id'];
    $query = " select id from posts where id=$id";
    $runQuery = mysqli_query($conn , $query);
    if(mysqli_num_rows($runQuery)==1){
            $post = mysqli_fetch_assoc($runQuery);
            if(! empty($post)){
        unlink("../uploads/".$post['image']); 
    }
        $query = "delete from posts where id = $id";
        $runQuery = mysqli_query($conn, $query);
        if($runQuery){
            $_SESSION['success'] = "post deleted successfuly";
            header("location: ../index.php");

        }else{
            $_SESSION['errors'] = ["error while deleting"];
              header("location: ../index.php");

        }

    }else{
        $_SESSION['errors']= ["post not found"];
        header("location: ../index.php");
      }
    

  }else{
    $_SESSION['errors']= ["please choose correct operation"];
    header("location: ../index.php");
  }
}
?>