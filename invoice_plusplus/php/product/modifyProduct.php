<?php

// Include database connection code.
include('../common/dbConn.php');
// Include debug functions
include('../common/debugFunctions.php');

// Create empty echo string.
$displayString = NULL;

$displayString .= "<div id=\"modifyProduct\">";
$displayString .= "<h2>Modify Product</h2>";

session_start();

if ($_SESSION['securityLevel'] >= 5) {

// Check if the modify button was clicked.
    if (isset($_POST['modifyProductName'])) {

        // Set modify product variables.
        $modifyProductName = mysql_real_escape_string($_POST['modifyProductName']);
        $modifyProductDesc = mysql_real_escape_string($_POST['modifyProductDesc']);
        $modifyProductPrice = mysql_real_escape_string($_POST['modifyProductPrice']);
        $modifyProductQty = mysql_real_escape_string($_POST['modifyProductQty']);
        $modifyProductID = mysql_real_escape_string($_POST['modifyProductID']);

        ConnectToDB();

        // Update the details of the product.
        $sqlQuery = "UPDATE ipp_product SET name = '$modifyProductName', description = '$modifyProductDesc', price = '$modifyProductPrice', qty = '$modifyProductQty' WHERE id = '$modifyProductID'";

        mysql_query($sqlQuery) or die(mysql_error());

        DisconnectFromDB();

        $displayString .= "<p style=\"color: blue;\">Product Successfully Modified in Database.</p>";
    }

// Was a product clicked?
    if (isset($_POST['rowID'])) {

        $rowID = $_POST['rowID'];

        ConnectToDB();

        // Get the details of the product according to the row ID (which is the product ID).
        $sqlQuery = "SELECT * FROM ipp_product WHERE id = '$rowID'";

        $resultQuery = mysql_query($sqlQuery) or die(mysql_error());

        $row = mysql_fetch_array($resultQuery);

        $productName = $row['name'];
        $productDesc = $row['description'];
        $productPrice = $row['price'];
        $productQty = $row['qty'];
        $productID = $row['id'];

        DisconnectFromDB();

        // display a form with the details of the product to modify.
        $displayString .= "<form class=\"modifyProductForm\" method=\"post\" action=\"#\">";

        $displayString .= "<label for=\"modifyProductName\">Product Name </label>";
        $displayString .= "<input class=\"textfield\" id=\"modifyProductName\" name=\"modifyProductName\" type=\"text\" size=\"30\" value=\"$productName\"></input>";

        $displayString .= "<label for=\"modifyProductDesc\"> Description </label>";
        $displayString .= "<input class=\"textfield\" id=\"modifyProductDesc\" name=\"modifyProductDesc\" type=\"text\" size=\"50\" value=\"$productDesc\"></input>";

        $displayString .= "<label for=\"modifyProductPrice\"> Price </label>";
        $displayString .= "<input class=\"textfield\" id=\"modifyProductPrice\" name=\"modifyProductPrice\" type=\"text\" size=\"10\" style=\"text-align: right;\" value=\"$productPrice\"></input>";

        $displayString .= "<label for=\"modifyProductQty\"> Qty </label>";
        $displayString .= "<input class=\"textfield\" id=\"modifyProductQty\" name=\"modifyProductQty\" type=\"text\" size=\"10\" style=\"text-align: right;\" value=\"$productQty\"></input>";

        $displayString .= "<input id=\"$productID\" class=\"productModifyButton\" name=\"submit\" type=\"submit\" value=\"Modify\"></input> <input class=\"productModifyResetButton\" name=\"reset\" type=\"reset\" value=\"Reset\"></input>";

        $displayString .= "</form><br />";
    }


    ConnectToDB();

    // Get all products.
    $sqlQuery = "SELECT * FROM ipp_product ORDER BY name";

    $resultQuery = mysql_query($sqlQuery) or die(mysql_error());

    // Create a table and fill the table with the details of each product.
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

    DisconnectFromDB();
} else {

    $displayString .= "<p>You need higher security clearence to modify products. Contact your administrator.</p>";
}

$displayString .= debugModeActive();

$displayString .= "</div>";

// Echo the display string back to the page.
echo $displayString;
?>
