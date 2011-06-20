<?php

// Include database connection code.
include('../common/dbConn.php');
// Include debug functions
include('../common/debugFunctions.php');

// Create empty echo string.
$displayString = NULL;

$displayString .= "<div id=\"createProduct\">";
$displayString .= "<h2>Create Product</h2>";

session_start();

// Check user's security level
if ($_SESSION['securityLevel'] >= 5) {

// Test if a product has been created.
    if (isset($_POST['productName'])) {

        ConnectToDB();

        // Set product variables.
        $productName = mysql_real_escape_string($_POST['productName']);
        $productDesc = mysql_real_escape_string($_POST['productDesc']);
        $productPrice = mysql_real_escape_string($_POST['productPrice']);
        $productQty = mysql_real_escape_string($_POST['productQty']);

        // Create a SQL query.
        $sqlQuery = "INSERT INTO ipp_product (name, price, qty, description) VALUES ('$productName', '$productPrice', '$productQty', '$productDesc')";

        // Process the query
        mysql_query($sqlQuery)
                or die(mysql_error());

        DisconnectFromDB();

        $displayString .= "<p style=\"color: blue;\">Product Successfully Inserted Into Database.</p>";
    }

    $displayString .= "<form class=\"createProductForm\" method=\"post\" action=\"#\">";

    $displayString .= "<label for=\"productName\">Product Name </label>";
    $displayString .= "<input class=\"textfield\" id=\"productName\" name=\"productName\" type=\"text\" size=\"30\"></input>";

    $displayString .= "<label for=\"productDesc\"> Description </label>";
    $displayString .= "<input class=\"textfield\" id=\"productDesc\" name=\"productDesc\" type=\"text\" size=\"50\"></input>";

    $displayString .= "<label for=\"productPrice\"> Price </label>";
    $displayString .= "<input class=\"textfield\" id=\"productPrice\" name=\"productPrice\" type=\"text\" size=\"10\" style=\"text-align: right;\"></input>";

    $displayString .= "<label for=\"productQty\"> Qty </label>";
    $displayString .= "<input class=\"textfield\" id=\"productQty\" name=\"productQty\" type=\"text\" size=\"10\" style=\"text-align: right;\"></input>";

    $displayString .= "<input class=\"productCreateButton\" name=\"submit\" type=\"submit\" value=\"Create\"></input> <input class=\"productResetButton\" name=\"reset\" type=\"reset\" value=\"Reset\"></input>";

    $displayString .= "</form>";
} else {

    $displayString .= "<p>You need higher security clearence to create products. Contact your administrator.</p>";
}

$displayString .= debugModeActive();

$displayString .= "</div>";

// Echo the display string variable back to the page.
echo $displayString;

// Clear the string.
$displayString = NULL;
?>
