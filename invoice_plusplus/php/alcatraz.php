<?php

/*
 * 
 * Alcatraz Encryption Algorithm
 * By Scott Girling, 2011
 * 
 */

function alcaCrypt($string, $stringTwo) { // Have to enter two strings, username and password.
    $encryptedStr = null; // Prepare a string for the final encryption.

    for ($i = 0; $i < strlen($string); $i++) { // Run through each character of the string and replace it with a set of three defined characters in testChar below.
        $tempChar = testChar($string[$i]); // Replace the char at index $i.

        $encryptedStr .= $tempChar; // Append to final string.

        for ($n = 0; $n < strlen($stringTwo); $n++) { // Do the same as above but the whole second string. This occures after each letter in the first string. Will confuse hackers (I think).
            $tempCharTwo = testChar($stringTwo[$n]);

            $encryptedStr .= $tempCharTwo;
        }
    }

    $encryptedStr = md5($encryptedStr); // md5 the final encryption string for further security.

    return $encryptedStr; // Return the string.
}

// Predefined list of characters.
function testChar($char) {

    $returnChar = null;

    switch ($char) {
        case 'a': $returnChar = 'J58';
            return $returnChar;

        case 'b': $returnChar = 'k10';
            return $returnChar;

        case 'c': $returnChar = 'Lj8';
            return $returnChar;

        case 'd': $returnChar = 'm45';
            return $returnChar;

        case 'e': $returnChar = 'N13';
            return $returnChar;

        case 'f': $returnChar = 'o99';
            return $returnChar;

        case 'g': $returnChar = 'P08';
            return $returnChar;

        case 'h': $returnChar = '5f2';
            return $returnChar;

        case 'i': $returnChar = '4h6';
            return $returnChar;

        case 'j': $returnChar = '55v';
            return $returnChar;

        case 'k': $returnChar = 'g12';
            return $returnChar;

        case 'l': $returnChar = '55b';
            return $returnChar;

        case 'm': $returnChar = 'gt7';
            return $returnChar;

        case 'n': $returnChar = 'bB5';
            return $returnChar;

        case 'o': $returnChar = 'gT4';
            return $returnChar;

        case 'p': $returnChar = 'lI3';
            return $returnChar;

        case 'q': $returnChar = 'bW4';
            return $returnChar;

        case 'r': $returnChar = 'ftA';
            return $returnChar;

        case 's': $returnChar = '55c';
            return $returnChar;

        case 't': $returnChar = 'tH4';
            return $returnChar;

        case 'u': $returnChar = 'xx3';
            return $returnChar;

        case 'v': $returnChar = 'Xf3';
            return $returnChar;

        case 'w': $returnChar = '11f';
            return $returnChar;

        case 'x': $returnChar = 'br4';
            return $returnChar;

        case 'y': $returnChar = 'kD9';
            return $returnChar;

        case 'z': $returnChar = '8Dz';
            return $returnChar;

        case 'A': $returnChar = 'ff5';
            return $returnChar;

        case 'B': $returnChar = 'F56';
            return $returnChar;

        case 'C': $returnChar = 'm6G';
            return $returnChar;

        case 'D': $returnChar = 'vFo';
            return $returnChar;

        case 'E': $returnChar = '3GC';
            return $returnChar;

        case 'F': $returnChar = 'lOh';
            return $returnChar;

        case 'G': $returnChar = '4V4';
            return $returnChar;

        case 'H': $returnChar = 'hgT';
            return $returnChar;

        case 'I': $returnChar = 'GGk';
            return $returnChar;

        case 'J': $returnChar = 'vT0';
            return $returnChar;

        case 'K': $returnChar = '48E';
            return $returnChar;

        case 'L': $returnChar = 'ppH';
            return $returnChar;

        case 'M': $returnChar = 'qE4';
            return $returnChar;

        case 'N': $returnChar = 'Gd2';
            return $returnChar;

        case 'O': $returnChar = 'UjU';
            return $returnChar;

        case 'P': $returnChar = 'Rec';
            return $returnChar;

        case 'Q': $returnChar = 'G41';
            return $returnChar;

        case 'R': $returnChar = 'zXw';
            return $returnChar;

        case 'S': $returnChar = 'Wx9';
            return $returnChar;

        case 'T': $returnChar = 'eG5';
            return $returnChar;

        case 'U': $returnChar = 'amV';
            return $returnChar;

        case 'V': $returnChar = 'e6B';
            return $returnChar;

        case 'W': $returnChar = 'ff7';
            return $returnChar;

        case 'X': $returnChar = 'KuH';
            return $returnChar;

        case 'Y': $returnChar = '5Bg';
            return $returnChar;

        case 'Z': $returnChar = 'e3D';
            return $returnChar;

        case '0': $returnChar = 'mu8';
            return $returnChar;

        case '1': $returnChar = 'f6C';
            return $returnChar;

        case '2': $returnChar = 'pL4';
            return $returnChar;

        case '3': $returnChar = 'gG5';
            return $returnChar;

        case '4': $returnChar = 'f4Z';
            return $returnChar;

        case '5': $returnChar = '7j2';
            return $returnChar;

        case '6': $returnChar = '9vv';
            return $returnChar;

        case '7': $returnChar = '5lJ';
            return $returnChar;

        case '8': $returnChar = '2cC';
            return $returnChar;

        case '9': $returnChar = 'qq8';
            return $returnChar;

        default: return $char;
    }
}

?>
