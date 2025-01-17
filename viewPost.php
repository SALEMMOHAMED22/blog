<?php 
require_once 'inc/connection.php' ;
require_once 'inc/header.php' ;
?>

    <!-- Page Content -->
    <div class="page-heading products-heading header-text">
       <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-content">
              <h4>View Post</h4>
              <h2>View personal post</h2>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php
    if(isset($_GET['id'])){
      $id = $_GET['id'];
      $query = " select * from posts  where id=$id " ;
      $runQuery = mysqli_query($conn,$query);
      if(mysqli_num_rows($runQuery)==1){
          $post = mysqli_fetch_assoc($runQuery);
      }else{
        $_SESSION['errors'] = ["post not founded"];
        header("location: index.php");
      }
    }else{
      $_SESSION['errors'] = ["post not founded"];
      header("location: index.php");
    }
    
    ?>
    
    <div class="best-features about-features">
      <div class="container">
        ?<?php
          require_once 'inc/errors.php';
        ?>
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <h2>Our Post Image</h2>
            </div>
          </div>
          <div class="col-md-6">
            <div class="right-image">
              <img src="uploads/<?php echo $post['image']?>" alt="">
            </div>
          </div>
          <div class="col-md-6">
            <div class="left-content">
              <h4><?php echo $post['title']?></h4>
              <p><?php echo $post['body']?></p>
              
              <?php
              if(isset($_SESSION['user_id'])){
              ?>
              <div class="d-flex justify-content-center">
                  <a href="editPost.php?id=<?php echo $post['id']?>" class="btn btn-success mr-3"> edit post</a>
                    <form action="handle/deletePost.php?id=<?php echo $post['id']?>" method="post">
                          <button type="submit" name="submit" class="btn btn-danger "  onclick="alert('are you s ure!')" >delete</button>
                    </form>
              </div>
              <?php
              }
              ?>
            </div>
          </div>
        </div>
      </div>
</div>

    <?php require_once 'inc/footer.php' ?>
