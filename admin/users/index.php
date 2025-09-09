<?php

    session_start(); // For Session
    include('../../db-connection.php'); // Connect to database

    // Prepare Sidebar
    $pageConfig = [
        'sidebarPage' => 'USERS',
    ];

    // Prepare Table Pagination
    $params = [
        'page' => mysqli_real_escape_string($dbCon, isset($_GET['page']) ? $_GET['page'] : 1),
        'limit' => mysqli_real_escape_string($dbCon, isset($_GET['limit']) ? $_GET['limit'] : 10),
        'filter_search' => mysqli_real_escape_string($dbCon, isset($_GET['filter_search']) ? $_GET['filter_search'] : ''),
        'filter_role' => mysqli_real_escape_string($dbCon, isset($_GET['filter_role']) ? $_GET['filter_role'] : ''),
    ]; // sanitize

    //cast the pagination page and limit into int to make sure it will be int only
    $pagination = [
        'page' => (int)$params['page'],
        'limit' => (int)$params['limit'],
    ];

    //variables for filters of role and search box
    $filters = [
        'filter_search' => $params['filter_search'],
        'filter_role' => $params['filter_role'],
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
    .dropdown-menu .dropdown-item:hover, 
    .dropdown-menu .dropdown-item:focus {
        background-color: var(--bs-danger);
        color: white;
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
                <h1 class="display-6">Users</h1>

                <!-- Table Actions -->
                <div class="d-flex justify-content-end">
                    <div class="btn-group">
                        <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Create User
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/burgershop/admin/users/add-admin.php">Admin</a></li>
                            <li><a class="dropdown-item" href="/burgershop/admin/users/add-customer.php">Customer</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Filters -->
                <div class="border-primary-subtle rounded py-2 mt-4">

                    <form class="d-flex justify-content-between align-items-end" method="GET">

                        <div>
                            <div class="input-group">
                                <span class="input-group-text bg-danger border border-danger" id="search-icon"><i class="bi bi-search text-white"></i></span>
                                <input type="text" name="filter_search" class="form-control border-danger" placeholder="Search Name" aria-label="Search" aria-describedby="search-icon"
                                    value="<?= $filters['filter_search'] ?>">
                            </div>
                        </div>

                        <div class="d-flex align-items-end">
                            <div class="me-3">
                                <label for="filterRole" class="badge rounded-pill bg-danger">Role</label>
                                <select id="filterRole" name="filter_role" class="form-select border-danger" aria-label="Role">
                                    <!-- 'selected' is used to preselect the matching role based on user input or default to 'All' -->
                                    <option value="" <?php if($filters['filter_role'] === '') echo 'selected'; ?>>All</option>
                                    <option value="ADMIN" <?php if($filters['filter_role'] === 'ADMIN') echo 'selected'; ?>>Admin</option>
                                    <option value="CUSTOMER" <?php if($filters['filter_role'] === 'CUSTOMER') echo 'selected'; ?>>Customer</option>
                                </select>
                                
                            </div>
                            
                            <div>
                                <button class="btn btn-danger">Filter</button>
                            </div>

                        </div>

                    </form>

                </div>

                <!-- Table -->
                <table class="table table-hover caption-top">
                    <caption>List of Users</caption>
                    <thead class="table-danger">
                        <th>#</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </thead>
                    <tbody class="align-middle">

                        <?php 
                            // Compute row start count 
                            $rowStartCount = ($pagination['limit'] * $pagination['page']) - $pagination['limit'];

                            // Prepare Plans
                            $limit = mysqli_real_escape_string($dbCon, $pagination['limit']);
                            $offset = ($limit * $pagination['page']) - $limit;
                            $filterSearch = $filters['filter_search'];
                            $filterRole = $filters['filter_role'];
                            $query = "SELECT user_id, email, first_name, middle_name, last_name, role
                                FROM 
                                    users_tbl
                                WHERE 
                                    (
                                        first_name LIKE '%$filterSearch%' OR
                                        middle_name LIKE '%$filterSearch%' OR
                                        last_name LIKE '%$filterSearch%'
                                    )
                                    AND
                                    role LIKE '%$filterRole%'
                                ";

                            $queryWithLimitOffset = $query . "
                                LIMIT $limit
                                OFFSET $offset
                                ";

                            $queryResult = mysqli_query($dbCon, $queryWithLimitOffset);

                            // For Pagination
                            $pagination['totalRowCount'] = mysqli_num_rows(mysqli_query($dbCon, $query));
                        ?>
                        <?php while($user = mysqli_fetch_assoc($queryResult)) { ?>
                            <tr>
                                <th scope="row"><?= ++$rowStartCount // Since rowStartCount is 0 or last count of previous page, we add 1 first before displaying it, that's why the "++" is before the variable ?></th>
                                <td><?= $user['email'] ?></td>
                                <td><?= $user['first_name'] ?> <?= isset($user['middle_name']) ? $user['middle_name']." " : '' ?><?= $user['last_name'] ?></td>
                                <td><?= $user['role'] ?></td>
                                <td>
                                    <!-- TODO
                                    <a class="btn btn-primary" href="/admin/users/view.php?id=<?= $user['user_id'] ?>">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    -->

                                    <?php
                                       // if ((int)$_SESSION['user']['details']['is_superadmin'] === 1) { // Check if superadmin
                                    ?>
                                        <!-- TODO
                                        <a class="btn btn-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a class="btn btn-danger" href="/admin/users/delete.php?id=<?= $user['user_id'] ?>">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                        -->
                                    <?php
                                        }
                                    ?>


                                </td>
                            </tr>
                        <?php // } ?>
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