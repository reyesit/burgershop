<?php

session_start(); // For Session
include('../../db-connection.php'); // Connect to database

// Prepare Sidebar
$pageConfig = [
    'sidebarPage' => 'SETTINGS',
];

// For Tab
$selectedTab = isset($_GET['tab']) ? $_GET['tab'] : 'ABOUT'; // Tabs are 'ABOUT, 'SERVICES' - ito yung nagpaprocess kung anong tab ang ipapakita

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
        .nav-tabs .nav-link{
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

                <!-- Title -->
                <h1 class="display-6">Settings</h1>


                <!-- Navigation Tabs -->
                <nav class="mt-4">
                    <!-- role="tablist" is for assistive technologies that will tell that it is a set of tabs -->
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <!-- $selectedTab in the top will tell in server side what content and tab will see -->
                        <button class="nav-link <?php if($selectedTab === 'ABOUT') echo 'active'; ?>" id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about" type="button" role="tab" aria-controls="nav-about" aria-selected="true">About</button>
                        <button class="nav-link <?php if($selectedTab === 'SERVICES') echo 'active'; ?>" id="nav-services-tab" data-bs-toggle="tab" data-bs-target="#nav-services" type="button" role="tab" aria-controls="nav-services" aria-selected="false">Services</button>
                    </div>
                </nav>

                <!-- Navigation Tabs - Contents -->
                <div class="tab-content" id="nav-tabContent">


                    <!-- About Tab - Content -->
                     <!-- yung container dito is yung container na pinaglalagyan ng contents then may padding na sya sa right and left sides and macenter yung contents sa settings and yung fade is yung animation ni bs para may fade animation-->
                    <div class="tab-pane fade container <?php if($selectedTab === 'ABOUT') echo 'active show'; ?>" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab" tabindex="0">

                        <?php
                            $query = "SELECT *
                                FROM 
                                    `settings_tbl`
                                LIMIT 1";
                            $queryResult = mysqli_query($dbCon, $query);
                            $setting = mysqli_fetch_assoc($queryResult);
                        ?>

                        <div class="card mt-4">
                            <!-- 
                                enctype = encoding type
                                multipart/form-data = isang format ng pag-send ng data, lalo na kapag may file(s) na kasamang i-upload.
                                --ginagamit to since may file upload sa form kapag wala nito:
                                  File won’t upload, $_FILES in PHP will be empty, Hindi gagana ang upload feature mo kahit may laman yung form  
                            -->
                            <form method="POST" enctype="multipart/form-data">
                                <div class="card-body row">
                                    <!-- Action -->
                                    <div class="d-flex justify-content-end mb-3">
                                        <button class="btn btn-danger" name="save_settings_about_btn" type="submit">Save</button>
                                    </div>
                                    
                                    <!-- Logo -->
                                    <div class="col-md-12 mb-3">
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <img id="logoPreview" src="<?= $setting['logo_image_path']?>" class="border border-4 rounded object-fit-contain" width="240" height="240" alt="Website Logo">
                                        </div>
                                        <label for="logoFileInput" class="form-label">Website Logo</label>
                                        <input id="logoFileInput" name="logo" class="form-control" type="file" accept=".png, .jpg, .jpeg">

                                        <script>
                                            // Logo Preview
                                            // https://medium.com/geekculture/how-to-preview-images-before-upload-with-javascript-3420e3cd2f1c
                                            const logoFileInput = document.querySelector('#logoFileInput');

                                            logoFileInput.addEventListener('change', function(event) {
                                                const file = logoFileInput.files;
                                                if (file) {
                                                    const fileReader = new FileReader();
                                                    const preview = document.querySelector('#logoPreview');
                                                    fileReader.onload = event => {
                                                        preview.setAttribute('src', event.target.result);
                                                    }
                                                    fileReader.readAsDataURL(file[0]);
                                                }
                                            });
                                        </script>
                                    </div>

                                    <!-- Name -->
                                    <div class="col-md-6 mb-3">
                                        <label for="websiteName" class="form-label">Website Name</label>
                                        <input type="text" class="form-control" id="websiteName" name="website_name" required value="<?= $setting['website_name'] ?>">
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" required value="<?= $setting['email'] ?>">
                                    </div>

                                    <!-- Contact Number -->
                                    <div class="col-md-12 mb-3">
                                        <label for="contactNumber" class="form-label">Contact Number</label>
                                        <input type="text" class="form-control" id="contactNumber" name="contact_number" required value="<?= $setting['contact_number'] ?>">
                                    </div>

                                    <!-- Location -->
                                    <div class="col-md-12 mb-3">
                                        <label for="location" class="form-label">Location</label>
                                        <input type="text" class="form-control" id="location" name="location" required value="<?= $setting['location'] ?>">
                                    </div>

                                    <!-- Copyright Name -->
                                    <div class="col-md-12 mb-3">
                                        <label for="copyrightName" class="form-label">Copyright Name</label>
                                        <input type="text" class="form-control" id="copyrightName" name="copyright_name" required value="<?= $setting['copyright_name'] ?>">
                                    </div>
                                    
                                </div>

                                <!-- PHP CODE -->
                                <?php
                                    if (isset($_POST['save_settings_about_btn'])) {

                                        //$_FILES['logo'] Ito yung superglobal array sa PHP na naglalaman ng info tungkol sa uploaded file na may input name na logo
                                        // check if logo is empty/ if its empty, make it null
                                        $logo = empty($_FILES['logo']['name']) ? null : $_FILES['logo'];
                                        $websiteName = mysqli_real_escape_string($dbCon, $_POST['website_name']);
                                        $email = mysqli_real_escape_string($dbCon, $_POST['email']);
                                        $contactNumber = mysqli_real_escape_string($dbCon, $_POST['contact_number']);
                                        $location = mysqli_real_escape_string($dbCon, $_POST['location']);
                                        $copyrightName = mysqli_real_escape_string($dbCon, $_POST['copyright_name']);

                                        // Check if there's an uploaded logo
                                        if ($logo !== null) {
                                            // Check File Type - dito kaya png and jpeg lang kasi kasama na ng jpeg ang jpg sa MIME type nito
                                            if ( $logo['type'] === 'image/png' || $logo['type'] === 'image/jpeg') {

                                                $filePathParts = pathinfo($logo['name']);
                                                $fileExtension = $filePathParts['extension'];
                                                $fileTemporaryPath = $logo['tmp_name'];

                                                $newFileName = "website_logo" . "." . $fileExtension;
                                                $newRelativeFilePath = "../../images/settings/" . $newFileName;

                                                $moveResult = move_uploaded_file($fileTemporaryPath, $newRelativeFilePath );

                                                
                                                if ($moveResult) { // if image upload success

                                                    $newUrlFilePath = "/burgershop/images/settings/" . $newFileName;

                                                    $query = "UPDATE settings_tbl 
                                                        SET 
                                                            website_name = '$websiteName',
                                                            logo_image_path = '$newUrlFilePath',
                                                            contact_number = '$contactNumber',
                                                            email = '$email',
                                                            location = '$location',
                                                            copyright_name = '$copyrightName'
                                                        WHERE setting_id = 1";
                                                    $queryResult = mysqli_query($dbCon, $query);

                                                    if ($queryResult) { // If Success
                                                        ?>
                                                            <script>
                                                                alert('Settings saved!');
                                                                window.location.assign('/burgershop/admin/settings');
                                                            </script>
                                                        <?php
                                                    }

                                                } else {
                                                    ?>
                                                        <script>
                                                            alert('Image Upload failed! please try again.');
                                                            window.location.assign('/burgershop/admin/settings');
                                                        </script>
                                                    <?php
                                                }
                                               
                                            } else {
                                                 ?>
                                                    <script>
                                                        alert('Please only choose JPEG, JPG, or PNG for Website Logo!');
                                                        window.location.assign('/burgershop/admin/settings');
                                                    </script>
                                                <?php
                                            }

                                        } else { // If no image is uploaded
                                            $query = "UPDATE settings_tbl 
                                                SET 
                                                    website_name = '$websiteName',
                                                    contact_number = '$contactNumber',
                                                    email = '$email',
                                                    location = '$location',
                                                    copyright_name = '$copyrightName'
                                                WHERE setting_id = 1";
                                            $queryResult = mysqli_query($dbCon, $query);

                                            if ($queryResult) { // If Success
                                                ?>
                                                    <script>
                                                        alert('Settings saved!');
                                                        window.location.assign('/burgershop/admin/settings');
                                                    </script>
                                                <?php
                                            }
                                        }
                                    }
                                ?>
                            </form>
                        </div>

                    </div>

                    <!-- Services Tab - Content -->
                    <div class="tab-pane fade container <?php if($selectedTab === 'SERVICES') echo 'active show'; ?>" id="nav-services" role="tabpanel" aria-labelledby="nav-services-tab" tabindex="0">

                        <?php
                            $query = "SELECT *
                                FROM 
                                    services_tbl";
                            $queryResult = mysqli_query($dbCon, $query);
                        ?>
                        <div class="card mt-4">

                            <form method="POST" enctype="multipart/form-data">


                                <div class="card-body row">
                                    <!-- Action -->
                                    <div class="d-flex justify-content-end mb-3">
                                        <button class="btn btn-danger" name="save_settings_services_btn" type="submit">Save</button>
                                    </div>
                                    
                                    <!-- Service 1 -->
                                    <div class="col-md-4 mb-3">

                                        <?php
                                            $service1 = mysqli_fetch_assoc($queryResult);
                                        ?>

                                        <div class="d-flex flex-column align-items-center justify-content-center mb-2">
                                            <img id="service1Preview" src="<?= $service1['image_path']?>" class="border border-4 rounded object-fit-contain" width="240" height="240" alt="Service 1 Image">
                                        </div>

                                        <div class="mb-3">
                                            <label for="service1FileInput" class="form-label">Service Image</label>
                                            <input id="service1FileInput" name="service_1_image" class="form-control" type="file" accept=".png, .jpg, .jpeg">
                                        </div>

                                        <div class="mb-3">
                                            <label for="service1Title" class="form-label">Title</label>
                                            <input type="text" class="form-control" id="service1Title" name="service_1_title" required value="<?= $service1['title'] ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label for="service1Description" class="form-label">Description</label>
                                            <textarea class="form-control" id="service1Description" rows="3" name="service_1_description" required><?= $service1['description'] ?></textarea>
                                        </div>

                                        <script>
                                            // Logo Preview
                                            // https://medium.com/geekculture/how-to-preview-images-before-upload-with-javascript-3420e3cd2f1c
                                            const service1FileInput = document.querySelector('#service1FileInput');

                                            service1FileInput.addEventListener('change', function(event) {
                                                const file = service1FileInput.files;
                                                if (file) {
                                                    const fileReader = new FileReader();
                                                    const preview = document.querySelector('#service1Preview');
                                                    fileReader.onload = event => {
                                                        preview.setAttribute('src', event.target.result);
                                                    }
                                                    fileReader.readAsDataURL(file[0]);
                                                }
                                            });
                                        </script>
                                        
                                    </div>

                                    <!-- Service 2 -->
                                    <div class="col-md-4 mb-3">
                                        
                                        <?php
                                            $service2 = mysqli_fetch_assoc($queryResult);
                                        ?>

                                        <div class="d-flex flex-column align-items-center justify-content-center mb-2">
                                            <img id="service2Preview" src="<?= $service2['image_path']?>" class="border border-4 rounded object-fit-contain" width="240" height="240" alt="Service 2 Image">
                                        </div>

                                        <div class="mb-3">
                                            <label for="service2FileInput" class="form-label">Service Image</label>
                                            <input id="service2FileInput" name="service_2_image" class="form-control" type="file" accept=".png, .jpg, .jpeg">
                                        </div>

                                        <div class="mb-3">
                                            <label for="service2Title" class="form-label">Title</label>
                                            <input type="text" class="form-control" id="service2Title" name="service_2_title" required value="<?= $service2['title'] ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label for="service2Description" class="form-label">Description</label>
                                            <textarea class="form-control" id="service2Description" rows="3" name="service_2_description" required><?= $service2['description'] ?></textarea>
                                        </div>

                                        <script>
                                            // Logo Preview
                                            // https://medium.com/geekculture/how-to-preview-images-before-upload-with-javascript-3420e3cd2f1c
                                            const service2FileInput = document.querySelector('#service2FileInput');

                                            service2FileInput.addEventListener('change', function(event) {
                                                const file = service2FileInput.files;
                                                if (file) {
                                                    const fileReader = new FileReader();
                                                    const preview = document.querySelector('#service2Preview');
                                                    fileReader.onload = event => {
                                                        preview.setAttribute('src', event.target.result);
                                                    }
                                                    fileReader.readAsDataURL(file[0]);
                                                }
                                            });
                                        </script>

                                        
                                    </div>

                                    <!-- Service 3 -->
                                    <div class="col-md-4 mb-3">
                                        
                                        <?php
                                            $service3 = mysqli_fetch_assoc($queryResult);
                                        ?>

                                        <div class="d-flex flex-column align-items-center justify-content-center mb-2">
                                            <img id="service3Preview" src="<?= $service3['image_path']?>" class="border border-4 rounded object-fit-contain" width="240" height="240" alt="Service 3 Image">
                                        </div>

                                        <div class="mb-3">
                                            <label for="service3FileInput" class="form-label">Service Image</label>
                                            <input id="service3FileInput" name="service_3_image" class="form-control" type="file" accept=".png, .jpg, .jpeg">
                                        </div>

                                        <div class="mb-3">
                                            <label for="service3Title" class="form-label">Title</label>
                                            <input type="text" class="form-control" id="service3Title" name="service_3_title" required value="<?= $service3['title'] ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label for="service3Description" class="form-label">Description</label>
                                            <textarea class="form-control" id="service3Description" rows="3" name="service_3_description" required><?= $service3['description'] ?></textarea>
                                        </div>

                                        <script>
                                            // Logo Preview
                                            // https://medium.com/geekculture/how-to-preview-images-before-upload-with-javascript-3420e3cd2f1c
                                            const service3FileInput = document.querySelector('#service3FileInput');

                                            service3FileInput.addEventListener('change', function(event) {
                                                const file = service3FileInput.files;
                                                if (file) {
                                                    const fileReader = new FileReader();
                                                    const preview = document.querySelector('#service3Preview');
                                                    fileReader.onload = event => {
                                                        preview.setAttribute('src', event.target.result);
                                                    }
                                                    fileReader.readAsDataURL(file[0]);
                                                }
                                            });
                                        </script>
                                        
                                    </div>

                                      
                                </div>


                                <!-- PHP CODE -->
                                <?php
                                    if (isset($_POST['save_settings_services_btn'])) {

                                        // For Service 1
                                        $service1Image = empty($_FILES['service_1_image']['name']) ? null : $_FILES['service_1_image'];
                                        $service1Title = mysqli_real_escape_string($dbCon, $_POST['service_1_title']);
                                        $service1Description = mysqli_real_escape_string($dbCon, $_POST['service_1_description']);

                                        // For Service 2
                                        $service2Image = empty($_FILES['service_2_image']['name']) ? null : $_FILES['service_2_image'];
                                        $service2Title = mysqli_real_escape_string($dbCon, $_POST['service_2_title']);
                                        $service2Description = mysqli_real_escape_string($dbCon, $_POST['service_2_description']);

                                        // For Service 3
                                        $service3Image = empty($_FILES['service_3_image']['name']) ? null : $_FILES['service_3_image'];
                                        $service3Title = mysqli_real_escape_string($dbCon, $_POST['service_3_title']);
                                        $service3Description = mysqli_real_escape_string($dbCon, $_POST['service_3_description']);
                                        
                        
                                        // --- For Images

                                        // For Service 1 Image
                                        // Check if there's an uploaded Image
                                        $service1ImageUploadResult = false;
                                        $newService1ImageFileName;
                                        if ($service1Image !== null) {
                                            // Check File Type
                                            if ( $service1Image['type'] === 'image/png' || $service1Image['type'] === 'image/jpeg') {

                                                $filePathParts = pathinfo($service1Image['name']);
                                                $fileExtension = $filePathParts['extension'];
                                                $fileTemporaryPath = $service1Image['tmp_name'];

                                                $newService1ImageFileName = "service1Image" . "." . $fileExtension;
                                                $newService1ImageRelativeFilePath = "../../images/settings/" . $newService1ImageFileName;

                                                $service1ImageUploadResult = move_uploaded_file($fileTemporaryPath, $newService1ImageRelativeFilePath );
                                               
                                            } else {
                                                 ?>
                                                    <script>
                                                        alert('For Service 1, Please only choose JPEG, JPG, or PNG for the Image!');
                                                    </script>
                                                <?php
                                            }

                                        }

                                        // For Service 2 Image
                                        // Check if there's an uploaded Image
                                        $service2ImageUploadResult = false;
                                        $newService2ImageFileName;
                                        if ($service2Image !== null) {
                                            // Check File Type
                                            if ( $service2Image['type'] === 'image/png' || $service2Image['type'] === 'image/jpeg') {

                                                $filePathParts = pathinfo($service2Image['name']);
                                                $fileExtension = $filePathParts['extension'];
                                                $fileTemporaryPath = $service2Image['tmp_name'];

                                                $newService2ImageFileName = "service2Image" . "." . $fileExtension;
                                                $newService2ImageRelativeFilePath = "../../images/settings/" . $newService2ImageFileName;

                                                $service2ImageUploadResult = move_uploaded_file($fileTemporaryPath, $newService2ImageRelativeFilePath );
                                               
                                            } else {
                                                 ?>
                                                    <script>
                                                        alert('For Service 2, Please only choose JPEG, JPG, or PNG for the Image!');
                                                    </script>
                                                <?php
                                            }

                                        }

                                        // For Service 3 Image
                                        // Check if there's an uploaded Image
                                        $service3ImageUploadResult = false;
                                        $newService3ImageFileName;
                                        if ($service3Image !== null) {
                                            // Check File Type
                                            if ( $service3Image['type'] === 'image/png' || $service3Image['type'] === 'image/jpeg') {

                                                $filePathParts = pathinfo($service3Image['name']);
                                                $fileExtension = $filePathParts['extension'];
                                                $fileTemporaryPath = $service3Image['tmp_name'];

                                                $newService3ImageFileName = "service3Image" . "." . $fileExtension;
                                                $newService3ImageRelativeFilePath = "../../images/settings/" . $newService3ImageFileName;

                                                $service3ImageUploadResult = move_uploaded_file($fileTemporaryPath, $newService3ImageRelativeFilePath );
                                               
                                            } else {
                                                 ?>
                                                    <script>
                                                        alert('For Service 3, Please only choose JPEG, JPG, or PNG for the Image!');
                                                    </script>
                                                <?php
                                            }

                                        }


                                        // --- For Update database


                                        // Service 1 - Database
                                        $service1SaveResult = false;
                                        if ($service1Image !== null) { // Check if there is uploaded service1Image

                                            if ($service1ImageUploadResult) { // check if service1ImageUploadResult is success

                                                $newFilePath = "/burgershop/images/settings/" . $newService1ImageFileName;

                                                $query = "UPDATE services_tbl 
                                                    SET 
                                                        title = '$service1Title',
                                                        description = '$service1Description',
                                                        image_path = '$newFilePath'
                                                    WHERE service_id = 3";
                                                $service1SaveResult = mysqli_query($dbCon, $query);

                                                if ($service1SaveResult) { // If Success
                                                    ?>
                                                        <script>
                                                            alert('Service 1, Settings saved!');
                                                        </script>
                                                    <?php
                                                } else {
                                                    ?>
                                                        <script>
                                                            alert('Service 1, There is an error in saving. Please try again.');
                                                            window.location.assign('/burgershop/admin/settings/?tab=SERVICES');
                                                        </script>
                                                    <?php
                                                }
                                                
                                            }

                                            
                                        } else { // If no uploaded image, just update other details

                                            $query = "UPDATE services_tbl 
                                                SET 
                                                    title = '$service1Title',
                                                    description = '$service1Description'
                                                WHERE service_id = 3";
                                            $service1SaveResult = mysqli_query($dbCon, $query);

                                            if ($service1SaveResult) { // If Success
                                                ?>
                                                    <script>
                                                        alert('Service 1, Settings saved!');
                                                    </script>
                                                <?php
                                            } else {
                                                ?>
                                                    <script>
                                                        alert('Service 1, There is an error in saving. Please try again.');
                                                        window.location.assign('/burgershop/admin/settings/?tab=SERVICES');
                                                    </script>
                                                <?php
                                            }

                                        }

                                        // Service 2 - Database
                                        $service2SaveResult = false;
                                        if ($service2Image !== null) { // Check if there is uploaded service2Image

                                            if ($service2ImageUploadResult) { // check if service2ImageUploadResult is success

                                                $newFilePath = "/burgershop/images/settings/" . $newService2ImageFileName;

                                                $query = "UPDATE services_tbl 
                                                    SET 
                                                        title = '$service2Title',
                                                        description = '$service2Description',
                                                        image_path = '$newFilePath'
                                                    WHERE service_id = 4";
                                                $service2SaveResult = mysqli_query($dbCon, $query);

                                                if ($service2SaveResult) { // If Success
                                                    ?>
                                                        <script>
                                                            alert('Service 2, Settings saved!');
                                                        </script>
                                                    <?php
                                                } else {
                                                    ?>
                                                        <script>
                                                            alert('Service 2, There is an error in saving. Please try again.');
                                                            window.location.assign('/burgershop/admin/settings/?tab=SERVICES');
                                                        </script>
                                                    <?php
                                                }

                                            }

                                            
                                        } else { // If no uploaded image, just update other details

                                            $query = "UPDATE services_tbl 
                                                SET 
                                                    title = '$service2Title',
                                                    description = '$service2Description'
                                                WHERE service_id = 4";
                                            $service2SaveResult = mysqli_query($dbCon, $query);

                                            if ($service2SaveResult) { // If Success
                                                ?>
                                                    <script>
                                                        alert('Service 2, Settings saved!');
                                                    </script>
                                                <?php
                                            } else {
                                                ?>
                                                    <script>
                                                        alert('Service 2, There is an error in saving. Please try again.');
                                                        window.location.assign('/burgershop/admin/settings/?tab=SERVICES');
                                                    </script>
                                                <?php
                                            }

                                        }

                                        // Service 3 - Database
                                        $service3SaveResult = false;
                                        if ($service3Image !== null) { // Check if there is uploaded service3Image

                                            if ($service3ImageUploadResult) { // check if service3ImageUploadResult is success

                                                $newFilePath = "/burgershop/images/settings/" . $newService3ImageFileName;

                                                $query = "UPDATE services_tbl 
                                                    SET 
                                                        title = '$service3Title',
                                                        description = '$service3Description',
                                                        image_path = '$newFilePath'
                                                    WHERE service_id = 5";
                                                $service3SaveResult = mysqli_query($dbCon, $query);

                                                if ($service3SaveResult) { // If Success
                                                    ?>
                                                        <script>
                                                            alert('Service 3, Settings saved!');
                                                        </script>
                                                    <?php
                                                } else {
                                                    ?>
                                                        <script>
                                                            alert('Service 3, There is an error in saving. Please try again.');
                                                            window.location.assign('/burgershop/admin/settings/?tab=SERVICES');
                                                        </script>
                                                    <?php
                                                }

                                            }

                                            
                                        } else { // If no uploaded image, just update other details

                                            $query = "UPDATE services_tbl 
                                                SET 
                                                    title = '$service3Title',
                                                    description = '$service3Description'
                                                WHERE service_id = 5";
                                            $service3SaveResult = mysqli_query($dbCon, $query);

                                            if ($service3SaveResult) { // If Success
                                                ?>
                                                    <script>
                                                        alert('Service 3, Settings saved!');
                                                    </script>
                                                <?php
                                            } else {
                                                ?>
                                                    <script>
                                                        alert('Service 3, There is an error in saving. Please try again.');
                                                        window.location.assign('/burgershop/admin/settings/?tab=SERVICES');
                                                    </script>
                                                <?php
                                            }

                                        }


                                        // For Refresh, if all success
                                        if ($service1SaveResult && $service2SaveResult && $service3SaveResult) {
                                            ?>
                                                <script>
                                                    alert('All services saved!');
                                                    window.location.assign('/burgershop/admin/settings/?tab=SERVICES');
                                                </script>
                                            <?php
                                        }



                                    }
                                ?>

                            </form>
                        </div>
                    </div>

                </div>


            </div>

            <!-- Main Content End -->
        </div>

    </div>





    <?php include('../../templates/script-includes.php'); ?>
</body>

</html>