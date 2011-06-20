<?php

/*
 * Note that the client can click on the rows and it will either go to modify client, product or invoice Info pages.
 */

// Include database connection code.
include('../common/dbConn.php');
// Include debug functions
include('../common/debugFunctions.php');

// Create empty echo string.
$displayString = NULL;

$displayString .= "<div id=\"searchPage\">";
$displayString .= "<h2>Search Results</h2>";

session_start();

// Test if the search has been performed.
if (isset($_POST['search'])) {

    ConnectToDB();

    $searchTerm = mysql_real_escape_string($_POST['searchTerm']);

    // Search each field of the client table.
    $sqlQuery = "SELECT * FROM ipp_client WHERE firstName LIKE '%$searchTerm%' OR surname LIKE '%$searchTerm%' OR address LIKE '%$searchTerm%' OR suburb LIKE '%$searchTerm%' OR state LIKE '%$searchTerm%' OR postcode LIKE '%$searchTerm%' OR country LIKE '%$searchTerm%' OR email LIKE '%$searchTerm%' OR company LIKE '%$searchTerm%' OR phoneNumber LIKE '%$searchTerm%'";

    $resultQuery = mysql_query($sqlQuery) or die(mysql_error());

    $numRows = mysql_num_rows($resultQuery);

    $displayString .= "<p><strong>Client Results</strong></p>";

    // If any rows were returned, create a table listing with clients were found.
    if ($numRows > 0) {

        $displayString .= "<table id=\"clientSearchTable\">";
        $displayString .= "<tr><th>First Name</th>";
        $displayString .= "<th>Surname</th>";
        $displayString .= "<th>Address</th>";
        $displayString .= "<th>Suburb</th>";
        $displayString .= "<th>State</th>";
        $displayString .= "<th>Postcode</th>";
        $displayString .= "<th>Country</th>";
        $displayString .= "<th>Company</th>";
        $displayString .= "<th>Phone Number</th>";
        $displayString .= "<th>Email</th></tr>";

        while ($row = mysql_fetch_array($resultQuery)) {

            $clientID = $row['id'];
            $clientFirstName = $row['firstName'];
            $clientSurname = $row['surname'];
            $clientAddress = $row['address'];
            $clientSuburb = $row['suburb'];
            $clientState = $row['state'];
            $clientPostcode = $row['postcode'];
            $clientCountry = $row['country'];
            $clientCompany = $row['company'];
            $clientPhoneNumber = $row['phoneNumber'];
            $clientEmail = $row['email'];

            $displayString .= "<tr id='$clientID'>";
            $displayString .= "<td>$clientFirstName</td>";
            $displayString .= "<td>$clientSurname</td>";
            $displayString .= "<td>$clientAddress</td>";
            $displayString .= "<td>$clientSuburb</td>";
            $displayString .= "<td>$clientState</td>";
            $displayString .= "<td>$clientPostcode</td>";
            $displayString .= "<td>$clientCountry</td>";
            $displayString .= "<td>$clientCompany</td>";
            $displayString .= "<td>$clientPhoneNumber</td>";
            $displayString .= "<td>$clientEmail</td>";
            $displayString .= "</tr>";
        }
    } else {

        $displayString .= "<p>No client results were found.</p>";
    }

    $displayString .= "</table>";
}

$displayString .= "<p><strong>Product Results</strong></p>";

// Search products.

$sqlQuery = "SELECT * FROM ipp_product WHERE name LIKE '%$searchTerm%' OR price LIKE '%$searchTerm%' OR qty LIKE '%$searchTerm%' OR description LIKE '%$searchTerm%'";

$resultQuery = mysql_query($sqlQuery) or die(mysql_error());

$numRows = mysql_num_rows($resultQuery);

// Fill a table with any returned rows.
if ($numRows > 0) {

    $displayString .= "<table id=\"productSearchTable\">";
    $displayString .= "<tr><th>Name</th>";
    $displayString .= "<th>Description</th>";
    $displayString .= "<th>Price</th>";
    $displayString .= "<th>QTY</th></tr>";

    while ($row = mysql_fetch_array($resultQuery)) {

        $productName = $row['name'];
        $productDesc = $row['description'];
        $productPrice = $row['price'];
        $productQty = $row['qty'];
        $productID = $row['id'];

        $displayString .= "<tr id='$productID'>";
        $displayString .= "<td>$productName</td>";
        $displayString .= "<td>$productDesc</td>";
        $displayString .= "<td style=\"text-align: right;\">$productPrice</td>";
        $displayString .= "<td style=\"text-align: right;\">$productQty</td>";
        $displayString .= "</tr>";
    }

    $displayString .= "</table>";
} else {

    $displayString .= "<p>No product results were found.</p>";
}

// Search invoices.
$displayString .= "<p><strong>Invoice Results</strong></p>";

$sqlQuery = "SELECT * FROM ipp_invoice WHERE id LIKE '%$searchTerm%' OR createDate LIKE '%$searchTerm%' OR dueDate LIKE '%$searchTerm%' OR totalDue LIKE '%$searchTerm%'";

$resultQuery = mysql_query($sqlQuery) or die(mysql_error());

$numRows = mysql_num_rows($resultQuery);

// Fill a table with any returned rows.
if ($numRows > 0) {

    $displayString .= "<table id=\"invoiceSearchTable\">";
    $displayString .= "<tr><th>Invoice Number</th>";
    $displayString .= "<th>Name</th>";
    $displayString .= "<th>Create Date</th>";
    $displayString .= "<th>Due Date</th>";
    $displayString .= "<th>Total Due</th></tr>";

    while ($row = mysql_fetch_array($resultQuery)) {

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

    $displayString .= "<p>No invoice results were found.</p>";
}

$displayString .= debugModeActive();

$displayString .= "</div>";

echo $displayString;
?>
