<?php
session_start();
?>
<body>
  <?php include 'menu.html';?>
  <?php include 'mysql_connect.php';?>
<p>
  <?php
    
    if(empty($_POST['username'])){
      print("Username Requred <br/>");
    }
    if(empty($_POST['password'])){
      print("Password Requred");
    }
    else{
      $username = htmlspecialchars($_POST['username']);
      $password = htmlspecialchars($_POST['password']);
      //check whether the user exists
      $checkUser = $conn->prepare("select * from user where username = ?");
      $checkUser->bind_param("s", 
          $username,
      );
      $checkUser->execute();
      $result = $checkUser->get_result();
      if ($result->num_rows == 0) {
        print('No account found');
      }
      else {
        $credential = $result->fetch_assoc();
        if (password_verify($password, $credential['password'])) {
          print('Hi '.$username.', you are logged in.');
          $_SESSION['username'] = $username;
        }
        else {
          print('Wrong password.');
        }
      }
    }
  ?>
  </p>
  
</body>
<?php $conn->close();?>