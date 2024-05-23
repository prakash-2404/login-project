<?php

include 'config.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $message[] = 'user already exist'; 
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }elseif($image_size > 2000000){
         $message[] = 'image size is too large!';
      }else{
         $insert = mysqli_query($conn, "INSERT INTO `user_form`(name, email, password, image) VALUES('$name', '$email', '$pass', '$image')") or die('query failed');

         if($insert){
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'registered successfully!';
            header('location:index.php');
         }else{
            $message[] = 'registeration failed!';
         }
      }
   }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">

</head>
<body>
<div class="box">
   <div class="container">

      <form method="post" action="" enctype="multipart/form-data">
         <header>Register now</header>
         <br>
         <?php
         if(isset($message)){
            foreach($message as $message){
               echo '<div class="message">'.$message.'</div>';
            }
         }
         ?>
      <div class="input-field">   
         <input type="text" class="input" name="name" required placeholder="enter your name">
         <i class='bx bx-user' ></i>
      </div>

      <div class="input-field">
         <input type="email" class="input" name="email" required placeholder="enter your email">
         <i class='bx bx-user' ></i>
      </div>

      <div class="input-field">   
         <input type="password" class="input" name="password" required placeholder="enter your password">
         <i class='bx bx-lock-alt'></i>
      </div>

      <div class="input-field">   
         <input type="password" class="input" name="cpassword" required placeholder="confirm your password">
         <i class='bx bx-lock-alt'></i>
      </div>   

      <div class="input-field">   
         <input type="submit" class="submit" name="submit" value="Register" >
      </div>   
      </form>

        <br>
         <p style="color: white; text-align: center;">already have an account?  <a href="index.php">login now</a></p>
 

   </div>
</div> 


</body>
</html>