
/*
 * 
 * Ajax function to post data to the sign up script.
 * 
 */

$(document).ready ( function() {
    
    $('.signUpButton').click(function () {
        
        if($('input#email').val() == '') {
            
            alert('Please provide an Email address.');
            return false;
        }
        
        // Get values from the form.
        var firstName = $('input#firstName').val();
        var surname = $('input#surname').val();
        var address = $('input#address').val();
        var suburb = $('input#suburb').val();
        var state = $('input#state').val();
        var postcode = $('input#postcode').val();
        var country = $('input#country').val();
        var email = $('input#email').val();
        var ccNumber = $('input#ccNumber').val();
        var ccName = $('input#ccName').val();
        var ccv = $('input#ccv').val();
        var expiryOne = $('input#expiryOne').val();
        var expiryTwo = $('input#expiryTwo').val();
        
        // Perform Ajax functions.

        $.post( "php/signUpProcess.php", {
            firstName: firstName, 
            surname: surname, 
            address: address, 
            suburb: suburb, 
            state: state, 
            postcode: postcode, 
            country: country, 
            email: email, 
            ccNumber: ccNumber, 
            ccName: ccName, 
            ccv: ccv, 
            expiryOne: expiryOne, 
            expiryTwo: expiryTwo
        },
        function( data ) {
            $('#signUp').html(data);
        });

        return false;
        
    });
    
});