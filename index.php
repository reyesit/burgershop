<?php 

    session_start();
    include('db-connection.php');

    // QUERY FOR THE SETTINGS
    $query = "SELECT * FROM `settings_tbl` LIMIT 1";
    $queryResult = mysqli_query($dbCon, $query);
    $settings = mysqli_fetch_assoc($queryResult);


?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $settings['website_name'] ?></title>
	
    <!-- link the CSS files of BS -->
    <link rel="stylesheet" href="css/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

    <style>
        :root {
            --bs-warning: #ffc107;
            --dark-red: #d30528ff;
            --light-red: #fa4a67ff;
        }

        /*height of logo in navbar*/
        .navbar-brand img {
            max-height: 60px;
        }

        /*to make the section 100% in height and width*/
        .nav-link-hero-contents {
            min-height: 100vh;
            height: auto;
            width: 100%;
        }

        /*to make the circle scroll to top not visible when page loads*/
        #scrollToStartButton {
            display: none;
        }

        /*picture in home section*/
        #home {
            background-image: url(images/home-section-picture.jpg);
        }

         #about > .row {
            margin: 0 5vw;
            margin-top: 8rem;
        }

        #about > .row .subheader {
            margin: 0 10vw;
        }

        /*about section image*/
        #about img {
            max-width: 420px;
        }

        /*burgers section*/
        #burgers {
            min-height: 100vh;
            height: auto;
            background: linear-gradient( var(--dark-red), var(--light-red));
        }

        #burgers .header {
            margin-top: 8rem;
        }
        #burgers .burger-list {
            margin-bottom: 2rem;
        }

        #burgers .burger {
            margin-top: 1rem;
            width: 18rem;
        }

        #burgers .row {
            margin-top: 2rem;
            width: 80vw;
        }

        #burgers .burger .card-body {
            padding: 5rem 2rem;
        }

        /*services section*/
        #services {
            min-height: 80vh;
            height: auto;
        }

        #services .header {
            margin-top: 8rem;
        }

        #services .services-list .col {
            padding: 0 2rem;
        }

        #services .service {
            width: 18rem;
        }

        #services .service img {
            max-width: 290px;
            max-height: 290px;
            object-fit: cover;
        }

        /*contact us section*/
        #contactUs {
            min-height: 20vh;
            background-color: var(--bs-warning);
        }

        #contactUs .bi {
            margin-right: .25rem;
            color: black;
        }


    </style>

