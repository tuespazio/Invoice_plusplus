/*  This file is basically all ajax. I'm not going to explain each function, I will give a general overview here.
*   
*   When the document finishes loading, functions are applied to DOM elements, mainly links when the document loads.
*   All the functions are Ajax based and they retrieve PHP pages and fill the main content display div with the data that is returned.
*   
*   Some of the functions get form data and post it to the PHP page.
*   
*/

$(document).ready ( function() {
    
    $('a#createProductLink').click(createProductLinkClick);
    $('a#modifyProductLink').click(modifyProductLinkClick);
    $('a#deleteProductLink').click(deleteProductLinkClick);
    $('a#createClientLink').click(createClientLinkClick);
    $('a#modifyClientLink').click(modifyClientLinkClick);
    $('a#deleteClientLink').click(deleteClientLinkClick);
    $('a#createInvoiceLink').click(createInvoiceLinkClick);
    $('a#mostRecentInvoiceLink').click(mostRecentInvoiceLinkClick);
    $('a#pendingInvoicesLink').click(pendingInvoiceLinkClick);
    $('a#generateReportLink').click(generateReportLinkClick);
    $('a#manageBusinessLink').click(manageBusinessLinkClick);
    $('a#changePasswordLink').click(changePasswordLinkClick);
    $('a#logoutLink').click(logoutLinkClick);
    $('#searchButton').click(searchButtonClick);
    $('a#addUserLink').click(addUserLinkClick);
    $('a#deleteUserLink').click(deleteUserLinkClick);
    
});

function deleteUserRowClick() {
    
    var rowID = this.id;
    
    var reallyDelete = confirm("Do you really want to delete this user?");
    
    if(reallyDelete) {
        
        $.post( "php/admin/deleteUser.php", {
            rowID: rowID
        },
        function( data ) {
            $('#contentDisplay').html(data);
            $('#deleteUser tr').click(deleteUserRowClick);
            $('#deleteUser tr').first().unbind();
        });
    } else {
        
        return false;
    }
    
    return false; 
}

function deleteUserLinkClick() {
    
    $.post( "php/admin/deleteUser.php",
        function( data ) {
            $('#contentDisplay').html(data);
            $('#deleteUser tr').click(deleteUserRowClick);
            $('#deleteUser tr').first().unbind();
        });

    return false;
}

function addUserLinkClick() {
    
    $.post( "php/admin/addUser.php",
        function( data ) {
            $('#contentDisplay').html(data);
            $('.userAddButton').click(userAddButtonClick);

        });

    return false;
}

function userAddButtonClick() {
    
    var userFirstName = $('#userFirstName').val();
    var userSurname = $('#userSurname').val();
    var userEmail = $('#userEmail').val();
    var userSec = $('#userSec').val();

    $.post( "php/admin/addUser.php", {
        userFirstName: userFirstName,
        userSurname: userSurname,
        userEmail: userEmail,
        userSec: userSec
    },
    function( data ) {
        $('#contentDisplay').html(data);
        $('.userAddButton').click(userAddButtonClick);
    });

    return false; 
}

function changePasswordLinkClick() {
    
    $.post( "php/admin/changePassword.php",
        function( data ) {
            $('#contentDisplay').html(data);
            $('.newPasswordSubmitButton').click(newPasswordSubmitButtonClick);

        });

    return false; 
}

function newPasswordSubmitButtonClick() {
    
    var newPassword = $('#newPassword').val();

    $.post( "php/admin/changePassword.php", {
        newPassword: newPassword
    },
    function( data ) {
        $('#contentDisplay').html(data);
        $('.newPasswordSubmitButton').click(newPasswordSubmitButtonClick);
    });

    return false; 
}

function manageBusinessLinkClick() {
    
    $.post( "php/admin/manageBusiness.php",
        function( data ) {
            $('#contentDisplay').html(data);
            $('.manageBusinessSubmitButton').click(manageBusinessSubmitButtonClick);

        });

    return false;  
}

function manageBusinessSubmitButtonClick() {
    
    var businessID = this.id;
    var businessName = $('input#businessName').val();
    var businessAddress = $('input#businessAddress').val();
    var businessSuburb = $('input#businessSuburb').val();
    var businessState = $('input#businessState').val();
    var businessPostcode = $('input#businessPostcode').val();
    var businessCountry = $('input#businessCountry').val();
    var businessPhone = $('input#businessPhone').val();
    var businessEmail = $('input#businessEmail').val();
    
    $.post( "php/admin/manageBusiness.php", {
        submitBusiness: 1,
        businessID: businessID,
        businessName: businessName, 
        businessAddress: businessAddress, 
        businessSuburb: businessSuburb, 
        businessState: businessState, 
        businessPostcode: businessPostcode, 
        businessCountry: businessCountry, 
        businessPhone: businessPhone, 
        businessEmail: businessEmail
    },
    function( data ) {
        $('#contentDisplay').html(data);
        $('.clientCreateButton').click(manageBusinessSubmitButtonClick);
    });
     
    return false;
}

