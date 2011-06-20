<body>

    <div id="pageContainer">

        <div id="header">

            <div id="clientLogo">
                <span id="logoImage"><img src="./assets/images/logoTest.png" title="Logo" alt="Logo" /></span>
            </div>
            
            <p class="noMargins"><a id="logoutLink" href="#" title="Logout">Logout</a></p>

        </div>

        <div id="linkContainer">

            <ul class="navBar">
                <li><a class="selected" href="#invoice" title="Invoice">Invoice</a></li>
                <li><a href="#product" title="Product">Product</a></li>
                <li><a href="#client" title="Client">Client</a></li>
                <li><a href="#report" title="Report">Report</a></li>
                <li><a href="#admin" title="Admin">Admin</a></li>
            </ul>

            <form class="searchBar" method="post" action="#">
                <input type="text" size="35" name="searchfield" id="searchfield" value="Search" onfocus="value=''"></input>
                <input id="searchButton" type="submit" value="Search"></input>
            </form>

            <div id="invoice">

                <ul class="invoiceLinks">
                    <li><a id="mostRecentInvoiceLink" href="#" title="Most Recent Invoice">Most Recent Invoice</a></li>
                    <li><a id="createInvoiceLink" href="#" title="Create Invoice">Create Invoice</a></li>
                    <li><a id="pendingInvoicesLink" href="#" title="Pending Invoices">Pending Invoices</a></li>
                </ul>

            </div>

            <div id="product">

                <ul class="productLinks">
                    <li><a id="createProductLink" href="#" title="Create Product">Create Product</a></li>
                    <li><a id="modifyProductLink" href="#" title="Modify Product">Modify Product</a></li>
                    <li><a id="deleteProductLink" href="#" title="Delete Product">Delete Product</a></li>
                </ul>

            </div>

            <div id="client">

                <ul class="clientLinks">
                    <li><a id="createClientLink" href="#" title="Create Client">Create Client</a></li>
                    <li><a id="modifyClientLink" href="#" title="Modify Client">Modify Client</a></li>
                    <li><a id="deleteClientLink" href="#" title="Delete Client">Delete Client</a></li>
                </ul>

            </div>

            <div id="report">

                <ul class="reportLinks">
                    <li><a id="generateReportLink" href="#" title="Generate Report">Generate Report</a></li>
                </ul>

            </div>

            <div id="admin">

                <ul class="adminLinks">
                    <li><a id="manageBusinessLink" href="#" title="Manage Business">Manage Business</a></li>
                    <li><a id="changePasswordLink" href="#" title="Change Password">Change Password</a></li>
                    <li><a id="addUserLink" href="#" title="Add User">Add User</a></li>
                    <li><a id="deleteUserLink" href="#" title="Delete User">Delete User</a></li>
                </ul>

            </div>

        </div>

        <div id="contentDisplay">

        </div>

    </div>

</body>
