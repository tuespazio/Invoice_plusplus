<?php

/*
 * 
 * This page is almost the same as the createInvoice page so I won't comment most this page.
 * 
 * All this page does is return the invoice whose ID was passed to it and displays the invoice with a print button.
 * 
 */

// Include database connection code.
include('../common/dbConn.php');
// Include debug functions
include('../common/debugFunctions.php');

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

    // If any rows were returned from ipp_business, fill the variables with the data returned. (this is used for the business address block on the invoice)
    
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

$invoiceID = $_POST['rowID'];

$displayString .= "<div id=\"infoInvoice\">";

session_start();

ConnectToDB();

if (isset($_POST['payInvoice'])) {

    $sqlQuery = "UPDATE ipp_invoice SET paid = 1 WHERE id = '$invoiceID'";

    $resultQuery = mysql_query($sqlQuery) or die(mysql_error());
}

$sqlQuery = "SELECT * FROM ipp_invoice WHERE id = '$invoiceID' AND paid = 0";

$resultQuery = mysql_query($sqlQuery) or die(mysql_error());

$numRows = mysql_num_rows($resultQuery);

if ($numRows > 0) {

    $displayString .= "<h2>Invoice Info</h2> <form class=\"payInvoiceForm\" method=\"post\" action=\"#\"><input id='$invoiceID' class=\"payInvoice\" name=\"submit\" type=\"submit\" value=\"Pay Invoice\"></input> <input class=\"printInvoice\" name=\"submit\" type=\"submit\" value=\"Print Invoice\"></input>";
    $displayString .= "</form>";

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
    $displayString .= "<li><img class=\"invoiceLogo\" src=\"assets/images/logoTest.png\" title=\"Logo\" alt=\"Logo\" /></li>";
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
} else {

    $displayString .= "<p>No Info Avaliable.</p>";
}

$displayString .= debugModeActive();

$displayString .= "</div>";

echo $displayString;
?>
