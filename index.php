<?php

include 'config.php';
session_start();

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

   $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $row = mysqli_fetch_assoc($select);
      $_SESSION['user_id'] = $row['id'];
      header('location:home.php');
   }else{
      $message[] = 'incorrect email or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

   <title>login</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">

</head>
<body>
   
<div class="box">
   <div id="container">

      <div id="top">
            <span>Have an account?</span>
            <header>Login</header>
      </div><br>
   <form action="" method="post" enctype="multipart/form-data">
      <?php
      if(isset($message)){
         foreach($message as $message){
            echo '<div class="message">'.$message.'</div>';
         }
      }
      ?>
   <div class="input-field">   
      <input type="email" name="email" placeholder="enter email" class="input" required>
      <i class='bx bx-user' ></i>
   </div>

   <div class="input-field">   
      <input type="password" name="password" placeholder="enter password" class="input" required>
      <i class='bx bx-lock-alt'></i>
   </div> 
   <div class="input-field"> 
      <input type="submit" name="submit" value="login now" class="submit">
   </div>
      <p style="color: white; text-align: center;">don't have an account? <a href="register.php">register now</a></p>
   </form>


   </div>
</div>
</body>
</html>