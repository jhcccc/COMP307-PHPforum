  <?php include 'mysql_connect.php';?>
  <?php session_start(); ?>
  <?php
    //get form input from ajax POST request
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);
    //get username  from PHP session
    $username = $_SESSION['username'];
    //get userID from database
    $IDQuery = $conn->prepare("select id from user where username = ?");
    $IDQuery->bind_param("s",
      $username,
    );
    $IDQuery -> execute();
    $result = $IDQuery->get_result();
    $id = $result->fetch_assoc();
    $id = $id["id"];
    $savePost = $conn->prepare("insert into post (creator, title, content) values (?, ?, ?)");
    $savePost->bind_param("iss", 
      $id,
      $title,
      $content
    );
    $savePost->execute();
  ?>
  
<?php $conn->close();?>