<?php

// Include database connection code.
include('./common/dbConn.php');
include('./alcatraz.php');

// Create variable for echo string.
$displayString = NULL;

// The following code is borrowed from 'http://www.webtoolkit.info/php-random-password-generator.html'
function generatePassword($length=9, $strength=0) {
    $vowels = 'aeuy';
    $consonants = 'bdghjmnpqrstvz';
    if ($strength & 1) {
        $consonants .= 'BDGHJLMNPQRSTVWXZ';
    }
    if ($strength & 2) {
        $vowels .= "AEUY";
    }
    if ($strength & 4) {
        $consonants .= '23456789';
    }
    if ($strength & 8) {
        $consonants .= '@#$%';
    }

    $password = '';
    $alt = time() % 2;
    for ($i = 0; $i < $length; $i++) {
        if ($alt == 1) {
            $password .= $consonants[(rand() % strlen($consonants))];
            $alt = 0;
        } else {
            $password .= $vowels[(rand() % strlen($vowels))];
            $alt = 1;
        }
    }
    return $password;
}

$email = mysql_real_escape_string($_POST['email']);

// Generate a temp password for the user.
$tempPassword = generatePassword(9, 4);

// Encrypt user's email and temp password to ensure more protection
$alcaLogin = alcaCrypt($email, $tempPassword);

// Set highest security level
$securityLevel = 9;

// Connect to DB
ConnectToDB();

// Get the email that the user entered.
$sqlQuery = "SELECT * FROM ipp_user WHERE email = '$email'";

$resultQuery = mysql_query($sqlQuery) or die(mysql_error());

$numRows = mysql_num_rows($resultQuery);

if($numRows == 1) {
    
    $row = mysql_fetch_array($resultQuery);
    
    $userID = $row['id'];
    
    // change their password.
    $sqlQuery = "UPDATE ipp_user SET alcaLogin = '$alcaLogin' WHERE id = '$userID'";

    $resultQuery = mysql_query($sqlQuery) or die(mysql_error());
    
    // This would usually be an email, but for the purposes of this assignment, it's displayed on the page.
    $displayString .= "<p>Password changed to: " . $tempPassword . "</p>";
} else {
    
    $displayString .= "<p>Cannot find email.</p>";
}

DisconnectFromDB();

echo $displayString;

$displayString = null;

?>
