<?php

// Include database connection code.
include('../common/dbConn.php');
// Include debug functions
include('../common/debugFunctions.php');
include('../alcatraz.php');

// Create empty echo string.
$displayString = NULL;

$displayString .= "<div id=\"addUser\">";
$displayString .= "<h2>Add User</h2>";

session_start();

// Check user's security level
if ($_SESSION['securityLevel'] >= 7) {

// Test if a client has been created.
    if (isset($_POST['userFirstName'])) {

        ConnectToDB();

        // Set client variables.
        $userFirstName = mysql_real_escape_string($_POST['userFirstName']);
        $userSurname = mysql_real_escape_string($_POST['userSurname']);
        $userEmail = mysql_real_escape_string($_POST['userEmail']);
        $userSec = mysql_real_escape_string($_POST['userSec']);

        $defaultPassword = alcaCrypt($userEmail, $userSurname);

        // Check if the user exists by searching for the email
        $sqlQuery = "SELECT * FROM ipp_user WHERE email = '$userEmail'";

        $resultQuery = mysql_query($sqlQuery)
                or die(mysql_error());

        $numRow = mysql_num_rows($resultQuery);

        // See if any rows were returned.
        if ($numRow > 0) {

            $displayString .= "<p style=\"color: blue;\">User Already Exists.</p>";
        } else {

            // Create a SQL query.
            $sqlQuery = "INSERT INTO ipp_user (firstName, surname, email, alcaLogin, securityLevel) VALUES ('$userFirstName', '$userSurname', '$userEmail', '$defaultPassword', '$userSec')";

            // Process the query
            mysql_query($sqlQuery)
                    or die(mysql_error());

            DisconnectFromDB();

            $displayString .= "<p style=\"color: blue;\">User Successfully Inserted Into Database. Surname is default password.</p>";
        }
    }

    // Create the form.

    $displayString .= "<div id=\"addUserFormDiv\">";

    $displayString .= "<form class=\"createClientForm\" method=\"post\" action=\"#\">";

    $displayString .= "<ul class=\"createClientFormLeft\">";
    $displayString .= "<li><label for=\"userFirstName\">First Name </label><input type=\"text\" size=\"20\" id=\"userFirstName\" name=\"userFirstName\"></input></li>";
    $displayString .= "<li><label for=\"userSurname\">Surname </label><input type=\"text\" size=\"20\" id=\"userSurname\" name=\"userSurname\"></input></li>";
    $displayString .= "</ul>";

    $displayString .= "<ul class=\"createClientFormRight\">";
    $displayString .= "<li><label for=\"userEmail\">Email </label><input type=\"text\" size=\"20\" id=\"userEmail\" name=\"userEmail\"></input></li>";
    $displayString .= "<li><label for=\"userSec\">Security Level 1-9 </label><input type=\"text\" size=\"20\" id=\"userSec\" name=\"userSec\"></input></li>";
    $displayString .= "<li><input class=\"userAddButton\" name=\"submit\" type=\"submit\" value=\"Create\"></input> <input class=\"userResetButton\" name=\"reset\" type=\"reset\" value=\"Reset\"></input></li>";
    $displayString .= "</ul>";

    $displayString .= "</form>";

    $displayString .= "</div>";

    $displayString .= "<div id=\"clearDiv\"></div>";
} else {

    $displayString .= "<p>You need higher security clearence to add users. Contact your administrator.</p>";
}

$displayString .= debugModeActive();

$displayString .= "</div>";

// Echo back to the page.
echo $displayString;
?>
