<?php

    session_start(); // For Session
    include('../../db-connection.php'); // Connect to database

    // Prepare Sidebar
    $pageConfig = [
        'sidebarPage' => 'BURGERS',
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
        .breadcrumb .breadcrumb-item a {
            color: var(--bs-danger);
        }
         .breadcrumb .breadcrumb-item a:hover {
            color: #a71d2a;
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
                        <li class="breadcrumb-item"><a href="/burgershop/admin/burgers">Burgers</a></li>
                        <li class="breadcrumb-item active">Add</li>
                    </ol>
                </nav>

                
                <form action="" method="POST">

                    <!-- Title -->
                    <h1 class="display-6">Create Burger</h1>

                    <!-- Table Actions -->
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-danger" name="add_burger_btn" type="submit">Save</button>
                    </div>

                    <!-- Form -->
                    <div class="card mt-2">
                        <div class="card-header">
                            Burger Details
                        </div>
                        <div class="card-body row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control" step="0.01" min="0" id="price" name="price" required>
                            </div>

                            <div class="col-md-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" rows="3" name="description" required></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- PHP CODE -->
                    <?php
                        if (isset($_POST['add_burger_btn'])) {
                            $name = mysqli_real_escape_string($dbCon, $_POST['name']);
                            $price = mysqli_real_escape_string($dbCon, $_POST['price']);
                            $description = mysqli_real_escape_string($dbCon, $_POST['description']);

                            $query = "INSERT INTO burgers_tbl(name, description) VALUES ('$name', '$description')";
                            $queryResult = mysqli_query($dbCon, $query);

                            if ($queryResult) {

                                $insertBurgerId = mysqli_insert_id($dbCon);
                                $currentAdminUserId = $_SESSION['user']['id'];

                                $query = "INSERT INTO burgers_prices_tbl(burger_id, price, changed_by) VALUES ('$insertBurgerId', '$price', '$currentAdminUserId')";
                                $queryResult = mysqli_query($dbCon, $query);

                                if ($queryResult) {
                                    ?>
                                    <script type="text/javascript">
                                        alert("Burger has been created!");
                                        window.location.assign('/burgershop/admin/burgers');
                                    </script>
                                    <?php
                                } else {
                                    // Delete inserted if it fails
                                    $query = "DELETE FROM burgers_tbl WHERE burger_id = '$insertBurgerId'";
                                    $queryResult = mysqli_query($dbCon, $query);
                                    ?>
                                    <script type="text/javascript">
                                        alert("Failed to Create Burger!");
                                        window.location.assign('/burgershop/admin/burgers');
                                    </script>
                                    <?php
                                }
                            } else {
                                ?>
                                <script type="text/javascript">
                                    alert("Failed to Create Burger!");
                                    window.location.assign('/burgershop/admin/burgers');
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