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
      $password = password_hash(htmlspecialchars($_POST['password']),PASSWORD_DEFAULT);
      //check whether the user already exist
      $checkUser = $conn->prepare("select username from user where username = ?");
      $checkUser->bind_param("s", 
        $username,
      );
      $checkUser->execute();
      $isExist = $checkUser->get_result()->num_rows > 0;
      if ($isExist) {
        print('User Already Exist');
      }
      else {
        $stmt = $conn->prepare("insert into user (username, password) values (?, ?)");
      $stmt->bind_param("ss", 
        $username,
        $password
      );
      $stmt->execute();
      print("Signed up successfully"); 
      }
    }
  ?>
   </p>
</body>
<?php $conn->close();?>