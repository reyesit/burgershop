<?php

    session_start(); // For Session
    include('../../db-connection.php'); // Connect to database

    // Prepare Sidebar
    $pageConfig = [
        'sidebarPage' => 'PLANS',
    ];
    /*
    // Prepare Table Pagination
    $params = [
        'page' => mysqli_real_escape_string($dbCon, isset($_GET['page']) ? $_GET['page'] : 1),
        'limit' => mysqli_real_escape_string($dbCon, isset($_GET['limit']) ? $_GET['limit'] : 10),
    ]; // sanitize

    $pagination = [
        'page' => (int)$params['page'],
        'limit' => (int)$params['limit'],      
    ];
    */
?>

<!-- HTML Start -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>

    <?php include('../../templates/head-includes.php'); ?>

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
                <h1 class="display-6">Plans</h1>

                <!-- Table Actions -->
                <div class="d-flex justify-content-end">
                    <a class="btn btn-primary" role="button" href="/admin/plans/add.php">Add Plan</a>
                </div>

                <!-- Filters -->
                <!-- Todo -->

                <!-- Table -->
                <table class="table table-hover caption-top">
                    <caption>List of Plans</caption>
                    <thead class="table-primary">
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </thead>
                    <tbody class="align-middle">

                        
                            <tr>
                                <th></th>
                                <td></td>
                                <td></td>
                                <td><span>&#8369;</span></td>
                                <td>
                                    <a class="btn btn-primary" href="/admin/plans/view.php?id=">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a class="btn btn-warning" href="/admin/plans/edit.php?id=">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a class="btn btn-danger" href="/admin/plans/delete.php?id="
                                        onclick="return confirm('Are you sure you want to delete Plan: [  ] and all related data?')">
                                        <i class="bi bi-trash"></i>
                                    </a>

                                </td>
                            </tr>
                        
                    </tbody>
                </table>

                
            </div>

            <!-- Main Content End -->
        </div>

    </div>

    

    

    <?php include('../../templates/script-includes.php'); ?>
</body>

</html>