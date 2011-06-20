/*
 * Nav Bar JQuery Code.
 * Scott Girling, 2011
 * 
 */

$(document).ready( function() {
    
    var contentContainer = $('#contentContainer > div'); // Set a variable to save on typing.
    
    contentContainer.hide().filter(':first').show(); // Hides all child divs in the contentContainer div but shows the first one.
    
    $('ul.contentNavLinks a, #footer a ').click( function() { // If a link in contentNavLinks is clicked.
        
        contentContainer.hide(); // Hide all child divs in contentContainer.
        contentContainer.filter(this.hash).show(); // Show the div according to the links hash code (ie. #firstDiv).
        $('ul.contentNavLinks a').removeClass('selected'); // Remove the selected class from all links, which should only be one anyway.
        $(this).addClass('selected'); // Add the class 'selected' to the clicked link.
        
        return false; // Stop all browser functions.
    }).filter(':first').click();
    
    $('#signUpButton a').click( function() {
       
        $('#contentPricingSignUp').hide();
        $('#signUp').show();
       
        return false;
    });
});