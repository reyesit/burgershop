<?php
    // Note, $pageConfig variable comes from the main page, where this is imported
    
    // Prepare Settings
    $query = "SELECT * from settings_tbl LIMIT 1";
    $queryResult = mysqli_query($dbCon, $query);
    $settings = mysqli_fetch_all($queryResult, MYSQLI_ASSOC);
?>

<style>
    #sidebar .navbar-brand img {
        max-height: 80px;
        max-width: 80px;
    }

    #sidebar .nav-link {
        color: var(--bs-dark);
    }

    #sidebar .nav-link.active {
        color: var(--bs-light);
    }
</style>

<!-- Sidebar -->
<div id="sidebar" class="d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary vh-100" style="width: 240px;"> 

    <!-- Brand -->
    <a class="navbar-brand d-flex align-items-center" href="/">
        <img src="<?= $settings[0]['logo_image_path'] ?>" alt="Logo" class="d-inline-block align-text-top">
        <span class="fs-4 ms-2">
            <?= $settings[0]['website_name'] ?>
        </span>
    </a>
    <hr>

    <!-- Tabs -->
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item"> 
            <a class="nav-link <?php if($pageConfig['sidebarPage'] === 'DASHBOARD') echo 'active' ?>" href="/burgershop/admin"> 
                <i class="bi bi-speedometer2 pe-none me-2"></i>
                Dashboard
            </a> 
        </li>

        <li class="nav-item"> 
            <a class="nav-link <?php if($pageConfig['sidebarPage'] === 'USERS') echo 'active' ?>" href="/burgershop/admin/users"> 
                <i class="bi bi-people pe-none me-2"></i>
                Users
            </a> 
        </li>

        <li class="nav-item"> 
            <a class="nav-link <?php if($pageConfig['sidebarPage'] === 'CUSTOMERS') echo 'active' ?>" href="/burgershop/admin/customers"> 
                <i class="bi bi-person-circle pe-none me-2"></i>
                Customers
            </a> 
        </li>

        <li class="nav-item"> 
            <a class="nav-link <?php if($pageConfig['sidebarPage'] === 'PLANS') echo 'active' ?>" href="/burgershop/admin/plans"> 
                <i class="bi bi-file-earmark-post pe-none me-2"></i>
                Plans
            </a> 
        </li>

        
        
        <li class="nav-item"> 
            <a class="nav-link <?php if($pageConfig['sidebarPage'] === 'TICKETS') echo 'active' ?>" href="/burgershop/admin/tickets"> 
                <i class="bi bi-ticket-perforated pe-none me-2"></i>
                Tickets
            </a> 
        </li>
        

        <li class="nav-item"> 
            <a class="nav-link <?php if($pageConfig['sidebarPage'] === 'BILLS_AND_PAYMENTS') echo 'active' ?>" href="/burgershop/admin/bills-and-payments"> 
                <i class="bi bi-receipt pe-none me-2"></i>
                Bills & Payments
            </a> 
        </li>

        

        <li class="nav-item"> 
            <a class="nav-link <?php if($pageConfig['sidebarPage'] === 'SETTINGS') echo 'active' ?>" href="/burgershop/admin/settings"> 
                <i class="bi bi-gear pe-none me-2"></i>
                Settings
            </a> 
        </li>

    </ul>
    <hr>
    
</div>
<!-- Sidebar End -->