function generateReportLinkClick() {
    
    $.post( "php/report/generateReport.php",
        function( data ) {
            $('#contentDisplay').html(data);

        });

    return false;
}

function pendingInvoiceLinkClick() {
    
    $.post( "php/invoice/pendingInvoice.php",
        function( data ) {
            $('#contentDisplay').html(data);
            $('#pendingInvoice tr').click(infoInvoiceClick);
            $('#pendingInvoice tr').first().unbind();
        });

    return false;
}

function infoInvoiceClick() {
    
    var rowID = this.id;
    
    $.post( "php/invoice/infoInvoice.php", {
        rowID: rowID
    }, 
    function( data ) {
        $('#contentDisplay').html(data);
        $('.printInvoice').click(printInvoiceButtonClick);
        $('.payInvoice').click(payInvoiceButtonClick);
    });
     
    return false;
}

function payInvoiceButtonClick() {
    
    var rowID = this.id;
    
    var reallyPay = confirm("Do you really want to pay this invoice?");
    
    if(reallyPay) {
        
        $.post( "php/invoice/infoInvoice.php", {
            payInvoice: 1,
            rowID: rowID
        },
        function( data ) {
            $('#contentDisplay').html(data);
            $('.printInvoice').click(printInvoiceButtonClick);
            $('.payInvoice').click(payInvoiceButtonClick);
        });
    } else {
        
        return false;
    }
    
    return false;
}

function searchButtonClick() {
    
    var searchTerm = $('#searchfield').val();
    
    $.post( "php/search/searchPage.php", {
        search: 1, 
        searchTerm: searchTerm
    },
    function( data ) {
        $('#contentDisplay').html(data);
        $('#productSearchTable tr').click(modifyProductRowClick);
        $('#productSearchTable tr').first().unbind();
        $('#invoiceSearchTable tr').click(infoInvoiceClick);
        $('#invoiceSearchTable tr').first().unbind();
        $('#clientSearchTable tr').click(modifyClientRowClick);
        $('#clientSearchTable tr').first().unbind();
    });
    
    return false;
}

function mostRecentInvoiceLinkClick() {
    
    $.post( "php/invoice/mostRecentInvoice.php",
        function( data ) {
            $('#contentDisplay').html(data);
            $('.printInvoice').click(printInvoiceButtonClick);
        });

    return false;
}

function printInvoiceButtonClick() {
    
    window.open("php/invoice/printInvoice.php");
    
    return false;
}

function createInvoiceLinkClick() {
    
    $.post( "php/invoice/createInvoice.php",
        function( data ) {
            $('#contentDisplay').html(data);
            $('.invoiceCreateButton').click(invoiceCreateButtonClick);
            $('.saveNewInvoice').click(saveNewInvoiceButtonClick);
            $('.deleteInvoice').click(deleteInvoiceButtonClick);
            $('.invoiceProductSubmit').click(invoiceProductSubmitClick);
            $('#createInvoice tr').click(deleteInvoiceProductRowClick);
            $('#createInvoice tr').first().unbind();
        });

    return false;
}

function deleteInvoiceProductRowClick() {
    
    var idString = this.id;
    
    var reallyDelete = confirm("Do you really want to delete this product?");
    
    if(reallyDelete) {
        
        $.post( "php/invoice/createInvoice.php", {
            deleteProductRow: 1,
            idString: idString
        },
        function( data ) {
            $('#contentDisplay').html(data);
            $('.invoiceCreateButton').click(invoiceCreateButtonClick);
            $('.saveNewInvoice').click(saveNewInvoiceButtonClick);
            $('.deleteInvoice').click(deleteInvoiceButtonClick);
            $('.invoiceProductSubmit').click(invoiceProductSubmitClick);
            $('#createInvoice tr').click(deleteInvoiceProductRowClick);
            $('#createInvoice tr').first().unbind();
        });
    } else {
        
        return false;
    }
    
    return false;
}

function invoiceCreateButtonClick() {
    
    var invoiceClientID = $('#invoiceClientName').val();

    $.post( "php/invoice/createInvoice.php", {
        invoiceClientID: invoiceClientID
    },
    function( data ) {
        $('#contentDisplay').html(data);
        $('.saveNewInvoice').click(saveNewInvoiceButtonClick);
        $('.deleteInvoice').click(deleteInvoiceButtonClick);
        $('.invoiceProductSubmit').click(invoiceProductSubmitClick);
        $('#createInvoice tr').click(deleteInvoiceProductRowClick);
        $('#createInvoice tr').first().unbind();
    });

    return false; 
}

