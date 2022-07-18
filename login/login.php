<?php
    include 'config.php';
    session_start();
    if(isset($_POST['submit'])){

        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));


        $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email' AND password='$password'") or die('query failed');

        if(mysqli_num_rows($select)>0){
            $row = mysqli_fetch_assoc($select);
            $_SESSION['user_id']= $row['id'];
            header('location:home.php');
        }else{
            $message[]='incorrect email or password!';
        }
    }
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compactible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">
            <h2>LOGIN</h2>
            <?php
                if(isset($message)){
                    foreach($message as $message){
                        echo '<div class="message">'.$message.'</div>';
                    }
                }
            ?>
            <div>
                <label for="">Email:</label>
                <input type="email" name="email" placeholder="Enter your email" class="box" required>
            </div>
            <div>
                <label for="">Password:</label>
                <input type="password" name="password" placeholder="Enter Password" class="box" required>
            </div>  
            <button class="btn btn-primary" name="submit">Login</button>
            <p>don't have an account?<a href="register.php">Register now</a> </p>
        </form>
    </div>
    


</body>
</html>