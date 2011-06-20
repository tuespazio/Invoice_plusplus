<?php

// Include database connection code.
include('../common/dbConn.php');
// Include debug functions
include('../common/debugFunctions.php');

// Create empty echo string.
$displayString = NULL;

$displayString .= "<div id=\"createInvoice\">";
$displayString .= "<h2>Create Invoice</h2>";

ConnectToDB();

// Declare and define page variables.

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

// If any rows were returned from ipp_business, fill the variables with the data returned. (this is used for the business address block on the invoice)
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

session_start();

// Was a product row clicked?
if (isset($_POST['deleteProductRow'])) {

    /*
     *
     * Basic rundown of this block of code.
     * Retrieves a string from the POST data.
     * It breaks it up into variables.
     * It deletes the row from the database table.
     * It gets a total price from a different table.
     * It subtracts the amount that was deleted.
     * It updates the total amount.
     * 
     */

    ConnectToDB();

    $idString = $_POST['idString'];

    // A single string is returned from the Ajax and each variable is seperated by a :
    // Explode puts them into an array.
    $idArray = explode(':', $idString);

    $sqlQuery = "DELETE FROM ipp_product_has_ipp_invoice WHERE ipp_invoice_id = '$idArray[0]' AND ipp_product_id = '$idArray[1]'";

    mysql_query($sqlQuery) or die(mysql_error());

    // Get the total due from the invoice with the id retrieved from the POST data.
    $sqlQuery = "SELECT totalDue FROM ipp_invoice WHERE id = '$idArray[0]'";

    $resultQuery = mysql_query($sqlQuery) or die(mysql_error());

    $row = mysql_fetch_array($resultQuery);

    $totalDue = $row['totalDue'];

    // Subtract the amount from the total due.
    $totalDueFinal = $totalDue - $idArray[2];

    // Update the amount in the database with the new value.
    $sqlQuery = "UPDATE ipp_invoice SET totalDue = '$totalDueFinal' WHERE id = '$idArray[0]'";

    $resultQuery = mysql_query($sqlQuery) or die(mysql_error());

    DisconnectFromDB();
}

// Test if a product is being posted to the invoice.
if (isset($_POST['submitProduct'])) {

    ConnectToDB();

    // Get POST data.
    $invoiceID = $_POST['invoiceID'];
    $productID = $_POST['productID'];
    $productQty = mysql_real_escape_string($_POST['productQty']);

    // Insert the product id, qty and invoice id into the table
    $sqlQuery = "INSERT INTO ipp_product_has_ipp_invoice (ipp_product_id, ipp_invoice_id, qty) VALUES ('$productID', '$invoiceID', '$productQty')";

    mysql_query($sqlQuery) or die(mysql_error());

    // Get the price of the product
    $sqlQuery = "SELECT price FROM ipp_product WHERE id = '$productID'";

    $resultQuery = mysql_query($sqlQuery) or die(mysql_error());

    $row = mysql_fetch_array($resultQuery);

    $productPrice = $row['price'];

    // Create a total price variable based on the product price and product qty.
    $totalPrice = $productPrice * $productQty;

    // Get the total due from the invoice in question.
    $sqlQuery = "SELECT totalDue FROM ipp_invoice WHERE id = '$invoiceID'";

    $resultQuery = mysql_query($sqlQuery) or die(mysql_error());

    $row = mysql_fetch_array($resultQuery);

    $totalDue = $row['totalDue'];

    // Add the new amount to the total due...
    $totalDueFinal = $totalDue + $totalPrice;

    // ... and update the total due with the new amount.
    $sqlQuery = "UPDATE ipp_invoice SET totalDue = '$totalDueFinal' WHERE id = '$invoiceID'";

    $resultQuery = mysql_query($sqlQuery) or die(mysql_error());

    DisconnectFromDB();
}