</head>
<body>

	<!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top bg-warning shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center fw-bold" href="/burgershop/index.php">
                <img src="images/new-logo.png" alt="Logo" class="d-inline-block align-text-top">
                <?= $settings['website_name'] ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item px-2">
                        <a class="nav-link" aria-current="page" href="#home">Home</a>
                    </li>
                    <li class="nav-item px-2">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item px-2">
                        <a class="nav-link" href="#burgers">Burgers</a>
                    </li>
                    <li class="nav-item px-2">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item px-2">
                        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#loginModal">
                            Login
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

	
    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div>
                        <h2 class="fw-normal text-center mb-5 mt-2">
                            <i class="bi bi-person"></i>
                            Login
                        </h2>

                        <form action="" method="POST">
                            <div class="mb-3 mt-4">
                                <label for="loginEmail" class="form-label">Email address</label>
                                <input type="email" name="email" class="form-control" id="loginEmail" aria-describedby="emailHelp" placeholder="example@gmail.com">
                                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                            </div>
                            <div class="mb-3 mt-4">
                                <label for="loginPassword" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="loginPassword" placeholder="Password">
                            </div>
                            <button type="submit" name="login-button" class="btn btn-danger w-100 mt-2">Login</button>


                            <!-- PHP CODE -->
                            <?php
                                if (isset($_POST['login-button'])) {
                                    $email = mysqli_real_escape_string($dbCon, $_POST['email']);
                                    $password = mysqli_real_escape_string($dbCon, $_POST['password']);

                                    $query = "SELECT *
                                        FROM `users_tbl`
                                        WHERE email = '$email'
                                        LIMIT 1";

                                    $queryResult = mysqli_query($dbCon, $query);
                                    $userData = (mysqli_fetch_all($queryResult, MYSQLI_ASSOC))[0];
                                
                                
                                // to check if there is no rows found in DB
                                if (mysqli_num_rows($queryResult) === 0) {
                                
                            ?> <!-- close the PHP code so the script will be inputted --> 
                                 <script>
                                     alert('Invalid email or password!');
                                     window.location.assign('index.php');
                                 </script>

                            <?php 
                                }

                                // check if password is correct
                                if (! password_verify($password, $userData['password'])) {
                            ?>
                                <script>
                                    alert('Invalid email or password!');
                                    window.location.assign('index.php');
                                </script>
                            <?php 
                                }

                                // getting the additional data of user
                                if ($userData['role'] === 'ADMIN') {
                                    $query = "SELECT * 
                                        FROM `admins_tbl`
                                        WHERE admin_user_id = '" . $userData['user_id'] . "'
                                        LIMIT 1";
                                    $queryResult = mysqli_query($dbCon, $query);
                                    $dataResult = (mysqli_fetch_all($queryResult, MYSQLI_ASSOC))[0];
                                } else if ($userData['role'] === 'CUSTOMER') {
                                    $query = "SELECT * 
                                        FROM `customers_tbl`
                                        WHERE customer_user_id = '" . $userData['user_id'] . "'
                                        LIMIT 1";
                                    $queryResult = mysqli_query($dbCon, $query);
                                    $userData = (mysqli_fetch_all($queryResult, MYSQLI_ASSOC))[0];
                                }

                                // add the user data to the session
                                $_SESSION['user'] = [
                                    'id' => $userData['user_id'],
                                    'email' => $userData['email'],
                                    'role' => $userData['role'],
                                    'first_name' => $userData['first_name'],
                                    'middle_name' => $userData['middle_name'],
                                    'last_name' => $userData['last_name'],
                                    'profile_image_path' => $userData['profile_image_path'],
                                    'details' => $userData['details'], //The 'details' key stores additional user data. The 'user' session is a container for all user info.
                                ];

                                    // Redirect to respective dashboard based on role
                                    if ($userData['role'] === 'ADMIN') {
                                        ?>
                                        <script>
                                            alert('Welcome <?= $userData['first_name'] ?>!');
                                            window.location.assign('admin/index.php');
                                        </script>
                                    <?php 
                                    } else if ($userData['role'] === 'CUSTOMER') {
                                        ?>
                                        <script>
                                            alert('Welcome <?= $userData['first_name'] ?>!');
                                            window.location.assign('customer/index.php');
                                        </script>
                                    <?php 
                                } 
                            }
                        ?>

                        </form>
                    </div>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> -->
            </div>
        </div>
    </div>
    <!-- Login Modal - End -->


    <!-- Scroll to Top -->
    <a id="scrollToStartButton" href="#home" class="btn btn-dark position-fixed bottom-0 end-0 me-5 mb-5 rounded-circle">
        <h1>
            <i class="bi bi-chevron-double-up"></i> 
        </h1>
    </a>

    <!-- Home -->
    <div id="home" class="nav-link-hero-contents d-flex">
        
    </div>
    <!-- Home - End -->

    <!-- About -->
    <div id="about" class="nav-link-hero-contents d-flex justify-content-center align-items-center">

        <div class="row">
            <div class="col col-auto">
                <img src="<?= $settings['logo_image_path'] ?>" alt="large_logo"/>
            </div>
            <div class="col text-center">
                <h1 class="display-4 fw-bold text-danger">We Make Best Burger in the World</h1>
                <h2 class="subheader d-block mt-4 fw-normal">Sa Kris Burger, Unang kagat tinapay agad!</h2>
            </div>
        </div>
    </div>
    <!-- About - End -->

     <!-- Burgers -->
    <div id="burgers" class="nav-link-hero-contents d-flex flex-column justify-content-center align-items-center">

        <div class="header text-white text-center">
            <h1 class="display-4 fw-bold">Burgers</h1>
            <span class="d-block lead">Bumili na ang aming masarap na Burger. Mura na, masarap pa!</span>
        </div>

        <div class="burger-list">

            <!-- PHP code for burgers -->
            <?php
                // Prepare Burgers Query
                $query = "SELECT name, description, price
                    FROM 
                        `burgers_tbl`
                    INNER JOIN
                        `burgers_prices_tbl` ON burgers_tbl.burger_id = burgers_prices_tbl.burger_id
                    WHERE burgers_prices_tbl.is_current = 1";
                $queryResult = mysqli_query($dbCon, $query);
                
                $displayedBurgerCtrPerRow = 0;
                $displayedBurgerCtr = 0;
                $burgersCount = mysqli_num_rows($queryResult);
            ?>
            <?php while($burger = mysqli_fetch_assoc($queryResult)) { ?>

                <?php if ($displayedBurgerCtrPerRow === 0) { ?>
                    <div class="row">
                <?php } ?>

                        <!-- Burger Card -->
                        <div class="col d-flex justify-content-center align-items-center">

                            <div class="burger card mb-3 text-center">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $burger['name']?></h5>
                                    <p class="card-text"><?= $burger['description']?></p>
                                </div>
                            </div>

                        </div>

                    <?php 
                        $displayedBurgerCtrPerRow++; 
                        $displayedBurgerCtr++; 
                    ?>
                    <?php if (
                            $displayedBurgerCtrPerRow === 3 ||
                            ($displayedBurgerCtr === $burgersCount)
                        ) { 
                            $displayedBurgerCtrPerRow = 0; //reset
                            ?>
                            </div>
                    <?php } ?>

                <?php } ?>

                
        </div>
    </div>
    <!-- Burgers - End -->

    <div class="nav-link-hero-contents">

        <!-- Services -->
        <div id="services" class="d-flex flex-column justify-content-center align-items-center">
            <div class="header text-center mb-4">
                <h1 class="display-4 fw-bold">Our Services</h1>
                <span class="d-block lead">Masarap na tinapay para sa taong bayan. Hindi ka magsisisi basta iyong lasapin.</span>
            </div>

            <div class="services-list mb-4">
                <div class="row">

                    <!-- PHP code for services --> 
                    <?php 

                    $query = "SELECT * FROM `services_tbl`";
                    $queryResult = mysqli_query($dbCon, $query);

                    ?>

                    <?php 
                        while($service = mysqli_fetch_assoc($queryResult)) {
                    ?> <!-- need isara para makapag makapagpasok ng html for burgers card (hamburger method) -->

                    <!-- Service card -->
                        <div class="col">
                            <div class="service card">
                                <img src="<?= $service['image_path'] ?>" class="card-img-top" alt="service">
                                <div class="card-body text-center">
                                    <h5 class="card-title"><?= $service['title'] ?></h5>
                                    <p class="card-text"><?= $service['description'] ?></p>
                                </div>
                            </div>
                        </div>
                    <?php 
                        } //eto yung magsasara ng curly brackets sa while loop
                    ?>

                        

                </div>
            </div>
        </div>

        <!-- Contact Us -->
        <div id="contactUs" class="d-flex flex-column justify-content-center align-items-center text-dark">
            <div class="my-2">
                <h4>Contact Us</h4>
            </div>
            <div class="text-center">

                <!-- Number -->
                <div>
                    <span>
                        <i class="bi bi-telephone-fill"><?= $settings['contact_number'] ?></i>
                        
                    </span>
                </div>

                <!-- Email -->
                <div>
                    <span>
                        <i class="bi bi-envelope-fill"><?= $settings['email'] ?></i>
                        
                    </span>
                </div>

                <!-- Location -->
                <div>
                    <span>
                        <i class="bi bi-pin-map-fill"><?= $settings['location'] ?></i>
                        
                    </span>
                </div>
            </div>

            <div class="mt-4">
                <span>
                    <i class="bi bi-c-circle fw-bold"><?= $settings['copyright_name'] ?></i>
                    
                </span>
            </div>
        </div>

    </div>


	<!-- link the JS/Script link of BS -->
    <script src="js/bootstrap.bundle.min.js">
        
    </script>

    <!-- nawawala na yung scroll to start button pag nag scroll ng greater 20px ang user kapag nasa taaas na ulit ang user ng homepage mawawala ito  -->
    <script>
        const scrollToStartButton = document.getElementById('scrollToStartButton');
        window.addEventListener("scroll", () => {
            scrollToTopToggleShowListener();
        })

        function scrollToTopToggleShowListener() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                scrollToStartButton.style.display = 'block';
            } else {
                scrollToStartButton.style.display = 'none';
            }
        }
    </script>

</body>
</html>