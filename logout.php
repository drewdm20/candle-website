<?php
if (isset($_SESSION['account_loggedin'])) {
    // Remove the session variables
    unset($_SESSION['account_loggedin']);
    unset($_SESSION['account_id']);
    unset($_SESSION['account_admin']);
}
// Redirect to home page
header('Location: route.php'); 
?>
