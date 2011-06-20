/*
 * Nav Bar JQuery Code.
 * Scott Girling, 2011
 * 
 */

/*
 * 
 * Basically hides all divs until a link is clicked to show the div.
 * 
 */

$(document).ready( function() {
    
    $('#linkContainer > div').hide().filter(':first').show();
    
    $('#linkContainer ul.navBar a').click( function() {
        
        $('#linkContainer ul.navBar a').removeClass('selected');
        $(this).addClass('selected');
        $('#linkContainer > div').hide();
        $('#linkContainer > div').filter(this.hash).show();
        
        return false;
    });
    
});