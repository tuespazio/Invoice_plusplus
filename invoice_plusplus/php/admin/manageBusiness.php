<?php

// Include database connection code.
include('../common/dbConn.php');
// Include debug functions
include('../common/debugFunctions.php');

// Create empty echo string.
$displayString = NULL;

session_start();

// Check user's security level
if ($_SESSION['securityLevel'] >= 7) {

// Declare and define the variables for the rest of the document.
    $businessID = null;
    $businessName = null;
    $businessAddress = null;
    $businessSuburb = null;
    $businessState = null;
    $businessPostcode = null;
    $businessCountry = null;
    $businessPhone = null;
    $businessEmail = null;

    ConnectToDB();

    $displayString .= "<div id=\"manageBusiness\">";
    $displayString .= "<h2>Manage Business</h2>";

// Test if the submit button has been pressed.
    if (isset($_POST['submitBusiness'])) {

        // Fill the variables with the POST data.
        $businessID = mysql_real_escape_string($_POST['businessID']);
        $businessName = mysql_real_escape_string($_POST['businessName']);
        $businessAddress = mysql_real_escape_string($_POST['businessAddress']);
        $businessSuburb = mysql_real_escape_string($_POST['businessSuburb']);
        $businessState = mysql_real_escape_string($_POST['businessState']);
        $businessPostcode = mysql_real_escape_string($_POST['businessPostcode']);
        $businessCountry = mysql_real_escape_string($_POST['businessCountry']);
        $businessPhone = mysql_real_escape_string($_POST['businessPhone']);
        $businessEmail = mysql_real_escape_string($_POST['businessEmail']);

        // Select every field from the ipp_business table with the businessID that was stored in the POST data so we can modify the right business, although there should only be one business.
        $sqlQuery = "SELECT * FROM ipp_business WHERE id = '$businessID'";

        $resultQuery = mysql_query($sqlQuery) or die(mysql_error());

        $numRows = mysql_num_rows($resultQuery);

        // Make sure there was actually a business there to edit.
        if ($numRows > 0) {

            // Update the fields in the table with the POST data.
            $sqlQuery = "UPDATE ipp_business SET businessName = '$businessName', address = '$businessAddress', suburb = '$businessSuburb', state = '$businessState', postcode = '$businessPostcode', country = '$businessCountry', phoneNumber = '$businessPhone', email = '$businessEmail' WHERE id = '$businessID'";

            $resultQuery = mysql_query($sqlQuery) or die(mysql_error());

            $displayString .= "<p style=\"color: blue;\">Business Successfully Modified in Database.</p>";
        } else {

            // if there wasn't any business rows, add one with the POST data.
            $sqlQuery = "INSERT INTO ipp_business (businessName, address, suburb, state, postcode, country, phoneNumber, email) VALUES ('$businessName', '$businessAddress', '$businessSuburb', '$businessState', '$businessPostcode', '$businessCountry', '$businessPhone', '$businessEmail')";

            $resultQuery = mysql_query($sqlQuery) or die(mysql_error());

            $displayString .= "<p style=\"color: blue;\">Business Successfully Inserted in Database.</p>";
        }
    } else {

        // This is run if the page wasn't posted to.

        $sqlQuery = "SELECT * FROM ipp_business";

        $resultQuery = mysql_query($sqlQuery) or die(mysql_error());

        $numRows = mysql_num_rows($resultQuery);

        if ($numRows > 0) {

            $row = mysql_fetch_array($resultQuery);

            // Basically filling in the variables with the data in the database, if there was any...
            // So we can see the textfields below fill up with the business data.

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
    }


    // Fill the display string buffer with the form.

    $displayString .= "<div id=\"manageBusinessFormDiv\">";

    $displayString .= "<form class=\"manageBusinessForm\" method=\"post\" action=\"#\">";

    $displayString .= "<ul class=\"manageBusinessFormLeft\">";
    $displayString .= "<li><label for=\"businessName\">Business Name </label><input type=\"text\" size=\"20\" id=\"businessName\" name=\"businessName\" value=\"$businessName\"></input></li>";
    $displayString .= "<li><label for=\"businessAddress\">Address </label><input type=\"text\" size=\"20\" id=\"businessAddress\" name=\"businessAddress\" value=\"$businessAddress\"></input></li>";
    $displayString .= "<li><label for=\"businessSuburb\">Suburb </label><input type=\"text\" size=\"20\" id=\"businessSuburb\" name=\"businessSuburb\" value=\"$businessSuburb\"></input></li>";
    $displayString .= "<li><label for=\"businessState\">State </label><input type=\"text\" size=\"10\" id=\"businessState\" name=\"businessState\" value=\"$businessState\"></input></li>";
    $displayString .= "<li><label for=\"businessPostcode\">Postcode </label><input type=\"text\" size=\"10\" id=\"businessPostcode\" name=\"businessPostcode\" value=\"$businessPostcode\"></input></li>";
    $displayString .= "<li><label for=\"businessCountry\">Country </label><input type=\"text\" size=\"20\" id=\"businessCountry\" name=\"businessCountry\" value=\"$businessCountry\"></input></li>";
    $displayString .= "</ul>";

    $displayString .= "<ul class=\"manageBusinessFormRight\">";
    $displayString .= "<li><label for=\"businessPhone\">Phone Number </label><input type=\"text\" size=\"20\" id=\"businessPhone\" name=\"businessPhone\" value=\"$businessPhone\"></input></li>";
    $displayString .= "<li><label for=\"businessEmail\">Email </label><input type=\"text\" size=\"20\" id=\"businessEmail\" name=\"businessEmail\" value=\"$businessEmail\"></input></li>";
    $displayString .= "<li><input id=\"$businessID\" class=\"manageBusinessSubmitButton\" name=\"submit\" type=\"submit\" value=\"Submit\"></input> <input class=\"manageBusinessResetButton\" name=\"reset\" type=\"reset\" value=\"Reset\"></input></li>";
    $displayString .= "</ul>";

    $displayString .= "</form>";

    $displayString .= "</div>";

    $displayString .= "<div id=\"clearDiv\"></div>";
} else {

    $displayString .= "<p>You need higher security clearence to manage the business. Contact your administrator.</p>";
}

$displayString .= "</div>";

DisconnectFromDB();

echo $displayString;
?>
