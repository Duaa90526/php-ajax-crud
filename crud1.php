<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1 class="text-primary text-uppercase text-center">Ajax Crud Operation</h1>

        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Add New Record
            </button>
        </div>
        <h2 class="text-danger"> All records</h2>
        <div id="records_content"></div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Ajax Crud Operation</h1>
                        <button type="button" class="btn-close" title="close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label> First Name: </label>
                            <input type="text" id="firstname" class="form-control" placeholder="First Name">
                        </div>
                        <div class="form-group">
                            <label> Last Name: </label>
                            <input type="text" id="lastname" class="form-control" placeholder="Last Name">
                        </div>
                        <div class="form-group">
                            <label> Email Id: </label>
                            <input type="email" id="email" class="form-control" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label> Mobile: </label>
                            <input type="text" id="mobile" class="form-control" placeholder="Mobile Number">
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="validateAndAddRecord()">Save</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--///////////////// update record modal //////////////////////-->
    <div class="modal fade" id="update_user_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ajax Crud Operation</h1>
                    <button type="button" class="btn-close" title="close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label> Update First Name: </label>
                        <input type="text" id="update_firstname" class="form-control" placeholder=" First Name">
                    </div>
                    <div class="form-group">
                        <label> Update Last Name: </label>
                        <input type="text" id="update_lastname" class="form-control" placeholder=" Last Name">
                    </div>
                    <div class="form-group">
                        <label> Update Email Id: </label>
                        <input type="email" id="update_email" class="form-control" placeholder=" Email">
                    </div>
                    <div class="form-group">
                        <label> Update Mobile: </label>
                        <input type="text" id="update_mobile" class="form-control" placeholder=" Mobile Number">
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="updateuserdetail()">Save</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <input type="hidden" name="" id="hidden_user_id">
                </div>
            </div>
        </div>
    </div>
    <!-- Include jQuery before Bootstrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script type="text/javascript">
        // Function to validate form fields and call addRecord if valid
        function validateAndAddRecord() {
            var firstname = $('#firstname').val().trim();
            var lastname = $('#lastname').val().trim();
            var email = $('#email').val().trim();
            var mobile = $('#mobile').val().trim();

            // Simple validation
            if (firstname === "" || lastname === "" || email === "" || mobile === "") {
                alert("Please fill all fields.");
                return;
            }

            // Name validation
            if (!validateName(firstname) || !validateName(lastname)) {
                alert("Please enter a valid name. Only alphabetic characters, spaces, hyphens, and apostrophes are allowed.");
                return;
            }

            if (!validateEmail(email)) {
                alert("Please enter a valid email address.");
                return;
            }

            if (!validateMobile(mobile)) {
                alert("Please enter a valid mobile number. It should be 10 digits long.");
                return;
            }

            // Call addRecord function if all validations pass
            addRecord(firstname, lastname, email, mobile);
        }

        // Function to validate name format using regular expression
        function validateName(name) {
            var re = /^[A-Za-z\s'-]+$/;
            return re.test(name);
        }

        // Function to validate email format using regular expression
        function validateEmail(email) {
            var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        // Function to validate mobile number format using regular expression
        function validateMobile(mobile) {
            var re = /^\d{10}$/; // Mobile number should be 10 digits long
            return re.test(mobile);
        }

        // Function to fetch and display records
        function fetchRecords() {
            $.ajax({
                url: "backend1.php",
                type: "POST",
                data: {
                    readrecord: "readrecord"
                },
                success: function(data, status) {
                    $('#records_content').html(data);
                }
            });
        }

        // Function to add a new record
        function addRecord(firstname, lastname, email, mobile) {
            $.ajax({
                url: "backend1.php",
                type: 'post',
                data: {
                    firstname: firstname,
                    lastname: lastname,
                    email: email,
                    mobile: mobile
                },
                success: function(data, status) {
                    console.log(data); // Log the response
                    $('#exampleModal').modal('hide'); // Close the modal
                    fetchRecords(); // Refresh the records
                }
            });
        }

        // Function to delete a user
        function DeleteUser(deleteid) {
            var conf = confirm("Are you sure you want to delete this record?");
            if (conf) {
                $.ajax({
                    url: "backend1.php",
                    type: "post",
                    data: {
                        deleteid: deleteid
                    },
                    success: function(data, status) {
                        fetchRecords(); // Refresh the records after deletion
                    }
                });
            }
        }

        // Call fetchRecords on document ready
        $(document).ready(function() {
            fetchRecords(); // Fetch records on page load
        });

        ///////// get user id fuction to edit user detailes/////////////
        function GetUserDetails(id) {
            $('#hidden_user_id').val(id);

            $.post("backend1.php", {
                id:id
            }, function(data,status){
        
                  var user = JSON.parse(data);
                  $('#update_firstname').val(user.firstname);
                  $('#update_lastname').val(user.lastname);
                  $('#update_email').val(user.email);
                  $('#update_mobile').val(user.mobile);
  
            }
        );
        $('#update_user_modal').modal("show");
        }


        function updateuserdetail(){

            var firstname = $('#update_firstname').val();
            var lastname = $('#update_lastname').val();
            var email = $('#update_email').val();
            var mobile = $('#update_mobile').val();

            var hidden_user_id = $('#hidden_user_id').val();

            $.post(
                 "backend1.php",{
                    hidden_user_id : hidden_user_id,  
                    firstname : firstname,
                    lastname : lastname,
                    email :email,
                    mobile : mobile,
                 },
                 function(data, status){
                    $('#update_user_modal').modal("hide");
                    readrecord();
                 }
            

            )
        }
    </script>

</body>

</html>