<?php

// Has logout occured?
if (isset($_GET['logout'])) {

    session_start();

    // Destroy the session. 
    session_destroy();
}

require('php/common/dbConn.php');
require('php/alcatraz.php');
require('php/common/xhtmlStrict.php');
require('php/public/publicHeader.php');
require('php/public/publicBody.php');
require('php/public/publicFooter.php');
?>