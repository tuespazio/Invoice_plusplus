<?php

// Include database connection code.
include('../common/dbConn.php');
// Include debug functions
include('../common/debugFunctions.php');

// Create empty echo string.
$displayString = NULL;

$displayString .= "<div id=\"deleteClient\">";
$displayString .= "<h2>Delete Client</h2>";

session_start();

// Check the user's security level.
if ($_SESSION['securityLevel'] >= 5) {

// Test if a user has been deleted.
    if (isset($_POST['rowID'])) {

        // Get the row id of the row that the user clicked on, this was posted to the form. The id was retrieved from the table Row.
        $rowID = $_POST['rowID'];

        ConnectToDB();

        // Delete the row from the database where the row id is equal to the posted id.
        $sqlQuery = "DELETE FROM ipp_client WHERE id = '$rowID'";

        $resultQuery = mysql_query($sqlQuery) or die(mysql_error());

        DisconnectFromDB();

        $displayString .= "<p style=\"color: blue;\">Client Successfully Deleted in Database.</p>";
    }

    // Create a table and fill it with data retrieved from the database.

    ConnectToDB();

    $sqlQuery = "SELECT * FROM ipp_client ORDER BY surname";

    $resultQuery = mysql_query($sqlQuery) or die(mysql_error());

    $displayString .= "<table>";
    $displayString .= "<tr><th>First Name</th>";
    $displayString .= "<th>Surname</th>";
    $displayString .= "<th>Address</th>";
    $displayString .= "<th>Suburb</th>";
    $displayString .= "<th>State</th>";
    $displayString .= "<th>Postcode</th>";
    $displayString .= "<th>Country</th>";
    $displayString .= "<th>Company</th>";
    $displayString .= "<th>Phone Number</th>";
    $displayString .= "<th>Email</th>";

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

        // Attach the clientID to the row id (for Ajax to retrieve).
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

    DisconnectFromDB();

    $displayString .= "</table>";
} else {

    $displayString .= "<p>You need higher security clearence to delete clients. Contact your administrator.</p>";
}

$displayString .= debugModeActive();

$displayString .= "</div>";

echo $displayString;
?>
