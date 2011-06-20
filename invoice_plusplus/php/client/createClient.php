<?php

// Include database connection code.
include('../common/dbConn.php');
// Include debug functions
include('../common/debugFunctions.php');

// Create empty echo string.
$displayString = NULL;

$displayString .= "<div id=\"createClient\">";
$displayString .= "<h2>Create Client</h2>";

session_start();

// Check user's security level
if ($_SESSION['securityLevel'] >= 5) {

// Test if a client has been created.
    if (isset($_POST['clientFirstName'])) {

        ConnectToDB();

        // Set client variables.
        $clientFirstName = mysql_real_escape_string($_POST['clientFirstName']);
        $clientSurname = mysql_real_escape_string($_POST['clientSurname']);
        $clientAddress = mysql_real_escape_string($_POST['clientAddress']);
        $clientSuburb = mysql_real_escape_string($_POST['clientSuburb']);
        $clientState = mysql_real_escape_string($_POST['clientState']);
        $clientPostcode = mysql_real_escape_string($_POST['clientPostcode']);
        $clientCountry = mysql_real_escape_string($_POST['clientCountry']);
        $clientCompany = mysql_real_escape_string($_POST['clientCompany']);
        $clientPhoneNum = mysql_real_escape_string($_POST['clientPhoneNum']);
        $clientEmail = mysql_real_escape_string($_POST['clientEmail']);

        // Create a SQL query.
        $sqlQuery = "INSERT INTO ipp_client (firstName, surname, address, suburb, state, postcode, country, company, phoneNumber, email) VALUES ('$clientFirstName', '$clientSurname', '$clientAddress', '$clientSuburb', '$clientState', '$clientPostcode', '$clientCountry', '$clientCompany', '$clientPhoneNum', '$clientEmail')";

        // Process the query
        mysql_query($sqlQuery)
                or die(mysql_error());

        DisconnectFromDB();

        $displayString .= "<p style=\"color: blue;\">Client Successfully Inserted Into Database.</p>";
    }

    // Create the form.

    $displayString .= "<div id=\"clientCreateFormDiv\">";

    $displayString .= "<form class=\"createClientForm\" method=\"post\" action=\"#\">";

    $displayString .= "<ul class=\"createClientFormLeft\">";
    $displayString .= "<li><label for=\"clientFirstName\">First Name </label><input type=\"text\" size=\"20\" id=\"clientFirstName\" name=\"clientFirstName\"></input></li>";
    $displayString .= "<li><label for=\"clientSurname\">Surname </label><input type=\"text\" size=\"20\" id=\"clientSurname\" name=\"clientSurname\"></input></li>";
    $displayString .= "<li><label for=\"clientAddress\">Address </label><input type=\"text\" size=\"20\" id=\"clientAddress\" name=\"clientAddress\"></input></li>";
    $displayString .= "<li><label for=\"clientSuburb\">Suburb </label><input type=\"text\" size=\"20\" id=\"clientSuburb\" name=\"clientSuburb\"></input></li>";
    $displayString .= "<li><label for=\"clientState\">State </label><input type=\"text\" size=\"10\" id=\"clientState\" name=\"clientState\"></input></li>";
    $displayString .= "<li><label for=\"clientPostcode\">Postcode </label><input type=\"text\" size=\"10\" id=\"clientPostcode\" name=\"clientPostcode\"></input></li>";
    $displayString .= "<li><label for=\"clientCountry\">Country </label><input type=\"text\" size=\"20\" id=\"clientCountry\" name=\"clientCountry\"></input></li>";
    $displayString .= "</ul>";

    $displayString .= "<ul class=\"createClientFormRight\">";
    $displayString .= "<li><label for=\"clientCompany\">Company </label><input type=\"text\" size=\"20\" id=\"clientCompany\" name=\"clientCompany\"></input></li>";
    $displayString .= "<li><label for=\"clientPhoneNum\">Phone Number </label><input type=\"text\" size=\"20\" id=\"clientPhoneNum\" name=\"clientPhoneNum\"></input></li>";
    $displayString .= "<li><label for=\"clientEmail\">Email </label><input type=\"text\" size=\"20\" id=\"clientEmail\" name=\"clientEmail\"></input></li>";
    $displayString .= "<li><input class=\"clientCreateButton\" name=\"submit\" type=\"submit\" value=\"Create\"></input> <input class=\"clientResetButton\" name=\"reset\" type=\"reset\" value=\"Reset\"></input></li>";
    $displayString .= "</ul>";

    $displayString .= "</form>";

    $displayString .= "</div>";

    $displayString .= "<div id=\"clearDiv\"></div>";
} else {

    $displayString .= "<p>You need higher security clearence to create clients. Contact your administrator.</p>";
}

$displayString .= debugModeActive();

$displayString .= "</div>";

// Echo back to the page.
echo $displayString;
?>