// Test if an invoice was saved.
if (isset($_POST['saveNewInvoice'])) {

    ConnectToDB();

    // Get the current invoice id which was stored in the session.
    $currentInvoiceID = $_SESSION['currentInvoice'];

    // Get all the fields from the row returned from the current invoice ID.
    $sqlQuery = "SELECT * FROM ipp_product_has_ipp_invoice WHERE ipp_invoice_id = '$currentInvoiceID'";

    $resultQuery = mysql_query($sqlQuery) or die(mysql_error());

    while ($row = mysql_fetch_array($resultQuery)) {

        // Get all the products on the invoice.
        $productQty = $row['qty'];
        $productID = $row['ipp_product_id'];

        // Get the fields from the row according to the product ID
        $sqlQuery = "SELECT * FROM ipp_product WHERE id = '$productID'";

        $resultQueryInnerOne = mysql_query($sqlQuery) or die(mysql_error());

        $rowInnerOne = mysql_fetch_array($resultQueryInnerOne);

        // Get the current qty
        $oldProductQty = $rowInnerOne['qty'];

        $productName = $rowInnerOne['name'];

        // Calculate a new qty based on the current qty and qty that's being taken from  the pool.
        $newQty = $oldProductQty - $productQty;

        if ($newQty < 0) {

            // if the qty goes below 0 alert the user. Qty's can go into negative values because orders can still be placed if something is out of stock. (although once they are out of stock, the user cannot place anymore invoices with that item until it is filled again).
            $displayString .= "<script type=\"text/javascript\">alert(\"'$productName' is now out of stock by '$newQty'.\");</script>";
        }

        // Update the qty
        $sqlQuery = "UPDATE ipp_product SET qty = '$newQty' WHERE id = '$productID'";

        mysql_query($sqlQuery) or die(mysql_error());
    }

    DisconnectFromDB();

    // 'Save' the invoice and clear the session so the user can create a new invoice.
    unset($_SESSION['currentInvoice']);
}

// Test if the invoice was deleted.
if (isset($_POST['deleteInvoice'])) {

    // Get the invoice ID being deleted.
    $invoiceID = $_POST['invoiceID'];

    ConnectToDB();

    // Delete the row from the many to many table.
    $sqlQuery = "DELETE FROM ipp_product_has_ipp_invoice WHERE ipp_invoice_id = '$invoiceID'";

    mysql_query($sqlQuery) or die(mysql_error());

    // delete the invoice from the invoice table
    $sqlQuery = "DELETE FROM ipp_invoice WHERE id = '$invoiceID'";

    mysql_query($sqlQuery) or die(mysql_error());

    DisconnectFromDB();

    // Unsets the session variable so the user can create a new invoice.
    unset($_SESSION['currentInvoice']);
}

// Tests if a client was selected and an invoice was created.
if (isset($_POST['invoiceClientID'])) {

    ConnectToDB();

    // Get the client's id.
    $invoiceClientID = $_POST['invoiceClientID'];

    // Select the client's row in the database.
    $sqlQuery = "SELECT * FROM ipp_client WHERE id = '$invoiceClientID'";

    $resultQuery = mysql_query($sqlQuery) or die(mysql_error());

    $row = mysql_fetch_array($resultQuery);

    // if the row was successfully retrieved...
    if ($row) {

        // Invoice the client id and the current date into the invoice table.
        $sqlQuery = "INSERT INTO ipp_invoice (ipp_client_id, createDate) VALUES ('$invoiceClientID', NOW())";

        mysql_query($sqlQuery) or die(mysql_error());

        // Return the ID of the row that was inserted. This sets the currentInvoice session variable so the user can only create one invoice at a time.
        $_SESSION['currentInvoice'] = mysql_insert_id();
    }

    DisconnectFromDB();
}

