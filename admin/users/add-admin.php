<?php

    session_start(); // For Session
    include('../../db-connection.php'); // Connect to database

    // Prepare Sidebar
    $pageConfig = [
        'sidebarPage' => 'USERS',
    ];

?>

<!-- HTML Start -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>

    <?php include('../../templates/head-includes.php'); ?>

    <style>
        .breadcrumb a {
            color: var(--bs-danger);
        }

    </style>

</head>

<body class="vh-100">

    <div class="d-flex">

        <div class="col-auto px-0">
            <?php include('../admin-templates/sidebar.php'); ?>
        </div>

        <div class="col px-0 vh-100">
            <?php include('../admin-templates/navbar.php'); ?>

            <!-- Main Content Here -->
            <div class="overflow-auto p-4" style="height: 92%"><!-- overflow auto and height 92% so if content is long it will only scroll on main content -->

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/burgershop/admin/users">Users</a></li>
                        <li class="breadcrumb-item active">Add</li>
                    </ol>
                </nav>

                
                <form method="POST" enctype="multipart/form-data">

                    <!-- Title -->
                    <h1 class="display-6">Create User - Admin</h1>

                    <!-- Table Actions -->
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-danger" name="add_user_btn" type="submit">Save</button>
                    </div>

                    <!-- Form -->
                    <div class="card mt-2">
                        <div class="card-header">
                            User Details
                        </div>
                        <div class="card-body row">

                            <!-- Profile Image -->
                            <div class="col-md-12 mb-3 mt-4">
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    <img id="profileImagePreview" src="/burgershop/images/avatars/avatar-default.png" class="border border-4 rounded object-fit-cover" width="240" height="240" alt="Profile Image">
                                </div>
                                <label for="profileImageFileInput" class="form-label">Profile Image</label>
                                <input id="profileImageFileInput" name="profile_image" class="form-control" type="file" accept=".png, .jpg, .jpeg">

                                <script>
                                    // Profile Image Preview
                                    // https://medium.com/geekculture/how-to-preview-images-before-upload-with-javascript-3420e3cd2f1c
                                    const profileImageFileInput = document.querySelector('#profileImageFileInput');

                                    profileImageFileInput.addEventListener('change', function(event) {
                                        const file = profileImageFileInput.files;
                                        if (file) {
                                            const fileReader = new FileReader();
                                            const preview = document.querySelector('#profileImagePreview');
                                            fileReader.onload = event => {
                                                preview.setAttribute('src', event.target.result);
                                            }
                                            fileReader.readAsDataURL(file[0]);
                                        }
                                    });
                                </script>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="confirmPassword" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <span class="form-label d-inline-block">Role</span>
                                <div class="col-md-12">
                                    
                                    <input type="radio" class="btn-check" name="role" id="role_admin" value="0" autocomplete="off" checked>
                                    <label class="btn btn-outline-danger" for="role_admin">Admin</label>

                                    <?php
                                        if ((int)$_SESSION['user']['details']['is_superadmin'] === 1) { // Check if superadmin
                                    ?>

                                        <input type="radio" class="btn-check" name="role" id="role_superadmin" value="1" autocomplete="off">
                                        <label class="btn btn-outline-danger" for="role_superadmin">Superadmin</label>
                                    
                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="first_name" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="middleName" class="form-label">Middle Name</label>
                                <input type="text" class="form-control" id="middleName" name="middle_name">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="last_name" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="contactNumber" class="form-label">Contact Number</label>
                                <input type="text" class="form-control" id="contactNumber" name="contact_number" required>
                            </div>
                        </div>
                    </div>

                    <!-- PHP CODE -->
                    <?php
                        if (isset($_POST['add_user_btn'])) {
                            // User Details
                            $profileImage = empty($_FILES['profile_image']['name']) ? null : $_FILES['profile_image'];
                            $firstName = mysqli_real_escape_string($dbCon, $_POST['first_name']);
                            $middleName = mysqli_real_escape_string($dbCon, $_POST['middle_name']);
                            $lastName = mysqli_real_escape_string($dbCon, $_POST['last_name']);
                            $email = mysqli_real_escape_string($dbCon, $_POST['email']);
                            $password = mysqli_real_escape_string($dbCon, $_POST['password']);
                            $confirmPassword = mysqli_real_escape_string($dbCon, $_POST['confirm_password']);
                            $contactNumber = mysqli_real_escape_string($dbCon, $_POST['contact_number']);
                            // Admin Details
                            $role = (int) mysqli_real_escape_string($dbCon, $_POST['role']);

                            // Password Confirmation
                            if ($password !== $confirmPassword) {
                                ?>
                                    <script>
                                        alert('Password confirmation does not match');
                                        window.location.assign('/burgershop/admin/users/add-admin.php');
                                    </script>
                                <?php
                                exit();
                            }

                            // Check if there's an uploaded Image
                            $profileImagePath = "/burgershop/images/avatars/avatar-default.png"; // Default avatar
                            if ($profileImage !== null) {
                                // Check File Type
                                if ( $profileImage['type'] === 'image/png' || $profileImage['type'] === 'image/jpeg') {

                                    $filePathParts = pathinfo($profileImage['name']);
                                    $fileExtension = $filePathParts['extension'];
                                    $fileTemporaryPath = $profileImage['tmp_name'];

                                    $newProfileImageFileName = "user_" . $email . "_avatar" . "." . $fileExtension;
                                    $newProfileImageRelativeFilePath = "../../images/avatars/" . $newProfileImageFileName;

                                    $profileImageUploadResult = move_uploaded_file($fileTemporaryPath, $newProfileImageRelativeFilePath );

                                    if ($profileImageUploadResult) {
                                        $profileImagePath = "/burgershop/images/avatars/" . $newProfileImageFileName;
                                    } else {
                                        ?>
                                            <script>
                                                alert('Profile Image! Upload Failed');
                                                window.location.assign('/burgershop/admin/users/add-admin.php');
                                            </script>
                                        <?php
                                        exit(); // to not execute further
                                    }
                                    
                                } else {
                                    ?>
                                        <script>
                                            alert('Please only choose JPEG, JPG, or PNG for Profile Image!'); // Todo service 1 website logo alert
                                            window.location.assign('/burgershop/admin/users/add-admin.php');
                                        </script>
                                    <?php
                                    exit();
                                }

                            }


                            // Hash Password

                            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                            $query = "
                                    INSERT INTO users_tbl(email, password, role, first_name, middle_name, last_name, contact_number, profile_image_path) 
                                    VALUES ('$email', '$hashedPassword', 'ADMIN', '$firstName', '$middleName', '$lastName', '$contactNumber', '$profileImagePath')";
                            $queryResult = mysqli_query($dbCon, $query);

                            if ($queryResult) {

                                $insertUserId = mysqli_insert_id($dbCon);

                                $query = "INSERT INTO admins_tbl(admin_user_id, is_superadmin) VALUES ('$insertUserId', '$role')";
                                $queryResult = mysqli_query($dbCon, $query);

                                if ($queryResult) {
                                    ?>
                                    <script type="text/javascript">
                                        alert("User has been created!");
                                        window.location.assign('/burgershop/admin/users');
                                    </script>
                                    <?php
                                } else {
                                    // Delete inserted if it fails
                                    $query = "DELETE FROM users_tbl WHERE user_id = '$insertUserId'";
                                    $queryResult = mysqli_query($dbCon, $query);
                                    ?>
                                    <script type="text/javascript">
                                        alert("Failed to Create Users!");
                                        window.location.assign('/burgershop/admin/users');
                                    </script>
                                    <?php
                                }
                            } else {
                                ?>
                                <script type="text/javascript">
                                    alert("Failed to Create User!");
                                    window.location.assign('/burgershop/admin/users');
                                </script>
                                <?php
                            }
                        }

                    ?>

                </form>

                
            </div>

            <!-- Main Content End -->
        </div>

    </div>

    

    

    <?php include('../../templates/script-includes.php'); ?>
</body>

</html>