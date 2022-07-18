<?php
    include 'config.php';
    session_start();
    $user_id = $_SESSION['user_id'];

    if(!isset($user_id)){
        header('location:login.php');
    }
    if(isset($_GET['logout'])){
        unset($user_id);
        session_destroy();
        header('location:login.php');
     }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compactible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/style2.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>
<body>

    <div class="container">
        <div class="profile">
            <?php
                $select = mysqli_query($conn, "SELECT * FROM `user_form` where id = '$user_id'") or die('query failed');
                if(mysqli_num_rows($select) > 0){
                    $fetch = mysqli_fetch_assoc($select);
                }
                
                if($fetch['image'] == ''){
                    echo '<img src="images/download.png">';
                }else{
                    echo '<img src="upload/'.$fetch['image'].'">';
                }
            ?>
                <h2><?php echo $fetch['name']; ?></h2>
                <h2><?php echo $fetch['number']; ?></h2>
                <h2><?php echo $fetch['email']; ?></h2>
                
                <button class="btn btn-info"><a href="update_profile.php">update profile</a></button>
                <button class="btn btn-warning"><a href="home.php?logout=<?php echo $user_id;?>">log out</a></button>
                <p>new <a href="login.php">login</a> or <a href="register.php">register</a></p>

            
        </div>
    </div>


</body>
</html>