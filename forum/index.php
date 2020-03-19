<head>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>
</head>

<body>
<?php include 'menu.html';?>
<?php include 'mysql_connect.php';?>
<?php session_start(); ?>
    <div>
      <h1>Posts</h1>
      
      <div id="showPosts">
      <?php
        $postQuery = $conn->prepare("select * from post");
        $postQuery->execute();
        //queryResult: everything from post
        $queryResult = $postQuery->get_result();
        if($queryResult->num_rows == 0){ //if no post exist
            print("<h2>");
            print("No posts available");
            print("</h2>");
        }
        else{
            $joinQuery = $conn->prepare("select user.username, post.title, post.content from user inner join post on post.creator = user.id");
            $joinQuery->execute();
            $joinResult = $joinQuery->get_result();
            while($row = $joinResult->fetch_assoc()) {
                print('<div style="border-style: solid;">');
                print('<strong>Title: ' . $row['title'] . '</strong><br>');
                print('By: ' . $row['username'] . '<br>');
                print($row['content'] . '</div>');
                print('<br>');
            }
        }
      ?>
      </div>
    </div>
    <?php
    // check whether the user is logged in
        if (!isset($_SESSION['username'])):
    ?>
    <h2>Not Logged In</h2>
    <?php else: ?>       
    <div>
        <ul id="prompts"></ul>
        <h2>Create a post as <?php print('<span id="username">' . $_SESSION['username'] . '</span>') ?></h2>
        <form id="newPostForm">
    Title: <input type="text" name="title" /><br />
    Content: <input type="text" name="content" /> <br />
        <input type="submit" >
        </form>
    </div>
    <?php endif; ?>
    <script type="text/javascript">
    $('#newPostForm').submit( function(e){
        $('#prompts').empty();
        e.preventDefault();
        e.stopPropagation();
        //get data from form
        let newPost = {
            'title': $('input[name=title]').val(),
            'content': $('input[name=content]').val(),
        };

        //check whether input is empty
        if(newPost['title'] && newPost['content']) {

            //if not empty, save to db 
            $.post("doSavePost.php", newPost);
            //add post to html
            let username = $('#username').val();
            let newPostDiv = '<div style="border-style: solid;">' +  '<strong>Title: ' + newPost['title'] + '</strong><br>'+ 'By: ' + username + '<br>' + newPost['content'] + '</div>';
            $('#showPosts').append(newPostDiv);
            //clear form
            document.getElementById("newPostForm").reset();
            
        }
        //if empty, display message
        else{
            if(!newPost['title']){
                $('#prompts').append('<li>Title Required</li>');
            }
            if(!newPost['content']){
                $('#prompts').append('<li>Content required</li>');
            }
      }
    });
</script>
</body>