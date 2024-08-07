<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "practice_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    switch ($action) {
        case 'create':
            $name = $_POST['name'];
            $description = $_POST['description'];
            $sql = "INSERT INTO items (name, description) VALUES ('$name', '$description')";
            $conn->query($sql);
            break;

        case 'read':
            $result = $conn->query("SELECT * FROM items");
            $items = [];
            while ($row = $result->fetch_assoc()) {
                $items[] = $row;
            }
            echo json_encode($items);
            break;

        case 'update':
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $sql = "UPDATE items SET name ='$name', description='$description' WHERE id = $id";
            $conn->query($sql);
            break;

        case 'delete':
            $id = $_POST['id'];
            $sql = "DELETE FROM items WHERE id = $id";
            $conn->query($sql);
            break;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CRUD Operations with AJAX</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>CRUD Operations</h1>

    <h2>Create</h2>
    <input type="text" id="create-name" placeholder="Name">
    <input type="text" id="create-description" placeholder="Description">
    <button onclick="createItem()">Create</button>

    <h2>Read</h2>
    <button onclick="readItems()">Read</button>
    <div id="items"></div>

    <h2>Update</h2>
    <input type="text" id="update-id" placeholder="ID">
    <input type="text" id="update-name" placeholder="Name">
    <input type="text" id="update-description" placeholder="Description">
    <button onclick="updateItem()">Update</button>

    <h2>Delete</h2>
    <input type="text" id="delete-id" placeholder="ID">
    <button onclick="deleteItem()">Delete</button>

    <script>
        function createItem() {
            $.post('crud.php', {
                action: 'create',
                name: $('#create-name').val(),
                description: $('#create-description').val()
            }, function() {
                alert('Item created!');
            });
        }

        function readItems() {
            $.post('crud.php', { action: 'read' }, function(data) {
                const items = JSON.parse(data);
                let html = '<ul>';
                items.forEach(item => {
                    html += `<li>${item.id} - ${item.name}: ${item.description}</li>`;
                });
                html += '</ul>';
                $('#items').html(html);
            });
        }

        function updateItem() {
            $.post('crud.php', {
                action: 'update',
                id: $('#update-id').val(),
                name: $('#update-name').val(),
                description: $('#update-description').val()
            }, function() {
                alert('Item updated!');
            });
        }

        function deleteItem() {
            $.post('crud.php', {
                action: 'delete',
                id: $('#delete-id').val()
            }, function() {
                alert('Item deleted!');
            });
        }
    </script>
</body>
</html>
