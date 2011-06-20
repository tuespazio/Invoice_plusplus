<?php

// Include database connection code.
include('../common/dbConn.php');
// Include debug functions
include('../common/debugFunctions.php');

// Create empty echo string.
$displayString = NULL;

ConnectToDB();

session_start();

if ($_SESSION['securityLevel'] >= 4) {

    $businessID = null;
    $businessName = null;
    $businessAddress = null;
    $businessSuburb = null;
    $businessState = null;
    $businessPostcode = null;
    $businessCountry = null;
    $businessPhone = null;
    $businessEmail = null;

    $sqlQuery = "SELECT * FROM ipp_business";

    $resultQuery = mysql_query($sqlQuery) or die(mysql_error());

    $numRows = mysql_num_rows($resultQuery);

    if ($numRows > 0) {

        $row = mysql_fetch_array($resultQuery);

        $businessID = $row['id'];
        $businessName = $row['businessName'];
        $businessAddress = $row['address'];
        $businessSuburb = $row['suburb'];
        $businessState = $row['state'];
        $businessPostcode = $row['postcode'];
        $businessCountry = $row['country'];
        $businessPhone = $row['phoneNumber'];
        $businessEmail = $row['email'];
    }

    DisconnectFromDB();

    $displayString .= "<div id=\"pendingInvoice\">";
    $displayString .= "<h2>Pending Invoice</h2>";

    ConnectToDB();

    // Check which invoices haven't been paid.
    $sqlQuery = "SELECT * FROM ipp_invoice WHERE paid = 0";

    $resultQuery = mysql_query($sqlQuery) or die(mysql_error());

    $displayString .= "<table>";
    $displayString .= "<tr><th>Invoice Number</th>";
    $displayString .= "<th>Name</th>";
    $displayString .= "<th>Create Date</th>";
    $displayString .= "<th>Due Date</th>";
    $displayString .= "<th>Total Due</th></tr>";

    while ($row = mysql_fetch_array($resultQuery)) {

        // Create a table and fill it with the unpaid invoice information.

        $invoiceID = $row['id'];
        $invoiceCreateDate = $row['createDate'];
        $invoiceDueDate = $row['dueDate'];
        $invoiceTotalDue = $row['totalDue'];
        $invoiceClientID = $row['ipp_client_id'];

        $sqlQuery = "SELECT firstName, surname FROM ipp_client WHERE id = '$invoiceClientID'";

        $innerResultsQuery = mysql_query($sqlQuery) or die(mysql_error());

        $innerRow = mysql_fetch_array($innerResultsQuery);

        $clientFirstName = $innerRow['firstName'];
        $clientSurname = $innerRow['surname'];

        $clientFullName = $clientFirstName . " " . $clientSurname;

        $displayString .= "<tr id='$invoiceID'>";
        $displayString .= "<td>$invoiceID</td>";
        $displayString .= "<td>$clientFullName</td>";
        $displayString .= "<td>$invoiceCreateDate</td>";
        $displayString .= "<td>$invoiceDueDate</td>";
        $displayString .= "<td>$invoiceTotalDue</td></tr>";
    }

    $displayString .= "</table>";
} else {

    $displayString .= "<p>You need higher security clearence to see pending invoices. Contact your administrator.</p>";
}

DisconnectFromDB();

$displayString .= debugModeActive();

$displayString .= "</div>";

// Echo the display string back to the page.
echo $displayString;
?>
