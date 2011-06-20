<?php

// Include database connection code.
include('../common/dbConn.php');
// Include debug functions
include('../common/debugFunctions.php');

// Create empty echo string.
$displayString = NULL;

$displayString .= "<div id=\"deleteUser\">";
$displayString .= "<h2>Delete User</h2>";

session_start();

// Check the user's security level.
if ($_SESSION['securityLevel'] >= 7) {

// Test if a user has been deleted.
    if (isset($_POST['rowID'])) {

        // Get the row id of the row that the user clicked on, this was posted to the form. The id was retrieved from the table Row.
        $rowID = $_POST['rowID'];

        ConnectToDB();

        // Delete the row from the database where the row id is equal to the posted id.
        $sqlQuery = "DELETE FROM ipp_user WHERE id = '$rowID'";

        $resultQuery = mysql_query($sqlQuery) or die(mysql_error());

        DisconnectFromDB();

        $displayString .= "<p style=\"color: blue;\">User Successfully Deleted in Database.</p>";
    }

    // Create a table and fill it with data retrieved from the database.

    ConnectToDB();

    $sqlQuery = "SELECT * FROM ipp_user ORDER BY surname";

    $resultQuery = mysql_query($sqlQuery) or die(mysql_error());

    $displayString .= "<table>";
    $displayString .= "<tr><th>First Name</th>";
    $displayString .= "<th>Surname</th>";
    $displayString .= "<th>Email</th>";
    $displayString .= "<th>Security Level</th>";

    while ($row = mysql_fetch_array($resultQuery)) {

        $userID = $row['id'];
        $userFirstName = $row['firstName'];
        $userSurname = $row['surname'];
        $userEmail = $row['email'];
        $userSec = $row['securityLevel'];

        // Attach the userID to the row id (for Ajax to retrieve).
        $displayString .= "<tr id='$userID'>";
        $displayString .= "<td>$userFirstName</td>";
        $displayString .= "<td>$userSurname</td>";
        $displayString .= "<td>$userEmail</td>";
        $displayString .= "<td>$userSec</td>";
        $displayString .= "</tr>";
    }

    DisconnectFromDB();

    $displayString .= "</table>";
} else {

    $displayString .= "<p>You need higher security clearence to delete users. Contact your administrator.</p>";
}

$displayString .= debugModeActive();

$displayString .= "</div>";

echo $displayString;
?>