function invoiceProductSubmitClick() {
    
    var invoiceID = this.id;
    var productID = $('#invoiceProductName').val();
    var productQty = $('#invoiceProductQty').val();
    
    $.post( "php/invoice/createInvoice.php", {
        submitProduct: 1, 
        invoiceID: invoiceID, 
        productID: productID, 
        productQty: productQty
    },
    function( data ) {
        $('#contentDisplay').html(data);
        $('.saveNewInvoice').click(saveNewInvoiceButtonClick);
        $('.deleteInvoice').click(deleteInvoiceButtonClick);
        $('.invoiceProductSubmit').click(invoiceProductSubmitClick);
        $('#invoiceProductQty').val("");
        $('#createInvoice tr').click(deleteInvoiceProductRowClick);
        $('#createInvoice tr').first().unbind();
    });
    
    return false;
    
}

function deleteInvoiceButtonClick() {
    
    var invoiceID = this.id;
    
    var reallyDelete = confirm('Do you really want to delete this invoice?');
    
    if(reallyDelete) {
        $.post( "php/invoice/createInvoice.php", {
            deleteInvoice: 1, 
            invoiceID: invoiceID
        },
        function( data ) {
            $('#contentDisplay').html(data);
            $('.invoiceCreateButton').click(invoiceCreateButtonClick);
        });
    } else {
        
        return false;
    }

    return false; 
}

function saveNewInvoiceButtonClick() {

    $.post( "php/invoice/createInvoice.php", {
        saveNewInvoice: 1
    },
    function( data ) {
        $('#contentDisplay').html(data);
        $('.invoiceCreateButton').click(invoiceCreateButtonClick);
    });

    return false; 
}

function deleteProductLinkClick() {
    
    $.post( "php/product/deleteProduct.php",
        function( data ) {
            $('#contentDisplay').html(data);
            $('#deleteProduct tr').click(deleteProductRowClick);
            $('#deleteProduct tr').first().unbind();
        });

    return false;
}

function deleteProductRowClick() {
    
    var rowID = this.id;
    
    var reallyDelete = confirm("Do you really want to delete this product?");
    
    if(reallyDelete) {
        
        $.post( "php/product/deleteProduct.php", {
            rowID: rowID
        },
        function( data ) {
            $('#contentDisplay').html(data);
            $('#deleteProduct tr').click(deleteProductRowClick);
            $('#deleteProduct tr').first().unbind();
        });
    } else {
        
        return false;
    }
    
    return false;
}

function deleteClientLinkClick() {
    
    $.post( "php/client/deleteClient.php",
        function( data ) {
            $('#contentDisplay').html(data);
            $('#deleteClient tr').click(deleteClientRowClick);
            $('#deleteClient tr').first().unbind();
        });

    return false;
}

function deleteClientRowClick() {
    
    var rowID = this.id;
    
    var reallyDelete = confirm("Do you really want to delete this client?");
    
    if(reallyDelete) {
        
        $.post( "php/client/deleteClient.php", {
            rowID: rowID
        },
        function( data ) {
            $('#contentDisplay').html(data);
            $('#deleteClient tr').click(deleteClientRowClick);
            $('#deleteClient tr').first().unbind();
        });
    } else {
        
        return false;
    }
    
    return false;
}

function modifyClientLinkClick() {
    
    $.post( "php/client/modifyClient.php",
        function( data ) {
            $('#contentDisplay').html(data);
            $('#modifyClient tr').click(modifyClientRowClick);
            $('#modifyClient tr').first().unbind();
        });

    return false;
}

function modifyClientRowClick() {
    
    var rowID = this.id;
    
    $.post( "php/client/modifyClient.php", {
        rowID: rowID
    }, 
    function( data ) {
        $('#contentDisplay').html(data);
        $('#modifyClient tr').click(modifyClientRowClick);
        $('#modifyClient tr').first().unbind();
        $('.clientModifyButton').click(modifyClientButtonClick);
    });
     
    return false;
}

