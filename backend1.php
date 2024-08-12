<?php
$conn = mysqli_connect('localhost', 'root', '', 'ytcop');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Extract POST variables
extract($_POST);

if (isset($_POST['readrecord'])) {
    $data = '<table class="table table-bordered table-stripped">
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Mobile Number</th>
            <th>Edit Action</th>
            <th>Delete Action</th>
        </tr>';

    $displayquery = "SELECT * FROM `crudtable`";
    $result = mysqli_query($conn, $displayquery);

    if (mysqli_num_rows($result) > 0) {
        $number = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            $data .= '<tr>
                <td>' . $number . '</td>
                <td>' . $row['firstname'] . '</td>
                <td>' . $row['lastname'] . '</td>
                <td>' . $row['email'] . '</td>
                <td>' . $row['mobile'] . '</td>
                <td>
                    <button onclick="GetUserDetails(' . $row['id'] . ')" class="btn btn-warning">Edit</button>
                </td>
                <td>
                    <button onclick="DeleteUser(' . $row['id'] . ')" class="btn btn-danger">Delete</button>
                </td>
            </tr>';
            $number++;
        }
    } else {
        $data .= '<tr><td colspan="7">No records found</td></tr>';
    }

    $data .= '</table>';
    echo $data;
}

///////////// Insert new record ////////////
if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['mobile'])) {
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);

    $sql = "INSERT INTO `crudtable`(`firstname`, `lastname`, `email`, `mobile`) VALUES ('$firstname','$lastname','$email','$mobile')";
    mysqli_query($conn, $sql);
}

// Delete record
if (isset($_POST['deleteid'])) {
    $userid = mysqli_real_escape_string($conn, $_POST['deleteid']);
    $deletequery = "DELETE FROM `crudtable` WHERE id='$userid'";
    mysqli_query($conn, $deletequery);
}
// ///////////////get user id for update////////////////

// ///////////////get user id for update////////////////
if (isset($_POST['id']) && $_POST['id'] != "") {
    $user_id = $_POST['id'];
    $query = "SELECT * FROM crudtable WHERE id ='$user_id'";
    if (!$result = mysqli_query($conn, $query)) {
        exit(mysqli_error($conn));
    }
    $response = array();

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $response = $row;
        }
    } else 
    {
        $response['status'] = 200;
        $response['message'] = "Data not found!";
    }

    echo json_encode($response); // This line will output the JSON encoded response

}

///////////////////update table record////////////////////////
if(isset($_POST['hidden_user_id'])){
    $hidden_user_id = $_POST['hidden_user_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];

    $query = "UPDATE `crudtable` SET `firstname` = '$firstname', `lastname` = '$lastname', `email` = '$email', `mobile` = '$mobile' WHERE id='$hidden_user_id'"; // Fix SQL query

mysqli_query($conn, $query); // Correct the function and variable name
}

mysqli_close($conn);
