<?php

// Include database connection code.
include('../common/dbConn.php');
// Include debug functions
include('../common/debugFunctions.php');

// Create empty echo string.
$displayString = NULL;

$displayString .= "<div id=\"generateReport\">";
$displayString .= "<h2>Generate Report</h2>";

session_start();

// Create a form that will go to processReport.php when a report is selected.
$displayString .= "<form class=\"generateReportForm\" method=\"post\" action=\"php/report/processReport.php\">";

$displayString .= "<select id=\"reportName\" name=\"reportName\">";

// Some sample reports.
$displayString .= "<option value=\"1\">Paid Invoices</option>";
$displayString .= "<option value=\"2\">Pending Invoices</option>";
$displayString .= "<option value=\"3\">Products Out of Stock</option>";

$displayString .= "</select>";

$displayString .= "<input class=\"generateReportButton\" name=\"submit\" type=\"submit\" value=\"Generate\"></input>";

$displayString .= "</form>";

$displayString .= "</div>";

echo $displayString;
?>
