<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>This is index.php</h1>

    <?php


$_SESSION["password"] = "Password123";

echo "User name :: ".$_SESSION["username"];
echo "User email :: ".$_SESSION["email"];


?>


<a href="http://localhost/Projects/CRUD_DB/arsalan/login.php">
<button>Login</button>
</a>
</body>
</html>