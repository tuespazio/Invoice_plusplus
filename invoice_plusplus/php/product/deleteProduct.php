<?php

// Include database connection code.
include('../common/dbConn.php');
// Include debug functions
include('../common/debugFunctions.php');

// Create empty echo string.
$displayString = NULL;

$displayString .= "<div id=\"deleteProduct\">";
$displayString .= "<h2>Delete Product</h2>";

session_start();

if ($_SESSION['securityLevel'] >= 5) {

// Check if a row was clicked.
    if (isset($_POST['rowID'])) {

        $rowID = $_POST['rowID'];

        ConnectToDB();

        // Delete the product with the row ID (which is the product ID)
        $sqlQuery = "DELETE FROM ipp_product WHERE id = '$rowID'";

        $resultQuery = mysql_query($sqlQuery) or die(mysql_error());

        DisconnectFromDB();

        $displayString .= "<p style=\"color: blue;\">Product Successfully Deleted in Database.</p>";
    }


    ConnectToDB();

    // Get all the products from the product table, order by name.
    $sqlQuery = "SELECT * FROM ipp_product ORDER BY name";

    $resultQuery = mysql_query($sqlQuery) or die(mysql_error());

    $displayString .= "<table>";
    $displayString .= "<tr><th>Name</th>";
    $displayString .= "<th>Description</th>";
    $displayString .= "<th>Price</th>";
    $displayString .= "<th>QTY</th></tr>";

    while ($row = mysql_fetch_array($resultQuery)) {

        // Fill the table with the product information.
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

$displayString .= debugModeActive();

$displayString .= "</div>";

echo $displayString;
?>
