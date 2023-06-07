<?php
$showAlert=false;
$showErr=false;
if($_SERVER["REQUEST_METHOD"]=="POST"){
    include "partials/_dbconnect.php";
    $username=$_POST['username'];
    $password=$_POST['password'];
    $cpassword=$_POST['cpassword'];
    // $exists=false;
    // Check whether this username exists or not
    $existSql = "SELECT * FROM `users` WHERE username='$username'";
    $result = mysqli_query($conn, $existSql);
    $numExistsRows=mysqli_num_rows($result);
    if($numExistsRows>0){
      $showErr="Username already exists";
    }else{

      if(($password==$cpassword)){
        $hash=password_hash($password,PASSWORD_DEFAULT);
        $sql="INSERT INTO `users` (`username`, `password`, `cdate`) VALUES ('$username', '$hash', CURRENT_TIMESTAMP);";
        $result=mysqli_query($conn,$sql);
        if($result){
          $showAlert=true;
        }
      }else{
        $showErr="Password donot match";
      }
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SignUp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  </head>
  <body>
    <?php require 'partials/_nav.php'
    ?>
    <?php
    if($showAlert){
        echo '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>success</strong>Your account has been created and you can login now
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        ';
    }
    if($showErr){
        echo '
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error </strong>'.$showErr.'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        ';
    }
    
    ?>
    
    <div class="container">
        <h1 class="text-center">SignUp to our website</h1>
        <form action="/loginSystem/signup.php"  method="post">
  <div class="mb-3 col-md-6">
    <label for="username" class="form-label">Username</label>
    <input maxlength="11" type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp">
  </div>
  <div class="mb-3 col-md-6">
    <label for="password" class="form-label">Password</label>
    <input maxlength="21" type="password" class="form-control" id="password" name="password">
  </div>
  <div class="mb-3 col-md-6">
    <label for="cpassword" class="form-label">Confirm Password</label>
    <input type="password" class="form-control" id="cpassword" name="cpassword">
    <div id="emailHelp" class="form-text">Make sure to type the same password</div>
  </div>
  <button type="submit" class="btn btn-primary">Signup</button>
</form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>