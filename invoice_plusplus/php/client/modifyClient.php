<?php

// Include database connection code.
include('../common/dbConn.php');
// Include debug functions
include('../common/debugFunctions.php');

// Create empty echo string.
$displayString = NULL;

$displayString .= "<div id=\"modifyClient\">";
$displayString .= "<h2>Modify Client</h2>";

session_start();

// Check the user's security level.
if ($_SESSION['securityLevel'] >= 5) {

// Check if a client was modified.
    if (isset($_POST['modifyClientFirstName'])) {

        // Get the client modified details from the POST data.
        $modifyClientID = mysql_real_escape_string($_POST['modifyClientID']);
        $modifyClientFirstName = mysql_real_escape_string($_POST['modifyClientFirstName']);
        $modifyClientSurname = mysql_real_escape_string($_POST['modifyClientSurname']);
        $modifyClientAddress = mysql_real_escape_string($_POST['modifyClientAddress']);
        $modifyClientSuburb = mysql_real_escape_string($_POST['modifyClientSuburb']);
        $modifyClientState = mysql_real_escape_string($_POST['modifyClientState']);
        $modifyClientPostcode = mysql_real_escape_string($_POST['modifyClientPostcode']);
        $modifyClientCountry = mysql_real_escape_string($_POST['modifyClientCountry']);
        $modifyClientCompany = mysql_real_escape_string($_POST['modifyClientCompany']);
        $modifyClientPhoneNum = mysql_real_escape_string($_POST['modifyClientPhoneNum']);
        $modifyClientEmail = mysql_real_escape_string($_POST['modifyClientEmail']);

        ConnectToDB();

        // Update the row.
        $sqlQuery = "UPDATE ipp_client SET firstName = '$modifyClientFirstName', surname = '$modifyClientSurname', address = '$modifyClientAddress', suburb = '$modifyClientSuburb', state = '$modifyClientState', postcode = '$modifyClientPostcode', country = '$modifyClientCountry', company = '$modifyClientCompany', phoneNumber = '$modifyClientPhoneNum', email = '$modifyClientEmail' WHERE id = '$modifyClientID'";

        mysql_query($sqlQuery) or die(mysql_error());

        DisconnectFromDB();

        $displayString .= "<p style=\"color: blue;\">Client Successfully Modified in Database.</p>";
    }

// Check if a row was clicked.
    if (isset($_POST['rowID'])) {

        $rowID = $_POST['rowID'];

        ConnectToDB();

        $sqlQuery = "SELECT * FROM ipp_client WHERE id = '$rowID'";

        $resultQuery = mysql_query($sqlQuery) or die(mysql_error());

        $row = mysql_fetch_array($resultQuery);

        // Fill the variables from the data retrieved from the database.
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

        DisconnectFromDB();

        // Fill the table with the data.
        $displayString .= "<div id=\"clientModifyFormDiv\">";

        $displayString .= "<form class=\"modifyClientForm\" method=\"post\" action=\"#\">";

        $displayString .= "<ul class=\"createClientFormLeft\">";
        $displayString .= "<li><label for=\"modifyClientFirstName\">First Name </label><input type=\"text\" size=\"20\" id=\"modifyClientFirstName\" name=\"modifyClientFirstName\" value=\"$clientFirstName\"></input></li>";
        $displayString .= "<li><label for=\"modifyClientSurname\">Surname </label><input type=\"text\" size=\"20\" id=\"modifyClientSurname\" name=\"modifyClientSurname\" value=\"$clientSurname\"></input></li>";
        $displayString .= "<li><label for=\"modifyClientAddress\">Address </label><input type=\"text\" size=\"20\" id=\"modifyClientAddress\" name=\"modifyClientAddress\" value=\"$clientAddress\"></input></li>";
        $displayString .= "<li><label for=\"modifyClientSuburb\">Suburb </label><input type=\"text\" size=\"20\" id=\"modifyClientSuburb\" name=\"modifyClientSuburb\" value=\"$clientSuburb\"></input></li>";
        $displayString .= "<li><label for=\"modifyClientState\">State </label><input type=\"text\" size=\"10\" id=\"modifyClientState\" name=\"modifyClientState\" value=\"$clientState\"></input></li>";
        $displayString .= "<li><label for=\"modifyClientPostcode\">Postcode </label><input type=\"text\" size=\"10\" id=\"modifyClientPostcode\" name=\"modifyClientPostcode\" value=\"$clientPostcode\"></input></li>";
        $displayString .= "<li><label for=\"modifyClientCountry\">Country </label><input type=\"text\" size=\"20\" id=\"modifyClientCountry\" name=\"modifyClientCountry\" value=\"$clientCountry\"></input></li>";
        $displayString .= "</ul>";

        $displayString .= "<ul class=\"createClientFormRight\">";
        $displayString .= "<li><label for=\"modifyClientCompany\">Company </label><input type=\"text\" size=\"20\" id=\"modifyClientCompany\" name=\"modifyClientCompany\" value=\"$clientCompany\"></input></li>";
        $displayString .= "<li><label for=\"modifyClientPhoneNum\">Phone Number </label><input type=\"text\" size=\"20\" id=\"modifyClientPhoneNum\" name=\"modifyClientPhoneNum\" value=\"$clientPhoneNumber\"></input></li>";
        $displayString .= "<li><label for=\"modifyClientEmail\">Email </label><input type=\"text\" size=\"20\" id=\"modifyClientEmail\" name=\"modifyClientEmail\" value=\"$clientEmail\"></input></li>";
        // Give the modify button the client id (for ajax to retrieve.)
        $displayString .= "<li><input id=\"$clientID\" class=\"clientModifyButton\" name=\"submit\" type=\"submit\" value=\"Modify\"></input> <input class=\"clientResetButton\" name=\"reset\" type=\"reset\" value=\"Reset\"></input></li>";
        $displayString .= "</ul>";

        $displayString .= "</form>";

        $displayString .= "</div>";

        $displayString .= "<div id=\"clearDiv\"></div>";
    }


    // Create a table and fill it with the data retrieved from the database (if any).
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
    $displayString .= "<th>Email</th></tr>";

    while ($row = mysql_fetch_array($resultQuery)) {

        // Fill the table.

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

        // Give the table row the client id (for ajax to retrieve)
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

    $displayString .= "<p>You need higher security clearence to modify clients. Contact your administrator.</p>";
}

$displayString .= debugModeActive();

$displayString .= "</div>";

echo $displayString;
?>
