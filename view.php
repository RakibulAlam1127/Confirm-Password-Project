<?php
//Our Php code will be goes here
$connection = mysqli_connect('localhost','root','','sample_db');
if ($connection === false){
    echo mysqli_connect_errno();
    exit();
}else{
    $sql = "SELECT id,username,email FROM users";
    $stmt = mysqli_query($connection,$sql);
    if ($stmt === false){
        echo mysqli_error($connection);
        exit();
    }else{
        $result = mysqli_num_rows($stmt);

        $data = mysqli_fetch_all($stmt,1);
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
    <title>Document</title>
    <style>
         body{
             margin-top: 50px;
             background-image: url("r.jpeg");
         }
    </style>
</head>
<body>
     <div class="container col-md-8">
          <div class="card">
             <div class="card-header">
                 <h1 style="text-align: center">View Page</h1>
             </div>
         <div class="card-body">
                 <table class="table table-striped">
                     <thead>
                           <tr>
                               <td>ID</td>
                               <td>Username</td>
                               <td>E-mail</td>
                                <td>Action</td>
                           </tr>
                     </thead>
                     <tbody>
                         <?php
                             foreach($data as $row) {
                                 ?>
                                 <tr>
                                     <td><?php echo $row['id']; ?></td>
                                     <td><?php echo $row['username']; ?></td>
                                     <td><?php echo $row['email']; ?></td>
                                     <td>
                                         <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a> |
                                         <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="confirm('Are You Sure ? ')">Delete</a>
                                     </td>
                                 </tr>
                                 <?php
                              }
                         ?>
                     </tbody>
                 </table>
              </div>
          </div>
     </div>
</body>
</html>