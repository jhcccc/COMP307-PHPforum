<?php
session_start();
session_unset();
session_destroy();
?>

<body>
<?php include 'menu.html';?>
<h1>You're logged out!</h1>
</body>