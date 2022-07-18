<?php
    include 'config.php';
    session_start();
    $user_id= $_SESSION['user_id'];

    if(isset($_POST['update_profile'])){

        $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
        $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);
        $update_number = mysqli_real_escape_string($conn, $_POST['update_number']);

        mysqli_query($conn, "UPDATE `user_form` SET name = '$update_name', email='$update_email', number='$update_number' WHERE id='$user_id'") or die('query failed');

        $old_password = $_POST['old_password'];
        $update_password = mysqli_real_escape_string($conn, md5($_POST['update_password']));
        $new_password = mysqli_real_escape_string($conn, md5($_POST['new_password']));
        $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm_password']));

        if(!empty($update_password) || !empty($new_password) || !empty($confirm_password)){
            if($update_password != $old_password){
               $message[] = 'old password not matched!';
            }elseif($new_password != $confirm_password){
               $message[] = 'confirm password not matched!';
            }else{
               mysqli_query($conn, "UPDATE `user_form` SET password = '$confirm_password' WHERE id = '$user_id'") or die('query failed');
               $message[] = 'password updated successfully!';
            }

            $update_image = $_FILES['update_image']['name'];
            $update_image_size = $_FILES['update_image']['size'];
            $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
            $update_image_folder = 'upload/'.$update_image;
         
            if(!empty($update_image)){
               if($update_image_size > 2000000){
                  $message[] = 'image is too large';
               }else{
                  $image_update_query = mysqli_query($conn, "UPDATE `user_form` SET image = '$update_image' WHERE id = '$user_id'") or die('query failed');
                  if($image_update_query){
                     move_uploaded_file($update_image_tmp_name, $update_image_folder);
                  }
                  $message[] = 'image updated succssfully!';
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
    <title>Update profile</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>
<body>

    <div class="container">
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


                <form action="" method="post" enctype="multipart/form-data">
                    <div class="flex">
                        <div class="inputbox">
                            <span>Name:</span>
                            <input type="text" name="update_name" value="<?php echo $fetch['name'];?>" class="box">
                            <span>Email:</span>
                            <input type="email" name="update_email" value="<?php echo $fetch['email'];?>" class="box">
                            <span>Image:</span>
                            <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">
                            <span>Number:</span>
                            <input type="text" name="update_number" value="<?php echo $fetch['number'];?>" class="box">
                        </div>
                        <div class="inputBox">
                            <input type="hidden" name="old_password" value="<?php echo $fetch['password']; ?>">
                            <span>old password :</span>
                            <input type="password" name="update_password" placeholder="enter previous password" class="box">
                            <span>new password :</span>
                            <input type="password" name="new_password" placeholder="enter new password" class="box">
                            <span>confirm password :</span>
                            <input type="password" name="confirm_password" placeholder="confirm new password" class="box">
                        </div>
                        <button name="update_profile" class="btn btn-info">Update profile</button>
                        <a href="home.php" class="btn btn-warning">Home</a>
                    </div>
                </form>
    </div>
  
</body>
</html>