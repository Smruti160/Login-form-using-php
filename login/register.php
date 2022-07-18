<?php
    include 'config.php';

    if(isset($_POST['submit'])){
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));
        $cpassword = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
        $image = $_FILES['image']['name'];
        $image_size=$_FILES['image']['size'];
        $img_temp_name=$_FILES['image']['tmp_name'];
        $image_folder='upload/'.$image;
        $number = mysqli_real_escape_string($conn, $_POST['number']);
        $gender= mysqli_real_escape_string($conn, $_POST['gender']);
        $subject= mysqli_real_escape_string($conn, $_POST['subject']);

        $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = 'email' AND password='$password'") or die('query failed');

        if(mysqli_num_rows($select)>0){
            $message[]='user already exist';
        }else{
            if($password != $cpassword){
                $message[] = 'confirm password not matched!';
            }elseif($image_size > 2000000){
                $message[]='image is too larged!';
            }else{
                $insert=mysqli_query($conn, "INSERT INTO `user_form`(name, email, password, image, number, gender, subject) VALUES('$name', '$email','$password','$image', '$number', '$gender', '$subject')") or die('query failed');

                if($insert){
                    move_uploaded_file($img_temp_name, $image_folder);
                    $message[]='registered successfully';
                    header('location:login.php');
                }else{
                    $message[]='registration failed';
                }
            }
        }
    }
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compactible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">
            <h2>REGISTRATION</h2>
            <?php
                if(isset($message)){
                    foreach($message as $message){
                        echo '<div class="message">'.$message.'</div>';
                    }
                }
            ?>
            <div>
                <label for="">Name:</label>
                <input type="text" name="name" placeholder="Enter Name" class="box" required>
            </div>
            <div>
                <label for="">Email:</label>
                <input type="email" name="email" placeholder="Enter your email" class="box" required>
            </div>
            <div>
                <label for="">Password:</label>
                <input type="password" name="password" placeholder="Enter Password" class="box" required>
            </div>
            <div>
                <label for="">Confirm Password:</label>
                <input type="password" name="cpassword" placeholder="Confirm Password" class="box" required>
            </div>
            <div>
                <label for="">Upload Image:</label>
                <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
            </div>
            <div>
                <label for="">Phone number:</label>
                <input type="text" name="number" placeholder="Enter number" class="box" required>
            </div>
            <div>
                <label for="">Select your Gender:</label>
                <select class="box" required>
                    <option name="gender" value="male" required>Male</option>
                    <option name="gender" value="female">Female</option>
                    <option name="gender" value="transgender">Transgender</option>
                    <option name="gender" value="no">Donot want to disclose</option>
                </select>
            </div>
            <h6>Subject:</h6>
            <div class="form-check">
                
                <input class="form-check-input" value="php" name="subject" type="checkbox" required>
                <p>PHP</p>
                <input class="form-check-input" value="C++" name="subject" type="checkbox">
                <p>C++</p>
                <input class="form-check-input" value="java" name="subject" type="checkbox">
                <p>Java</p>
                <input class="form-check-input" value="python" name="subject" type="checkbox">
                <p>Python</p>
            </div>
            <button class="btn btn-primary" name="submit">Register</button>
            <p>already have an account?<a href="login.php">login now</a> </p>
        </form>
    </div>
    


</body>
</html>