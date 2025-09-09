<?php
    
    session_start(); // For Session
    include('../../db-connection.php'); // Connect to database

    $burgerId = $_GET['id'];
    $queryResult = mysqli_query($dbCon, "DELETE FROM burgers_prices_tbl WHERE burger_id='$burgerId'");
    if ($queryResult) {
        $queryResult = mysqli_query($dbCon, "DELETE FROM burgers_tbl WHERE burger_id='$burgerId'");

        if ($queryResult) {
            ?>
                <script type="text/javascript">
                    alert("Burger has been deleted!");
                    window.location.assign('/burgershop/admin/burgers');
                </script>
            <?php
        } else {
            ?>
                <script type="text/javascript">
                    alert("There was an error in Deleting Burger - Can't Delete Burger");
                    window.location.assign('/burgershop/admin/burgers');
                </script>
            <?php
        }
    } else {
        ?>
            <script type="text/javascript">
                alert("There was an error in Deleting Burger - Can't Delete Plan Burger");
                window.location.assign('/burgershop/admin/burgers');
            </script>
        <?php
    }
    
?>

