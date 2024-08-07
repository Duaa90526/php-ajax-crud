<?php require_once('config.php') ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    


<h1>Login Page</h1>



<?php

echo "User name :: ".$_SESSION["username"];
echo "User email :: ".$_SESSION["email"];
echo "User Password :: ".$_SESSION["password"];





$_SESSION["username"] = "Abdul Wasey";



session_destroy();

?>


<a href="http://localhost/Projects/CRUD_DB/arsalan/index.php">
<button>Home</button>
</a>


</body>
</html>

