<?php

/*
 * This page is just a display only page that gets the invoice ID passed to it and get's the information from the database and fills out the table so the user can print the form.
 * 
 */

include('../common/xhtmlStrict.php');

// Include database connection code.
include('../common/dbConn.php');

// Create empty echo string.
$displayString = NULL;

ConnectToDB();

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

$displayString .= "<head>";
$displayString .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />";
$displayString .= "<link rel=\"stylesheet\" href=\"../../css/client.css\" />";
$displayString .= "<title>Invoice++ System - Print Invoice</title>";
$displayString .= "</head>";

$displayString .= "<body>";

$displayString .= "<div id=\"mostRecentInvoice\">";

session_start();

ConnectToDB();

$sqlQuery = "SELECT MAX(id) AS id FROM ipp_invoice";

$resultQuery = mysql_query($sqlQuery) or die(mysql_error());

$row = mysql_fetch_array($resultQuery);

$invoiceID = $row['id'];

$sqlQuery = "SELECT * FROM ipp_invoice WHERE id = '$invoiceID'";

$resultQuery = mysql_query($sqlQuery) or die(mysql_error());

$row = mysql_fetch_array($resultQuery);

$clientID = $row['ipp_client_id'];
$createDate = $row['createDate'];
$invoiceID = $row['id'];

$sqlQuery = "SELECT * FROM ipp_client WHERE id = '$clientID'";

$resultQuery = mysql_query($sqlQuery) or die(mysql_error());

$row = mysql_fetch_array($resultQuery);

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

$displayString .= "<div id=\"invoiceHeaderDiv\">";

$displayString .= "<ul class=\"invoiceAddressBlock\">";
$displayString .= "<li>$clientFirstName $clientSurname ($clientCompany)</li>";
$displayString .= "<li>$clientAddress</li>";
$displayString .= "<li>$clientSuburb $clientState $clientPostcode</li>";
$displayString .= "<li>$clientCountry</li>";
$displayString .= "<li>Phone: $clientPhoneNumber Email: $clientEmail</li>";
$displayString .= "</ul>";

$displayString .= "<ul class=\"invoiceLogoDateBlock\">";
$displayString .= "<li><img class=\"invoiceLogo\" src=\"../../assets/images/logoTest.png\" title=\"Logo\" alt=\"Logo\" /></li>";
$displayString .= "<li>$businessName</li>";
$displayString .= "<li>$businessAddress</li>";
$displayString .= "<li>$businessSuburb $businessState $businessPostcode</li>";
$displayString .= "<li>$businessCountry</li>";
$displayString .= "<li>$businessEmail | $businessPhone</li>";
$displayString .= "<li><br /></li>";
$displayString .= "<li>Invoice Number: $invoiceID</li>";
$displayString .= "<li>Creation Date: $createDate</li>";
$displayString .= "<li>Due Date: </li>";
$displayString .= "</ul>";

$displayString .= "</div>";

$displayString .= "<div id=\"invoiceBody\">";

$sqlQuery = "SELECT * FROM ipp_product_has_ipp_invoice WHERE ipp_invoice_id = '$invoiceID'";

$resultQuery = mysql_query($sqlQuery) or die(mysql_error());

$displayString .= "<table>";
$displayString .= "<tr><th>Name</th>";
$displayString .= "<th>Description</th>";
$displayString .= "<th>QTY</th>";
$displayString .= "<th>Unit Price</th>";
$displayString .= "<th>Total Price</th></tr>";

while ($invoiceBodyRow = mysql_fetch_array($resultQuery)) {

    $productID = $invoiceBodyRow['ipp_product_id'];
    $invoiceProductQty = $invoiceBodyRow['qty'];

    $sqlQuery = "SELECT * FROM ipp_product WHERE id = '$productID'";

    $resultQueryInvoiceBody = mysql_query($sqlQuery) or die(mysql_error());

    $productRow = mysql_fetch_array($resultQueryInvoiceBody);

    $productName = $productRow['name'];
    $productDesc = $productRow['description'];
    $productPrice = $productRow['price'];

    $displayString .= "<tr><td>$productName</td>";
    $displayString .= "<td>$productDesc</td>";
    $displayString .= "<td style=\"text-align: right;\">$invoiceProductQty</td>";
    $displayString .= "<td style=\"text-align: right;\">$productPrice</td>";

    $totalPrice = $productPrice * $invoiceProductQty;

    $displayString .= "<td style=\"text-align: right;\">$totalPrice</td></tr>";
}

$displayString .= "</table>";

$sqlQuery = "SELECT totalDue FROM ipp_invoice WHERE id = '$invoiceID'";

$resultQuery = mysql_query($sqlQuery) or die(mysql_error());

$row = mysql_fetch_array($resultQuery);

$totalDue = $row['totalDue'];

$displayString .= "<ul class=\"invoiceTotalsBlock\">";
$displayString .= "<li><strong>TOTAL DUE</strong> $totalDue</li>";
$displayString .= "</ul>";

$displayString .= "<div id=\"clearDiv\"></div>";

DisconnectFromDB();

$displayString .= "</div>";

$displayString .= "</div>";

$displayString .= "</body>";

echo $displayString;

include('../clientSite/clientFooter.php');
?>