// Is the currentInvoice session set?
if (isset($_SESSION['currentInvoice'])) {

    // Get the invoice ID.
    $invoiceID = $_SESSION['currentInvoice'];

    // Create some buttons for invoice management.
    $displayString .= "<form class=\"newInvoiceButtonsForm\" method=\"post\" action=\"#\">";
    $displayString .= "<input class=\"saveNewInvoice\" name=\"submit\" type=\"submit\" value=\"Save & New Invoice\"></input> <input id=\"$invoiceID\" class=\"deleteInvoice\" name=\"submit\" type=\"submit\" value=\"Delete Invoice\"></input>";
    $displayString .= "</form>";

    ConnectToDB();

    // Get the fields from the row with the id of the invoice id.
    $sqlQuery = "SELECT * FROM ipp_invoice WHERE id = '$invoiceID'";

    $resultQuery = mysql_query($sqlQuery) or die(mysql_error());

    $invoiceRow = mysql_fetch_array($resultQuery);

    // Fill some variables with the returned data.
    $clientID = $invoiceRow['ipp_client_id'];
    $createDate = $invoiceRow['createDate'];
    $invoiceID = $invoiceRow['id'];

    // Get the client details.
    $sqlQuery = "SELECT * FROM ipp_client WHERE id = '$clientID'";

    $resultQuery = mysql_query($sqlQuery) or die(mysql_error());

    $clientRow = mysql_fetch_array($resultQuery);

    // Fill variables with the client details.
    $clientFirstName = $clientRow['firstName'];
    $clientSurname = $clientRow['surname'];
    $clientAddress = $clientRow['address'];
    $clientSuburb = $clientRow['suburb'];
    $clientState = $clientRow['state'];
    $clientPostcode = $clientRow['postcode'];
    $clientCountry = $clientRow['country'];
    $clientCompany = $clientRow['company'];
    $clientPhoneNumber = $clientRow['phoneNumber'];
    $clientEmail = $clientRow['email'];

    // Create the client address block.
    $displayString .= "<div id=\"invoiceHeaderDiv\">";

    $displayString .= "<ul class=\"invoiceAddressBlock\">";
    $displayString .= "<li>$clientFirstName $clientSurname ($clientCompany)</li>";
    $displayString .= "<li>$clientAddress</li>";
    $displayString .= "<li>$clientSuburb $clientState $clientPostcode</li>";
    $displayString .= "<li>$clientCountry</li>";
    $displayString .= "<li>Phone: $clientPhoneNumber Email: $clientEmail</li>";
    $displayString .= "</ul>";

    // create the business block.
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
    $displayString .= "<form class=\"addToInvoiceForm\" method=\"post\" action=\"#\">";

    $displayString .= "<label for=\"invoiceProductName\">Product Name </label>";
    $displayString .= "<select id=\"invoiceProductName\">";

    // List only the products that are in stock.
    $sqlQuery = "SELECT * FROM ipp_product WHERE qty > 0 ORDER BY name";

    $resultQuery = mysql_query($sqlQuery) or die(mysql_error());

    while ($row = mysql_fetch_array($resultQuery)) {
        
        // Fill a dropdown menu with the products.
        $productID = $row['id'];
        $productName = $row['name'];
        $productDesc = $row['description'];
        $productPrice = $row['price'];

        $displayString .= "<option value=\"$productID\">$productName, $productDesc, $productPrice</option>";
    }

    $displayString .= "</select>";

    // Create a field so the user can place a qty.
    $displayString .= "<label for=\"invoiceProductQty\"> Qty </label>";
    $displayString .= "<input class=\"textfield\" id=\"invoiceProductQty\" name=\"invoiceProductQty\" type=\"text\" size=\"10\"></input>";
    $displayString .= "<input id=\"$invoiceID\" class=\"invoiceProductSubmit\" name=\"submit\" type=\"submit\" value=\"Submit\"></input>";

    $displayString .= "</form>";

    // Get the rows and fields from the many to many table.
    $sqlQuery = "SELECT * FROM ipp_product_has_ipp_invoice WHERE ipp_invoice_id = '$invoiceID'";

    $resultQuery = mysql_query($sqlQuery) or die(mysql_error());

    $displayString .= "<table>";
    $displayString .= "<tr><th>Name</th>";
    $displayString .= "<th>Description</th>";
    $displayString .= "<th>QTY</th>";
    $displayString .= "<th>Unit Price</th>";
    $displayString .= "<th>Total Price</th></tr>";

    while ($invoiceBodyRow = mysql_fetch_array($resultQuery)) {

        // Start filling a table with the products on that invoice.
        $productID = $invoiceBodyRow['ipp_product_id'];
        $invoiceProductQty = $invoiceBodyRow['qty'];

        $sqlQuery = "SELECT * FROM ipp_product WHERE id = '$productID'";

        $resultQueryInvoiceBody = mysql_query($sqlQuery) or die(mysql_error());

        $productRow = mysql_fetch_array($resultQueryInvoiceBody);

        $productName = $productRow['name'];
        $productDesc = $productRow['description'];
        $productPrice = $productRow['price'];

        $idString = null;

        $totalPrice = $productPrice * $invoiceProductQty;

        // Store three variables (seperated by :) in one string and...
        $idString .= $invoiceID . ":" . $productID . ":" . $totalPrice;

        // Place the variable in the row id. This is used to send three variables at once to Ajax and back to this page (see above).
        $displayString .= "<tr id=\"$idString\"><td>$productName</td>";
        $displayString .= "<td>$productDesc</td>";
        $displayString .= "<td style=\"text-align: right;\">$invoiceProductQty</td>";
        $displayString .= "<td style=\"text-align: right;\">$productPrice</td>";

        $displayString .= "<td style=\"text-align: right;\">$totalPrice</td></tr>";
    }

    $displayString .= "</table>";

    // Get the total due from the invoice table.
    $sqlQuery = "SELECT totalDue FROM ipp_invoice WHERE id = '$invoiceID'";

    $resultQuery = mysql_query($sqlQuery) or die(mysql_error());

    $row = mysql_fetch_array($resultQuery);

    $totalDue = $row['totalDue'];

    // Print the total due.
    $displayString .= "<ul class=\"invoiceTotalsBlock\">";
    $displayString .= "<li><strong>TOTAL DUE</strong> $totalDue</li>";
    $displayString .= "</ul>";

    $displayString .= "<div id=\"clearDiv\"></div>";

    $displayString .= "</div>";

    DisconnectFromDB();
    
    // Test the user's security level.
} else if ($_SESSION['securityLevel'] >= 3) {

    // Start creating the select user form.
    $displayString .= "<form class=\"createInvoiceForm\" method=\"post\" action=\"#\">";

    $displayString .= "<label for=\"invoiceClientName\">Client Name </label>";
    $displayString .= "<select id=\"invoiceClientName\">";

    ConnectToDB();

    $sqlQuery = "SELECT id, firstName, surname, company FROM ipp_client ORDER BY surname";

    $resultQuery = mysql_query($sqlQuery) or die(mysql_error());

    while ($row = mysql_fetch_array($resultQuery)) {

        // Fill a dropdown menu with the clients.
        $clientID = $row['id'];
        $clientFirstName = $row['firstName'];
        $clientSurname = $row['surname'];
        $clientCompany = $row['company'];

        $displayString .= "<option value=\"$clientID\">$clientSurname, $clientFirstName, $clientCompany</option>";
    }

    DisconnectFromDB();

    $displayString .= "</select>";

    $displayString .= "<input class=\"invoiceCreateButton\" name=\"submit\" type=\"submit\" value=\"Create\"></input>";

    $displayString .= "</form>";
} else {

    $displayString .= "<p>You need higher security clearence to create invoices. Contact your administrator.</p>";
}

$displayString .= debugModeActive();

$displayString .= "</div>";

echo $displayString;
?>
