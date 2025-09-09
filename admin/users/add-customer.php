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
                    <h1 class="display-6">Create User - Customer</h1>

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
                                    <img id="profileImagePreview" src="/burgershop/images/wait.jpg" class="border border-4 rounded object-fit-cover" width="240" height="240" alt="Profile Image">
                                </div>
                                <label for="profileImageFileInput" class="form-label">Profile Image</label>
                                <input id="profileImageFileInput" name="profile_image" class="form-control" type="file" accept=".png, .jpg, .jpeg">

                                <script>
                                    // Profile Image Preview sa bo
                                    // https://medium.com/geekculture/how-to-preview-images-before-upload-with-javascript-3420e3cd2f1c - link to para macheck nio documentation guys
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

                            <!-- Customer Specific Details -->

                            <div class="col-md-12 mb-3">
                                <label for="accountNumber" class="form-label">Customer Account Number </label>
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <span>Generate</span>
                                        <input id="accountNumberGenerateCheckbox" class="ms-2" type="checkbox" value="" aria-label="Checkbox for following text input" checked>
                                    </div>
                                    <input id="accountNumber" name="account_number" type="text" class="form-control" aria-label="Text input with checkbox" placeholder="Account Number will be generated on save" disabled/>
                                </div>
                            </div>

                            <div class="col-md-2 mb-3">
                                <label for="birthdate" class="form-label">Birthdate</label>
                                <input type="date" class="form-control" id="birthdate" name="birthdate" required>
                            </div>

                            <div class="col-md-2 mb-3">
                                <span class="form-label d-inline-block">Sex</span>
                                <div>
                                    <input type="radio" class="btn-check" name="sex" id="sex_male" value="MALE" autocomplete="off" checked>
                                    <label class="btn btn-outline-dark" for="sex_male">Male</label>

                                    <input type="radio" class="btn-check" name="sex" id="sex_female" value="FEMALE" autocomplete="off">
                                    <label class="btn btn-outline-danger" for="sex_female">Female</label>
                                </div>
                            </div>

                            <div class="col-md-8 mb-3">
                                <label for="civilStatus" class="form-label">Civil Status</label>
                                <select class="form-select" id="civilStatus" name="civil_status" required>
                                    <option value="" disabled selected>Please Select</option>
                                    <option value="SINGLE">Single</option>
                                    <option value="MARRIED">Married</option>
                                    <option value="SEPARATED">Separated</option>
                                    <option value="ANNULED">Annuled</option>
                                    <option value="WIDOWED">Widowed</option>
                                    <option value="PARTNERSHIP">Civil Partnership/Registered Partnership</option>
                                </select>
                                <script>
                                    document.querySelector('#civilStatus').addEventListener('change', function() {
                                        console.log(this.value);
                                        if (
                                            this.value === "SINGLE" ||
                                            this.value === "SEPARATED" ||
                                            this.value === "ANNULED" ||
                                            this.value === "WIDOWED"
                                        ) {
                                            // For Display - Hide
                                            document.querySelector('#spouseDetailsName').style.display = 'none';
                                            document.querySelector('#spouseDetailsContactNumber').style.display = 'none';
                                            // For Validation - Remove Required
                                            document.querySelector('#spouseName').removeAttribute('required');
                                            document.querySelector('#spouseContactNumber').removeAttribute('required');
                                        } else {
                                            // For Display - Show
                                            document.querySelector('#spouseDetailsName').style.display = 'block';
                                            document.querySelector('#spouseDetailsContactNumber').style.display = 'block';
                                            // For Validation - Add Required
                                            document.querySelector('#spouseName').setAttribute('required', true);
                                            document.querySelector('#spouseContactNumber').setAttribute('required', true);
                                        }
                                    });
                                </script>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="facebookName" class="form-label">Facebook Name</label>
                                <input type="text" class="form-control" id="facebookName" name="facebook_name" required>
                            </div>
                            
                            <div class="col-md-6 mb-3" id="spouseDetailsName" style="display: none;">
                                <label for="spouseName" class="form-label">Spouse Fullname</label>
                                <input type="text" class="form-control" id="spouseName" name="spouse_name" required>
                            </div>

                            <div class="col-md-6 mb-3" id="spouseDetailsContactNumber" style="display: none;">
                                <label for="spouseContactNumber" class="form-label">Spouse Contact Number</label>
                                <input type="text" class="form-control" id="spouseContactNumber" name="spouse_contact_number" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="addressProvince" class="form-label">Province</label>
                                <select class="form-select" id="addressProvince" name="address_province" disabled required>
                                    <option value="" disabled>Please Select</option>
                                    <option value="18" selected>Cavite</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="addressCity" class="form-label">City</label>
                                <select class="form-select" id="addressCity" name="address_city" disabled required>
                                    <option value="" disabled>Please Select</option>
                                    <option value="16" selected>Noveleta</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="addressBarangay" class="form-label">Barangay</label>
                                <select class="form-select" id="addressBarangay" name="address_barangay" required>
                                    <option value="" disabled selected>Please Select</option>
                                    <?php
                                        $query = "SELECT barangay_id, barangay_city_id, name
                                            FROM 
                                                barangay_tbl
                                            WHERE 
                                                barangay_city_id = 16";

                                        $queryResult = mysqli_query($dbCon, $query);
                                    ?>
                                    <?php while($barangay = mysqli_fetch_assoc($queryResult)) { ?>
                                        <option value="<?= $barangay['barangay_id'] ?>"><?= $barangay['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="addressSubdivision" class="form-label">Subdivision</label>
                                <input type="text" class="form-control" id="addressSubdivision" name="address_subdivision" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="addressStreet" class="form-label">Street</label>
                                <input type="text" class="form-control" id="addressStreet" name="address_street" required>
                            </div>

                            <div class="col-md-2 mb-3">
                                <label for="addressHouseNumber" class="form-label">House number</label>
                                <input type="text" class="form-control" id="addressHouseNumber" name="address_house_number" required>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="homeOwnership" class="form-label">Home Ownership</label>
                                <select class="form-select" id="homeOwnership" name="home_ownership" required>
                                    <option value="" disabled selected>Please Select</option>
                                    <option value="OWNED">Owned</option>
                                    <option value="RENTED">Rented</option>
                                </select>
                            </div>

                            <div class="col-md-5 mb-3">
                                
                                <label for="availedPlan" class="form-label">Availed Burger</label>
                                <select class="form-select" id="availedPlan" name="availed_plan" required>
                                    <option value="" disabled selected>Please Select</option>
                                    <?php
                                        // Prepare Burgers
                                        $query = "SELECT burgers_tbl.burger_id,name, description, price
                                            FROM 
                                                burgers_tbl
                                            INNER JOIN
                                                burgers_prices_tbl ON burgers_tbl.burger_id = burgers_prices_tbl.burger_id
                                            WHERE burgers_prices_tbl.is_current = 1";
                                        $queryResult = mysqli_query($dbCon, $query);
                                    ?>
                                    <?php while($burger = mysqli_fetch_assoc($queryResult)) { ?>
                                        <option value="<?= $burger['burger_id'] ?>"><?= $burger['name'] ?> = <span>&#8369;</span><?= $burger['price'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-2 mb-3">
                                <label for="installationDate" class="form-label">Installation Date</label>
                                <input type="date" class="form-control" id="installationDate" name="installation_date" required/>
                            </div>

                            <div class="col-md-2 mb-3">
                                <label for="isConnectionActive" class="form-label">Connection Status</label>
                                <select class="form-select" id="isConnectionActive" name="is_burger_active" required>
                                    <option value="" disabled selected>Please Select</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <!-- PHP CODE -->
                    <?php
                        // For Redirect (URL Where user came from) , parang bookmark sya kumabaga
                        $redirectFrom = (isset($_GET['redirect_from'])) ? $_GET['redirect_from'] : '/burgershop/admin/users'; //

                        if (isset($_POST['add_user_btn'])) {
                            // User Details
                            $profileImage = empty($_FILES['profile_image']['name']) ? null : $_FILES['profile_image']; //short hand lang to. like if empty yung file upload or walang inupload null lang sya kapag meron naman isset yun para masave 
                            $firstName = mysqli_real_escape_string($dbCon, $_POST['first_name']);
                            $middleName = mysqli_real_escape_string($dbCon, $_POST['middle_name']);
                            $lastName = mysqli_real_escape_string($dbCon, $_POST['last_name']);
                            $email = mysqli_real_escape_string($dbCon, $_POST['email']);
                            $password = mysqli_real_escape_string($dbCon, $_POST['password']);
                            $confirmPassword = mysqli_real_escape_string($dbCon, $_POST['confirm_password']);
                            $contactNumber = mysqli_real_escape_string($dbCon, $_POST['contact_number']);
                            // Customer Details
                            $accountNumber = mysqli_real_escape_string($dbCon, isset($_POST['account_number']) ? $_POST['account_number'] : '');
                            $birthdate = mysqli_real_escape_string($dbCon, $_POST['birthdate']);
                            $sex = mysqli_real_escape_string($dbCon, $_POST['sex']);
                            $civilStatus = mysqli_real_escape_string($dbCon, $_POST['civil_status']);
                            $facebookName = mysqli_real_escape_string($dbCon, $_POST['facebook_name']);
                            $spouseName = mysqli_real_escape_string($dbCon, $_POST['spouse_name']);
                            $spouseContactNumber = mysqli_real_escape_string($dbCon, $_POST['spouse_contact_number']);
                            $addressBarangay = (int) mysqli_real_escape_string($dbCon, $_POST['address_barangay']);
                            $addressSubdivision = mysqli_real_escape_string($dbCon, $_POST['address_subdivision']);
                            $addressStreet = mysqli_real_escape_string($dbCon, $_POST['address_street']);
                            $addressHouseNumber = mysqli_real_escape_string($dbCon, $_POST['address_house_number']);
                            $homeOwnership = mysqli_real_escape_string($dbCon, $_POST['home_ownership']);
                            // Plan Details
                            $availedPlanId = mysqli_real_escape_string($dbCon, $_POST['availed_plan']);
                            $installationDate = mysqli_real_escape_string($dbCon, $_POST['installation_date']);
                            $isBurgerActive = (int) mysqli_real_escape_string($dbCon, $_POST['is_burger_active']);
                            

                            // Password Confirmation
                            if ($password !== $confirmPassword) {
                                ?>
                                    <script>
                                        alert('Password confirmation does not match');
                                        window.location.assign('/burgershop/admin/users/add-customer.php');
                                    </script>
                                <?php
                                exit();
                            }

                            // Check if there's an uploaded Image
                            $profileImagePath = "/burgershop/images/wait.jpg"; // Default avatar
                            if ($profileImage !== null) {
                                // Check File Type
                                if ( $profileImage['type'] === 'image/png' || $profileImage['type'] === 'image/jpeg') {

                                    $filePathParts = pathinfo($profileImage['name']);
                                    $fileExtension = $filePathParts['extension'];
                                    $fileTemporaryPath = $profileImage['tmp_name'];

                                    $newProfileImageFileName = "user_" . $email . "_avatar" . "." . $fileExtension; //eto yung name nung pic then yung $newProfileImageRelativeFilePath is i-aappend nya lang sa dulo ng path yung file name para pumasok sa avatars folder
                                    $newProfileImageRelativeFilePath = "../../images/avatars/" . $newProfileImageFileName;

                                    //imove mula sa temporary folder ang uploaded file sa target folder which is avatar folder
                                    $profileImageUploadResult = move_uploaded_file($fileTemporaryPath, $newProfileImageRelativeFilePath );

                                    //if success ang upload ng image ang file name lalabas dapat sa db is yung may email na naka append dapat
                                    if ($profileImageUploadResult) {
                                        $profileImagePath = "/burgershop/images/avatars/" . $newProfileImageFileName;
                                    } else { //if not success
                                        ?>
                                            <script>
                                                alert('Profile Image! Upload Failed');
                                                window.location.assign('/burgershop/admin/users/add-customer.php');
                                            </script>
                                        <?php
                                        exit(); // to not execute further
                                    }
                                    
                                } else { //if image file type is not Jpeg, jpg, png
                                    ?>
                                        <script>
                                            alert('Please only choose JPEG, JPG, or PNG for Profile Image!');
                                            window.location.assign('/burgershop/admin/users/add-customer.php');
                                        </script>
                                    <?php
                                    exit();
                                }

                            }


                            // Hash Password
                            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                            $query = "
                                    INSERT INTO users_tbl(email, password, role, first_name, middle_name, last_name, contact_number, profile_image_path) 
                                    VALUES ('$email', '$hashedPassword', 'CUSTOMER', '$firstName', '$middleName', '$lastName', '$contactNumber', '$profileImagePath')";
                            $queryResult = mysqli_query($dbCon, $query);

                            if ($queryResult) { // Check if insert users_tbl success

                                $insertUserId = mysqli_insert_id($dbCon); // PK for user_id every new users created

                                // Process Account Number - if may nilagay na account number gagamitin yun, pero kapag walang laman gagamitin yung default value na EZTECH-OLD-
                                $insertAccountNumber = (!empty($accountNumber)) ? $accountNumber : 'EZTECH-NEW-' . $insertUserId;

                                // Insert Customer
                                $query = "INSERT INTO customers_tbl(customer_user_id, account_number, birthdate, sex, civil_status, spouse_name, spouse_contact_number, facebook_name, barangay_id, subdivision, street, house_number, home_ownership) 
                                    VALUES ('$insertUserId', '$insertAccountNumber', '$birthdate', '$sex', '$civilStatus', '$spouseName', '$spouseContactNumber', '$facebookName', '$addressBarangay', '$addressSubdivision', '$addressStreet', '$addressHouseNumber', '$homeOwnership')";
                                $queryResult = mysqli_query($dbCon, $query);

                                if ($queryResult) { // Check if insert customers_tbl success

                                    // Insert Availed Plan
                                    $query = "INSERT INTO customers_burgers_tbl(customer_user_id, burger_id, is_burger_active, installation_date) 
                                        VALUES ('$insertUserId', '$availedPlanId', '$isBurgerActive', '$installationDate')";
                                    $queryResult = mysqli_query($dbCon, $query);

                                    if ($queryResult) { // Check if insert customers_plans_tbl success

                                        ?>
                                        <script type="text/javascript">
                                            alert("User has been created!");
                                            window.location.assign('<?= $redirectFrom ?>');
                                        </script>
                                        <?php
                                    } else {
                                        // Delete inserted if it fails (users_tbl)
                                        $query = "DELETE FROM users_tbl WHERE user_id = '$insertUserId'";
                                        $queryResult = mysqli_query($dbCon, $query);

                                        // Delete inserted if it fails (customers_tbl)
                                        $query = "DELETE FROM customers_tbl WHERE customer_user_id = '$insertUserId'";
                                        $queryResult = mysqli_query($dbCon, $query);

                                        ?>
                                        <script type="text/javascript">
                                            alert("Failed to Create User!");
                                            window.location.assign('<?= $redirectFrom ?>');
                                        </script>
                                        <?php
                                    }

                                } else {
                                    // Delete inserted if it fails (users_tbl)
                                    $query = "DELETE FROM users_tbl WHERE user_id = '$insertUserId'";
                                    $queryResult = mysqli_query($dbCon, $query);
                                    ?>
                                    <script type="text/javascript">
                                        alert("Failed to Create User!");
                                        window.location.assign('<?= $redirectFrom ?>');
                                    </script>
                                    <?php
                                }
                            } else {
                                ?>
                                <script type="text/javascript">
                                    alert("Failed to Create User!");
                                    window.location.assign('<?= $redirectFrom ?>');
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

    
    <script>
        // Script for Account Number Generate
        document.querySelector('#accountNumberGenerateCheckbox').addEventListener('change', function(event) {
            if (event.currentTarget.checked) {
                document.querySelector('#accountNumber').value = '';
                document.querySelector('#accountNumber').disabled = true;
            } else {
                document.querySelector('#accountNumber').disabled = false;
            }
        })
    </script>
    

    <?php include('../../templates/script-includes.php'); ?>
</body>

</html>