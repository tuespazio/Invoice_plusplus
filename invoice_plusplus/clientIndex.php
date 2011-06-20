<?php

session_start();

// Unset any debug mode.
unset($_SESSION['debugMode']);

// If debug mode is set...
if(isset($_GET['debugMode'])) {
    
    $_SESSION['debugMode'] = 1;
    // Set login to successful
    $_SESSION['loginSuccessful'] = "DEBUG MODE";
    // Set the security level.
    $_SESSION['securityLevel'] = $_GET['secLevel'];
}

if (isset($_SESSION['loginSuccessful'])) {

    // Unset the current invoice session variable.
    unset($_SESSION['currentInvoice']); 

    require('php/alcatraz.php');
    require('php/common/xhtmlStrict.php');
    require('php/clientSite/clientHeader.php');
    require('php/clientSite/clientBody.php');
    require('php/clientSite/clientFooter.php');
} else {

    echo "<p><strong>You need to be logged in!</strong></p>";
    echo "<p>Click this link and click login to gain access!</p>";
    echo "<p><a href=\"index.php\" title=\"Login Link\" alt=\"Login Link\">Login</a></p>";
    
}
?>
