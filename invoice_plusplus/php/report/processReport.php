<?php

// Include database connection code.
include('../common/dbConn.php');
// Include debug functions
include('../common/debugFunctions.php');

// Create empty echo string.
$displayString = NULL;

$displayString .= "<head>";
$displayString .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />";
$displayString .= "<link rel=\"stylesheet\" href=\"../../css/client.css\" />";
$displayString .= "<title>Invoice++ System - Print Invoice</title>";
$displayString .= "</head>";

$displayString .= "<body>";

$displayString .= "<div id=\"processReport\">";

// Get the report id that the user selected.
$reportID = $_POST['reportName'];

ConnectToDB();

// produce a report according to what report the user selected.
switch ($reportID) {

    // Test which invoices have been paid and return the list.
    case 1: $sqlQuery = "SELECT * FROM ipp_invoice WHERE paid = 1";
        $resultQuery = mysql_query($sqlQuery) or die(mysql_error());
        $displayString .= "<h2>Paid Invoices</h2>";
        $displayString .= "<table>";
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
        break;

    // Pending invoices report.
    case 2: $sqlQuery = "SELECT * FROM ipp_invoice WHERE paid = 0";
        $resultQuery = mysql_query($sqlQuery) or die(mysql_error());
        $displayString .= "<h2>Pending Invoices</h2>";
        $displayString .= "<table>";
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
        break;

    // Return products out of stock.
    case 3: $sqlQuery = "SELECT * FROM ipp_product WHERE qty <= 0 ORDER BY name";

        $resultQuery = mysql_query($sqlQuery) or die(mysql_error());
        $displayString .= "<h2>Products Out of Stock</h2>";
        $displayString .= "<table>";
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
}

$displayString .= "</div>";

$displayString .= "</body>";

echo $displayString;

DisconnectFromDB();
?>
