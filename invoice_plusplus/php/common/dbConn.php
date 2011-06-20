<?php

// Declare and define database details to lower code repetition.
$sqlConn = NULL;

function ConnectToDB() {

    $sqlDBHost = "localhost";
    $sqlDBUser = "root";
    $sqlDBPass = "";
    $sqlDBName = "invoice_plusplus";

    // Connect to the database.
    $sqlConn = mysql_connect($sqlDBHost, $sqlDBUser, $sqlDBPass);

    // Error testing
    if (!$sqlConn) {

        die('Could not connect: ' . mysql_error());
    }

    if (!mysql_select_db($sqlDBName, $sqlConn)) {

        die('Could not connect: ' . mysql_error());
    }
}

function DisconnectFromDB() {

    // Close MySQL Connection
    mysql_close();
}

?>
