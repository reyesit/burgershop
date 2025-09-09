<?php

    session_start(); // For Session
    include('../../db-connection.php'); // Connect to database

    // Prepare Sidebar
    $pageConfig = [
        'sidebarPage' => 'BURGERS',
    ];

    // Prepare Table Pagination
    $params = [
        'page' => mysqli_real_escape_string($dbCon, isset($_GET['page']) ? $_GET['page'] : 1),
        'limit' => mysqli_real_escape_string($dbCon, isset($_GET['limit']) ? $_GET['limit'] : 10),
    ]; // sanitize

    $pagination = [
        'page' => (int)$params['page'],
        'limit' => (int)$params['limit'],      
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
                <h1 class="display-6">Burgers</h1>

                <!-- Table Actions -->
                <div class="d-flex justify-content-end">
                    <a class="btn btn-danger" role="button" href="/burgershop/admin/burgers/add.php">Add Burger</a>
                </div>

                <!-- Filters -->
                <!-- Todo -->

                <!-- Table -->
                <table class="table table-hover caption-top">
                    <caption>List of Burgers</caption>
                    <thead class="table-danger">
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </thead>
                    <tbody class="align-middle">

                        <?php 
                            // Compute row start count 
                            $rowStartCount = ($pagination['limit'] * $pagination['page']) - $pagination['limit'];

                            // Prepare Burgers
                            $limit = mysqli_real_escape_string($dbCon, $pagination['limit']);
                            $offset = ($limit * $pagination['page']) - $limit;
                            $query = "SELECT burgers_tbl.burger_id,name, description, price
                                FROM 
                                    burgers_tbl
                                INNER JOIN
                                    burgers_prices_tbl ON burgers_tbl.burger_id = burgers_prices_tbl.burger_id
                                WHERE burgers_prices_tbl.is_current = 1
                                ";

                            $queryWithLimitOffset = $query . "
                                LIMIT $limit
                                OFFSET $offset
                                ";

                            $queryResult = mysqli_query($dbCon, $queryWithLimitOffset);

                            // For Pagination
                            $pagination['totalRowCount'] = mysqli_num_rows(mysqli_query($dbCon, $query));
                        ?>
                        <?php while($burger = mysqli_fetch_assoc($queryResult)) { ?>
                            <tr>
                                <th scope="row"><?= ++$rowStartCount // Since rowStartCount is 0 or last count of previous page, we add 1 first before displaying it, that's why the "++" is before the variable ?></th>
                                <td><?= $burger['name'] ?></td>
                                <td><?= $burger['description'] ?></td>
                                <td><span>&#8369;</span><?= number_format($burger['price'], 2) ?></td>
                                <td>
                                    <a class="btn btn-primary" href="/burgershop/admin/burgers/view.php?id=<?= $burger['burger_id'] ?>">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a class="btn btn-warning" href="/burgershop/admin/burgers/edit.php?id=<?= $burger['burger_id'] ?>">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a class="btn btn-danger" href="/burgershop/admin/burgers/delete.php?id=<?= $burger['burger_id'] ?>"
                                        onclick="return confirm('Are you sure you want to delete Plan: [ <?= $burger['name'] ?> ] and all related data?')">
                                        <i class="bi bi-trash"></i>
                                    </a>

                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <?php include('../admin-templates/pagination.php') ?>
            </div>

            <!-- Main Content End -->
        </div>

    </div>

    

    

    <?php include('../../templates/script-includes.php'); ?>
</body>

</html>