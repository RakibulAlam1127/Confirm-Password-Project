<?php
//Our Php Code will be goes here.
$errors = [];
$username= $email = $password = $confirm_password = '';

if (isset($_POST['register'])){
  function validation($data){
      $data = htmlentities($data);
      $data = htmlspecialchars($data);
      $data = stripslashes($data);
      $data = trim($data);
      return $data;
  }
  if (empty($_POST['username'])){
      $errors['username'] = 'Username is Required';
  }else{
      $username = validation($_POST['username']);
  }
  if (empty($_POST['email'])){
      $errors['email']='Email is Required';
  }else{
      $email = validation($_POST['email']);
      if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
          $errors['email'] = 'Please Enter the Valid Email';
      }
  }
  if (empty($_POST['password'])){
        $errors['password'] = 'Password Must be Required';
  }else{
      $password = validation($_POST['password']);
      if (strlen($password < 5)){
          $errors['password'] = 'Password Must be At least 6 Character';
      }
  }
  if (empty($_POST['confirm_password'])){
     $errors['confirm_password'] = 'Confirm Password Field Must Not be Empty';
  }else{
      $confirm_password = validation($_POST['confirm_password']);
      if (strlen($confirm_password) < 5){
          $errors['confirm_password'] = 'Confirm Password Must be At least 6 Character';
      }
  }
  if ($password === $confirm_password) {
      $password = password_hash($password, PASSWORD_BCRYPT);
  }else{
      $errors['confirm_password'] = 'Password Does not Match';
  }

  if (empty($errors)){
     //Our Database Code will be goes here.
      $connection = mysqli_connect('localhost','root','','sample_db');
       if ($connection == true){
           $sql = "INSERT INTO users(username,email,password)VALUES ('$username','$email','$password')";
           $stmt = mysqli_query($connection,$sql);
           if ($stmt == true){
              header('Location:login.php');
           }else{
               echo mysqli_error($connection);
               exit();
           }
       }else{
           echo mysqli_connect_errno();
           exit();
       }
  }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>registration</title>
    <style>
        body{
            margin-top: 50px;
            background-image:url("limon.jpeg");

        }
    </style>
</head>
<body>
    <div class="container col-md-8">
             <div class="card">
                  <div class="card-header">
                       <h1 style="text-align: center">Registration Page </h1>
                  </div>
                 <div class="card-body">
                       <?php
                         if (!empty($success)) {
                             ?>
                             <div class="alert alert-success"><?php echo $success; ?></div>
                             <?php
                         }
                       ?>
                     <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
                         <div class="form-group">
                             <label for="username">Username</label>
                             <input type="text" name="username" class="form-control" placeholder="Username" autofocus>
                             <?php
                               if (isset($errors['username'])){
                                   ?>
                                   <div class="alert alert-danger"><?php echo $errors['username']; ?></div>
                             <?php
                               }
                             ?>
                         </div>
                         <div class="form-group">
                             <label for="email">Email</label>
                             <input type="email" name="email" class="form-control" placeholder="E-mail" autofocus>
                             <?php
                             if (isset($errors['email'])){
                                 ?>
                                 <div class="alert alert-danger"><?php echo $errors['email']; ?></div>
                                 <?php
                             }
                             ?>
                         </div>
                         <div class="form-group">
                             <label for="username">Password</label>
                             <input type="password" name="password" class="form-control" placeholder="******" autofocus>
                             <?php
                             if (isset($errors['password'])){
                                 ?>
                                 <div class="alert alert-danger"><?php echo $errors['password']; ?></div>
                                 <?php
                             }
                             ?>
                         </div>
                         <div class="form-group">
                             <label for="username">Confirm Password</label>
                             <input type="password" name="confirm_password" class="form-control" placeholder="******" autofocus>
                             <?php
                             if (isset($errors['confirm_password'])){
                                 ?>
                                 <div class="alert alert-danger"><?php echo $errors['confirm_password']; ?></div>
                                 <?php
                             }
                             ?>
                         </div>
                         <div class="form-group">
                             <input type="submit" name="register" class="form-control btn btn-primary" value="Registration">
                         </div>
                     </form>
                 </div>
             </div>
    </div>
</body>
</html>