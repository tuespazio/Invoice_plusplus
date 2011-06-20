/*
 * Ajax functions to post form data to the login script and test if the user can login or not.
 * 
 */

$(document).ready ( function() {
    
    $('.loginButton').click(loginButtonOnClick);
    $('#forgotPasswordLink').click(forgotPasswordLinkClick);
    
});

function loginButtonOnClick() {
        
    // Get values from the form.
    var loginName = $('input#loginName').val();
    var loginPassword = $('input#loginPassword').val();

    // Perform Ajax functions.

    $.post( "php/loginProcess.php", {
        loginName: loginName, 
        loginPassword: loginPassword
    },
    function( data ) {
        $('#contentLogin').html(data);
        $('.loginButton').click(loginButtonOnClick);
        $('#forgotPasswordLink').click(forgotPasswordLinkClick);
    });

    return false;
}

function forgotPasswordLinkClick() {
    
    if($('input#loginName').val() == '') {
        
        alert('Please enter an email address to reset your password.');
        return false;
    }
    
    var email = $('input#loginName').val();
    
        $.post( "php/resetPassword.php", {
        email: email
    },
    function( data ) {
        $('#conRes').html(data);
    });
    
    return false;
}