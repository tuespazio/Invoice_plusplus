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

// Place POST array strings into PHP variables.
$firstName = mysql_real_escape_string($_POST['firstName']);
$surname = mysql_real_escape_string($_POST['surname']);
$address = mysql_real_escape_string($_POST['address']);
$suburb = mysql_real_escape_string($_POST['suburb']);
$state = mysql_real_escape_string($_POST['state']);
$postcode = mysql_real_escape_string($_POST['postcode']);
$country = mysql_real_escape_string($_POST['country']);
$email = mysql_real_escape_string($_POST['email']);
$ccNumber = mysql_real_escape_string($_POST['ccNumber']);
$ccName = mysql_real_escape_string($_POST['ccName']);
$ccv = mysql_real_escape_string($_POST['ccv']);
$expiryOne = mysql_real_escape_string($_POST['expiryOne']);
$expiryTwo = mysql_real_escape_string($_POST['expiryTwo']);

// Generate a temp password for the user.
$tempPassword = generatePassword(9, 4);

// Encrypt user's email and temp password to ensure more protection
$alcaLogin = alcaCrypt($email, $tempPassword);

// Set highest security level
$securityLevel = 9;

// Connect to DB
ConnectToDB();

// Create a string containing a query
$sqlQuery = "INSERT INTO ipp_user (firstName, surname, address, suburb, state, postcode, country, email, ccNumber, ccName, ccv, expiryOne, expiryTwo, alcaLogin, securityLevel) VALUES ('$firstName', '$surname', '$address', '$suburb', '$state', '$postcode' , '$country', '$email', '$ccNumber', '$ccName', '$ccv', '$expiryOne', '$expiryTwo', '$alcaLogin', '$securityLevel')";

// Process the query
mysql_query($sqlQuery)
        or die(mysql_error());

// Disconnect from DB.
DisconnectFromDB();

// Fill the display string.
$displayString .= "<p>Sign Up Successful, check your email for a password.</p><p>For the purposes of this assignment here is your password: " . $tempPassword . "</p>";

// Echo display string back to page.
echo $displayString;

// Clear the string.
$displayString = NULL;
?>
