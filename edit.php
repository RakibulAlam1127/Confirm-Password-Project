<?php
//Our Php Code will be goes here.
 $id = $_GET['id'];
 $id = (int) $id;
 if ($id === 0){
    header('Location:login.php');
 }
 $connection = mysqli_connect('localhost','root','','sample_db');
 if ($connection == false){
     echo mysqli_connect_errno();
     exit();
 }else{

     if (isset($_POST['upgrade'])){
         $errors = [];
         $username = $email = '';
         function validation($data){
             $data = htmlspecialchars($data);
             $data = htmlentities($data);
             $data = stripslashes($data);
             $data = trim($data);
             return $data;
         }
         if (empty($_POST['username'])){
             $errors['username'] = 'Username Must be Required';
         }else{
             $username = validation($_POST['username']);
         }
         if (empty($_POST['email'])){
             $errors['email'] = 'Email Must be Required';
         }else{
             $email = validation($_POST['email']);
             if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
                 $errors['email'] = 'Please Enter the Valid Email';
             }
         }
         if (empty($errors)){
             //Our database code will be goes here.
             $sql_query = "UPDATE users SET username = '$username',email = '$email' WHERE id='$id'";
             $stmt = mysqli_query($connection,$sql_query);
             if ($stmt == false){
                 echo mysqli_error($connection);
                 exit();
             }else{
                 header('Location:view.php');
             }
         }
     }

     $sql = "SELECT id,username,email FROM users WHERE id = '$id'";
     $stmt = mysqli_query($connection,$sql);
     $data = mysqli_fetch_assoc($stmt);

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
            <h1 style="text-align: center">Upgrade Your Profile </h1>
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
                    <input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo $data['username']; ?>" autofocus>
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
                    <input type="email" name="email" class="form-control" placeholder="E-mail" value="<?php echo $data['email']; ?>" autofocus>
                    <?php
                    if (isset($errors['email'])){
                        ?>
                        <div class="alert alert-danger"><?php echo $errors['email']; ?></div>
                        <?php
                    }
                    ?>
                </div>


                <div class="form-group">
                    <input type="submit" name="upgrade" class="form-control btn btn-primary" value="Upgrade">
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>