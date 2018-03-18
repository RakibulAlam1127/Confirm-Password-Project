<?php
//Our Php Code will be goes here.
$errors = [];
 $email = $password = '';

if (isset($_POST['login'])) {
    function validation($data)
    {
        $data = htmlentities($data);
        $data = htmlspecialchars($data);
        $data = stripslashes($data);
        $data = trim($data);
        return $data;
    }

    if (empty($_POST['email'])) {
        $errors[] = 'Email is Required';
    } else {
        $email = validation($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please Enter the Valid Email';
        }
    }
    if (empty($_POST['password'])) {
        $errors[] = 'Password Must be Required';
    } else {
        $password = validation($_POST['password']);
        if (strlen($password < 5)) {
            $errors[] = 'Password Must be At least 6 Character';
        }
    }

    if (empty($errors)) {
        //Our Database Code will be goes here.
        $connection = mysqli_connect('localhost','root','','sample_db');
       if ($connection == false){
           echo mysqli_connect_errno();
           exit();
       }else{
           $sql = "SELECT id,email,password FROM users WHERE email = '$email'";
           $stmt = mysqli_query($connection,$sql);
           $result = mysqli_num_rows($stmt);
           if ($result > 0){
               $data = mysqli_fetch_assoc($stmt);

               if (password_verify($password,$data['password']) === true){
                 header('Location:view.php');
               }else{
                   $errors[] = 'You are Enter Wrong Password';
               }
           }else{
               $errors[] = 'Email Address Not Found';
           }
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
            <?php
              if (isset($errors)){
                  foreach ($errors as $error){
                      ?>
                      <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php
                  }
              }
            ?>
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="E-mail" autofocus>
                </div>
                <div class="form-group">
                    <label for="username">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="******" autofocus>

                </div>

                <div class="form-group">
                    <input type="submit" name="login" class="form-control btn btn-primary" value="Login">
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>