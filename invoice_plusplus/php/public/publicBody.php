<body>
    <div id="pageContainer">

        <div id="header">

            <h1>Invoice<span class="plusplus">++</span></h1><h2>Your easy online invoicing solution.</h2>

        </div>

        <div id="contentContainer">

            <ul class="contentNavLinks">
                <li><a class="selected" href="#contentAbout" title="About">About</a></li>
                <li><a href="#contentFeatures" title="Features">Features</a></li>
                <li><a href="#contentPricingSignUp" title="Pricing and Sign Up">Pricing &amp; Sign Up</a></li>
                <li><a class="loginLink" href="#contentLogin" title="Login">Login</a></li>
            </ul>

            <div id="contentAbout">

                <h1>Eliminate Expenses!</h1>
                <span class="paperImage"><img src="./assets/images/paper.png" title="Paper Image" alt="Paper Image" /></span>
                <p>Use Invoice++ to migrate your office accounting and document storage to a virtual environment and remove office consumables and storage rent from your expenses!</p>

            </div>

            <div id="contentFeatures">

                <h1>Packed with Goodies!</h1>

                    <ul>
                        <li>Powerful, fully featured invoicing system.</li>
                        <li>Centralised, secure and avaliable all the time.</li>
                        <li>Generated Reports with one click.</li>
                    </ul>

            </div>
            
            <div id="contentContact">
                
                <h3>Contact Us</h3>
                <p>Email: <a href="mailto:superfake@email.com" title="Email">superfake@email.com</a></p>
                <p>Phone: +61 468 124568</p>
                <p>Address:<br />
                123 Lane Street<br />
                Villetown QLD 4000</p>
                
            </div>

            <div id="contentPrivacy">

                <h3>Collection of Information</h3>
                <p>Information that is entered into Invoice++ will be processed by the server through our secure connection. Information will be collected through the traditional method of posting to the server via forms.
                    Information collected will be user details such as, name, address, email address, credit card details and in the Invoice++ web app, invoice information will be collected, this includes but isn’t limited to, account details, money figures, business details, invoice details, customer details and product details.</p>

                <h3>Storage of Information</h3>
                <p>Information collected from the user will be stored in a secure database. A user’s personal details are only available to that user and administrators.  Credit card details aren’t available to anyone except the system itself and can only be used when a user purchases something through the system. The user will have the choice to delete his credit card details from the system when they wish, however personal information and account details cannot be deleted unless an administrator deletes it.</p>

                <h3>Usage</h3>
                <p>The user’s personal information will be used for statistical evaluation and for use with logging into the Invoice++ system. The statistical evaluation will be used purely for marketing study and no private information will be released.<br /> 
                    Information entered by the user in the client side of the website such as invoice information, payments, account details, customer account details and client personal information will be used at the responsibility of the client, the Invoice++ development team will not access this information unless specifically told to by the client.
                    Client information will NOT be used for advertising in any way.</p>

                <h3>Access</h3>
                <p>All information can be accessed by the Invoice++ development team; this does not mean that the development team will access the information at their own will. If there is an issue with the information, a client needs to inform the development team and specific technicians will be assigned to the repair job. 
                    As for client access, the access is split into categories where an Admin will have the highest possible access to a database, which includes the ability to delete any and all information from a database. There is usually one administrator user for a database. An Admin can add users to the database and set security policies to those users as they see fit. It is the admin’s responsibility to choose and assign security policies to users.</p>

                <h3>Third Party Cookies and Sessions</h3>
                <p>Due to the high use of money handling and customer information in Invoice++, cookies will not be saved on a computer during a client session. Only sessions will be used to store and keep track of information during a work session. Sessions are deleted once the browser is closed.</p>


            </div>

            <div id="contentPricingSignUp">

                <h1>One Time Payment</h1>
                <p>$39.99AUD for the entire package.</p>
                <p>No hidden monthly fees! If you're not happy with it, get a refund at anytime!</p>
                <div id="signUpButton"><a href="#signUp" title="Sign Up">Sign Up</a></div>

            </div>

            <div id="contentLogin">

                <form class="loginForm" method="post" action="#">
                    <h2>E-Mail Address</h2>
                    <p><input class="textfield" id="loginName" name="loginName" type="text" size="50"></input></p>
                    <h2>Password</h2>
                    <p><input class="textfield" id="loginPassword" name="loginPassword" type="password" size="50"></input></p>
                    <p><input class="loginButton" name="submit" type="submit" value="Login"></input></p>
                    <p class="forgotDetails"><a id="forgotPasswordLink" href="#" title="Forgot Password">Forgot Password</a></p>
                </form>
                
                <div id="conRes">
                    
                </div>

            </div>

            <div id="signUp">

                <form class="signUpForm" method="post" action="#" id="signUpId">
                    <p style="padding: 0;">Please fill out the form; remember your purchase is 100% refundable:</p>             
                    <ul class="leftSignUp">
                        <li><label for="firstName">First Name </label><input class="required" type="text" size="20" id="firstName" name="firstName"></input></li>
                        <li><label for="surname">Surname </label><input class="required" type="text" size="20" id="surname" name="surname"></input></li>
                        <li><label for="address">Address </label><input class="required" type="text" size="20" id="address" name="address"></input></li>
                        <li><label for="suburb">Suburb </label><input class="required" type="text" size="20" id="suburb" name="suburb"></input></li>
                        <li><label for="state">State </label><input class="required" type="text" size="10" id="state" name="state"></input></li>
                        <li><label for="postcode">Postcode </label><input class="required" type="text" size="10" id="postcode" name="postcode"></input></li>
                        <li><label for="country">Country </label><input class="required" type="text" size="20" id="country" name="country"></input></li>
                        <li><label for="email">Email </label><input class="required" type="text" size="20" id="email" name="email"></input></li>
                    </ul>

                    <ul class="rightSignUp">
                        <li><label for="ccNumber">Credit Card No. </label><input class="required" type="text" size="20" id="ccNumber" name="ccNumber"></input></li>
                        <li><label for="ccName">Name on Card </label><input class="required" type="text" size="20" id="ccName" name="ccName"></input></li>
                        <li><label for="ccv">CCV </label><input class="required" type="text" size="5" id="ccv" name="ccv"></input></li>
                        <li><label for="expiryOne">Expiry </label><input class="required" type="text" size="5" id="expiryOne" name="expiryOne"></input> <input class="required" type="text" size="5" id="expiryTwo" name="expiryTwo"></input></li>
                        <li><input class="signUpButton" type="submit" name="submitSignUp" value="Submit and Start Customising"></input></li>
                    </ul>
                </form>

            </div>

        </div>

        <div id="belowContainer">

            <div id="whyInvoice">

                <h2>Why Invoice++?</h2>
                <p>It's easy to use, fast, cheap and best of all it's in a central location so you can use it in the office and on the road.</p>

            </div>

            <div id="testimonial">

                <h2>Testimonial</h2>
                <p>"This is the easiest and most powerful online invoicing software I've used." - Doug Hugem, Account Manager of NASA</p>

            </div>

        </div>

        <div id="footer">

            <p><a href="#contentContact" title="Contact Us">Contact Us</a> | <a href="#contentPrivacy" title="Privacy">Privacy</a><br />Copyright 2011 STG Web Solutions</p>

        </div>

    </div>

</body>