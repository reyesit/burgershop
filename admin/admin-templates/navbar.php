
<style>
    #navbarProfile .dropdown-menu {
        min-width: fit-content;
        width: 100%;
        margin-top: 5px;
    }
</style>

<!-- Navbar -->
<nav id="navbar" class="navbar bg-danger" style="height: 8%;">
    <div class="container-fluid d-flex justify-content-end">
        <div>
            <ul class="navbar-nav flex-row mb-2 mb-lg-0">
                <li class="nav-item px-2">
                    <a class="nav-link text-light" href="#">
                        <i class="bi bi-bell"></i>
                    </a>
                </li>

                <!-- Profile -->
                <li id="navbarProfile" class="nav-item d-flex align-items-center px-2">
                    <div class="dropdown d-flex"> 

                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-light" data-bs-toggle="dropdown" aria-expanded="false"> 
                            <img src="https://github.com/mdo.png" alt="" width="32"height="32" class="rounded-circle me-2">
                            <strong><?= $_SESSION['user']['first_name'] ?></strong>
                        </a>
                        <!-- Dropdown-menu -->
                        <ul class="dropdown-menu text-small shadow position-absolute">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                                <form class="m-0">
                                    <li><button role="button" type="submit" name="sign_out_btn" class="dropdown-item">Sign out</button></li>
                                    

                                    <!-- PHP CODE -->
                                    <?php
                                        if(isset($_REQUEST['sign_out_btn']))
                                        {
                                            //session_destroy();
                                            unset($_SESSION['user']);
                                            ?>
                                            <script>
                                                window.location.assign('/burgershop/index.php');
                                            </script>
                                            <?php
                                        }
                                    ?>
                                </form>
                        </ul>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</nav>
<!-- Navbar End -->
