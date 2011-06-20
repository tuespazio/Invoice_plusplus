<?php

// Include database connection code.
include('../common/dbConn.php');
// Include debug functions
include('../common/debugFunctions.php');
include('../alcatraz.php');

// Create empty echo string.
$displayString = NULL;

session_start();

ConnectToDB();

$displayString .= "<div id=\"changePassword\">";
$displayString .= "<h2>Change Password</h2>";

// Has a new password been submitted?
if (isset($_POST['newPassword'])) {

    $newPassword = mysql_escape_string($_POST['newPassword']);
    $userEmail = $_SESSION['loginSuccessful'];

    // Set a variable with the new alcaLogin
    $alcaLogin = alcaCrypt($userEmail, $newPassword);

    // Update the user's alcaLogin with the new string.
    $sqlQuery = "UPDATE ipp_user SET alcaLogin = '$alcaLogin' WHERE email = '$userEmail'";

    $resultQuery = mysql_query($sqlQuery) or die(mysql_error());

    $displayString .= "<p style=\"color: blue;\">Password Changed in Database.</p>";
}

if ($_SESSION['securityLevel'] >= 3) {
// Get the current user's email address.
$userEmail = $_SESSION['loginSuccessful'];

$displayString .= "<form class=\"changePasswordForm\" method=\"post\" action=\"#\">";
$displayString .= "<p>Change password for: $userEmail</p>";
$displayString .= "<label for=\"newPassword\">New Password </label> <input type=\"text\" size=\"20\" id=\"newPassword\" name=\"newPassword\"></input>";
$displayString .= "<input class=\"newPasswordSubmitButton\" name=\"submit\" type=\"submit\" value=\"Submit\"></input>";
$displayString .= "</form>";

} else {
    
    $displayString .= "<p>You need a higher security level to change your password.</p>";
}

DisconnectFromDB();

$displayString .= "</div>";

echo $displayString;
?>
