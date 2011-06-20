<?php

/*
 * Just some debug functions I made to see how much RAM the website was using up.
 * 
 */

// I never use this function but all it does is return how much RAM a particular variable is using.
function sizeofvar($var) {
    $start_memory = memory_get_usage();
    $tmp = $var;
    return memory_get_usage() - $start_memory;
}

function debugModeActive() {
    
    if (isset($_SESSION['debugMode'])) {

        $memoryUsageKB = memory_get_usage() / 1024; // I made this to convert to KB because memory_get_usage returns bytes.
        $memoryPeakUsage = memory_get_peak_usage() / 1024; // Same reason.

        $displayString = null;
        
        $displayString .= "<p class=\"debugMode\">Debug Information</p>";
        $displayString .= "<p class=\"debugMode\">" . $memoryUsageKB . " KB of Memory Used</p>";
        $displayString .= "<p class=\"debugMode\">" . $memoryPeakUsage . " KB Peak Memory Usage</p>";
        
        return $displayString;
    }
}

?>
