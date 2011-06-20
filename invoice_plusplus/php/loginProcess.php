<?php

// Include database connection code.
include('./common/dbConn.php');
include('./alcatraz.php');

// Create a variable for a echo string.
$displayString = NULL;

// Place POST array strings into PHP variables.
$loginName = mysql_real_escape_string($_POST['loginName']);
$loginPassword = mysql_real_escape_string($_POST['loginPassword']);

// Set a variable containing the alcaLogin string.
$alcaLogin = alcaCrypt($loginName, $loginPassword);

ConnectToDB();

// Test if any row contains the alcaLogin.
$sqlQuery = "SELECT * FROM ipp_user WHERE alcaLogin = '$alcaLogin'";

// Run the query or error.
$resultQuery = mysql_query($sqlQuery)
        or die(mysql_error());

// Fetch the successful row.
$row = mysql_fetch_array($resultQuery);

DisconnectFromDB();

// If a row was returned do this -
if ($row) {

    // Set session variables.
    session_start();
    $_SESSION['loginSuccessful'] = $row['email'];
    $_SESSION['securityLevel'] = $row['securityLevel'];

    // Return to the page and redirect it.
    $displayString .= '<script type="text/javascript"> window.location = "clientIndex.php"; </script>';
} else {

    // return a new login form incase login and password incorrect.
    $displayString .= "<p>Username or Password Incorrect.</p><form class=\"loginForm\" method=\"post\" action=\"#\">
                    <h2>E-Mail Address</h2>
                    <p><input class=\"textfield\" id=\"loginName\" name=\"loginName\" type=\"text\" size=\"50\"></input></p>
                    <h2>Password</h2>
                    <p><input class=\"textfield\" id=\"loginPassword\" name=\"loginPassword\" type=\"password\" size=\"50\"></input></p>
                    <p><input class=\"loginButton\" name=\"submit\" type=\"submit\" value=\"Login\"></input></p>
                    <p class=\"forgotDetails\"><a href=\"#\" title=\"Forgot Password\">Forgot Password</a></p>
                </form>";
}

// Echo display string back to page.
echo $displayString;

// Clear the string.
$displayString = NULL;
?>