function modifyClientButtonClick() {
    
    var modifyClientID = this.id;
    var modifyClientFirstName = $('input#modifyClientFirstName').val();
    var modifyClientSurname = $('input#modifyClientSurname').val();
    var modifyClientAddress = $('input#modifyClientAddress').val();
    var modifyClientSuburb = $('input#modifyClientSuburb').val();
    var modifyClientState = $('input#modifyClientState').val();
    var modifyClientPostcode = $('input#modifyClientPostcode').val();
    var modifyClientCountry = $('input#modifyClientCountry').val();
    var modifyClientCompany = $('input#modifyClientCompany').val();
    var modifyClientPhoneNum = $('input#modifyClientPhoneNum').val();
    var modifyClientEmail = $('input#modifyClientEmail').val();
    
    $.post( "php/client/modifyClient.php", {
        modifyClientID: modifyClientID, 
        modifyClientFirstName: modifyClientFirstName, 
        modifyClientSurname: modifyClientSurname, 
        modifyClientAddress: modifyClientAddress, 
        modifyClientSuburb: modifyClientSuburb, 
        modifyClientState: modifyClientState, 
        modifyClientPostcode: modifyClientPostcode, 
        modifyClientCountry: modifyClientCountry, 
        modifyClientCompany: modifyClientCompany, 
        modifyClientPhoneNum: modifyClientPhoneNum, 
        modifyClientEmail: modifyClientEmail
    },
    function( data ) {
        $('#contentDisplay').html(data);
        $('#modifyClient tr').click(modifyClientRowClick);
        $('#modifyClient tr').first().unbind();
    });
     
    return false;
}

function createClientLinkClick() {
    
    $.post( "php/client/createClient.php",
        function( data ) {
            $('#contentDisplay').html(data);
            $('.clientCreateButton').click(clientCreateButtonClick);
        });

    return false;
}

function clientCreateButtonClick(){
    
    var clientFirstName = $('input#clientFirstName').val();
    var clientSurname = $('input#clientSurname').val();
    var clientAddress = $('input#clientAddress').val();
    var clientSuburb = $('input#clientSuburb').val();
    var clientState = $('input#clientState').val();
    var clientPostcode = $('input#clientPostcode').val();
    var clientCountry = $('input#clientCountry').val();
    var clientCompany = $('input#clientCompany').val();
    var clientPhoneNum = $('input#clientPhoneNum').val();
    var clientEmail = $('input#clientEmail').val();
    
    $.post( "php/client/createClient.php", {
        clientFirstName: clientFirstName, 
        clientSurname: clientSurname, 
        clientAddress: clientAddress, 
        clientSuburb: clientSuburb, 
        clientState: clientState, 
        clientPostcode: clientPostcode, 
        clientCountry: clientCountry, 
        clientCompany: clientCompany, 
        clientPhoneNum: clientPhoneNum, 
        clientEmail: clientEmail
    },
    function( data ) {
        $('#contentDisplay').html(data);
        $('.clientCreateButton').click(clientCreateButtonClick);
    });
     
    return false;
    
}

function logoutLinkClick() {
    
    // Logout with a logout=1 get to the URL. This tells the index.php page to clear the session.
    window.location = "index.php?logout=1";
    
    return false;
}

function createProductLinkClick() {
        
    // Perform Ajax functions.

    $.post( "php/product/createProduct.php",
        function( data ) {
            $('#contentDisplay').html(data);
            $('.productCreateButton').click(productCreateButtonClick);
        });

    return false;
}

function modifyProductLinkClick() {
    
    $.post( "php/product/modifyProduct.php",
        function( data ) {
            $('#contentDisplay').html(data);
            $('#modifyProduct tr').click(modifyProductRowClick);
            $('#modifyProduct tr').first().unbind();
        });
     
    return false;
}

function modifyProductRowClick() {
    
    var rowID = this.id;
    
    $.post( "php/product/modifyProduct.php", {
        rowID: rowID
    }, 
    function( data ) {
        $('#contentDisplay').html(data);
        $('#modifyProduct tr').click(modifyProductRowClick);
        $('#modifyProduct tr').first().unbind();
        $('.productModifyButton').click(modifyProductButtonClick);
    });
     
    return false;

}

function modifyProductButtonClick () {
    
    var modifyProductName = $('input#modifyProductName').val();
    var modifyProductDesc = $('input#modifyProductDesc').val();
    var modifyProductPrice = $('input#modifyProductPrice').val();
    var modifyProductQty = $('input#modifyProductQty').val();
    var modifyProductID = this.id;
    
    $.post( "php/product/modifyProduct.php", {
        modifyProductName: modifyProductName, 
        modifyProductDesc: modifyProductDesc, 
        modifyProductPrice: modifyProductPrice, 
        modifyProductQty: modifyProductQty, 
        modifyProductID: modifyProductID
    },
    function( data ) {
        $('#contentDisplay').html(data);
        $('#modifyProduct tr').click(modifyProductRowClick);
        $('#modifyProduct tr').first().unbind();
    });
     
    return false;
}

function productCreateButtonClick() {
    
    var productName = $('input#productName').val();
    var productDesc = $('input#productDesc').val();
    var productPrice = $('input#productPrice').val();
    var productQty = $('input#productQty').val();
    
    $.post( "php/product/createProduct.php", {
        productName: productName, 
        productDesc: productDesc, 
        productPrice: productPrice, 
        productQty: productQty
    },
    function( data ) {
        $('#contentDisplay').html(data);
        $('.productCreateButton').click(productCreateButtonClick);
    });

    return false;
}
