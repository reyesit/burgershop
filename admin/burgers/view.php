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
                        <li class="breadcrumb-item active">View</li>
                    </ol>
                </nav>

                <?php
                    $burgerId = mysqli_real_escape_string($dbCon, $_GET['id']);
                    $query = "SELECT name, description, price
                        FROM 
                            burgers_tbl
                        INNER JOIN
                            burgers_prices_tbl ON burgers_tbl.burger_id = burgers_prices_tbl.burger_id
                        WHERE 
                            burgers_tbl.burger_id = '$burgerId' AND
                            burgers_prices_tbl.is_current = 1";
                    $queryResult = mysqli_query($dbCon, $query);
                    $burger = mysqli_fetch_assoc($queryResult);
                ?>
                <form action="" method="POST">

                    <!-- Title -->
                    <h1 class="display-6"><?= $burger['name'] ?></h1>

                    <!-- Table Actions -->
                    <div class="d-flex justify-content-end">
                        <a href="/burgershop/admin/burgers/edit.php?id=<?= $burgerId ?>" class="btn btn-warning" name="add_burger_btn" >Edit</a>
                    </div>

                    <!-- Form -->
                    <div class="card mt-2">
                        <div class="card-header">
                            Burger Details
                        </div>
                        <div class="card-body row">


                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required disabled value="<?= $burger['name'] ?>">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control" step="0.01" min="0" id="price" name="price" required disabled value="<?= $burger['price'] ?>">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" rows="3" name="description" required disabled><?= $burger['description'] ?></textarea>
                            </div>

                            <div class="col-md-12 overflow-auto" style="height: 35vh;">
                                <!-- Table -->
                                <table class="table table-hover caption-top">
                                    <caption>Price History</caption>
                                    <thead class="table-primary">
                                        <th>#</th>
                                        <th>Date Changed</th>
                                        <th>Price</th>
                                        <th>Change By</th>
                                    </thead>
                                    <tbody class="align-middle">

                                        <?php 
                                            $query = "SELECT 
                                                    burgers_prices_tbl.price, burgers_prices_tbl.created_at,
                                                    users_tbl.email, users_tbl.first_name, users_tbl.middle_name, users_tbl.last_name
                                                FROM 
                                                    burgers_prices_tbl
                                                INNER JOIN
                                                    users_tbl on users_tbl.user_id = burgers_prices_tbl.changed_by
                                                WHERE burgers_prices_tbl.burger_id = '$burgerId'
                                                ORDER BY burgers_prices_tbl.created_at DESC
                                                ";

                                            $queryResult = mysqli_query($dbCon, $query);
                                            $rowIndex = 0;
                                        ?>
                                        <?php while($burgerPrice = mysqli_fetch_assoc($queryResult)) { ?>
                                            <tr>
                                                <th scope="row"><?= ++$rowIndex ?></th>
                                                <td><?= date_format(new DateTime($burgerPrice['created_at']), 'F j, Y - g:i A') ?></td>
                                                <td><span>&#8369;</span><?= number_format($burgerPrice['price'], 2) ?></td>
                                                <td><?= $burgerPrice['email'] ?> - <?= $burgerPrice['last_name'] ?>, <?= $burgerPrice['first_name'] ?> <?= $burgerPrice['middle_name'] ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>

                </form>

                
            </div>

            <!-- Main Content End -->
        </div>

    </div>

    

    

    <?php include('../../templates/script-includes.php'); ?>
</body>

</html>