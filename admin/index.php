<?php

    session_start(); // For Session
    include('../db-connection.php'); // Connect to database

    // Prepare Sidebar - dito yung sa Dashboard ang active
    $pageConfig = [
        'sidebarPage' => 'DASHBOARD',
    ];

?>

<!-- HTML Start -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>

    <?php include('../templates/head-includes.php'); ?>

</head>

<body class="vh-100">

    <div class="d-flex">

        <div class="col-auto px-0">
            <?php include('admin-templates/sidebar.php'); ?>
        </div>

        <div class="col px-0">
            <?php include('admin-templates/navbar.php'); ?>

            <!-- Main Content Here -->
            <div class="p-4">

                <!-- Title -->
                <h1 class="display-6">Dashboard</h1>

                
            </div>

            <!-- Main Content End -->
        </div>

    </div>

    

    

    <?php include('../templates/script-includes.php'); ?>
</body>

</html>