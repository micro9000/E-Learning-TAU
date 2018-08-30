
<div class="container">
    <div class="card card-container">

        <div class="form-signin">
        	<p style="text-align:center">Student Registration</p>

            <input type="text" class="form-control inputFld student_number" placeholder="Student number" required autofocus>

            <input type="text" class="form-control inputFld emailAdd" placeholder="Email" required>

            <input type="text" class="form-control inputFld firstName" placeholder="Firstname" required>

            <input type="text" class="form-control inputFld lastName" placeholder="Lastname" required>

            <input type="password" class="form-control inputFld password" placeholder="Password" required>

            <input type="password" class="form-control inputFld confirmPassword" placeholder="Confirm Password" required>

            <button class="btn btn-lg btn-primary btn-block btn-register" data-toggle="modal" data-target="#privacy_notice_modal" type="submit">Submit</button>
        </div>

        <div class="login-alert">
        	<div class="alert registration-msg hidden-default"></div>
        	<div class="loader hidden-default"></div>
        </div>

        <p>Registered? 
        <a href="<?php echo base_url("student_login_page"); ?>" class="forgot-password">
            Login here
        </a></p>

    </div>
</div>


<!-- Add Quizes -->
<div class="modal fade" id="privacy_notice_modal" tabindex="-1" role="dialog" aria-labelledby="privacy_notice_modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Privacy Policy</h5>
                <button type="button" class="close btn-close-advance-search" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="font-size: 12px;">

                            <strong>ELearning Privacy Policy</strong><br/><br/>

                            This Privacy Policy was last modified on August 30, 2018. <br/><br/>

                            This inform you of our policies regarding the collection, use and 
                            disclosure of Personal Information we receive from users of this Site.<br/><br/>

                            Here at <strong>ELearning</strong> we take your privacy seriously and will only use your personal information
                            to administer your account and to provide the sevices you have requested from us. <br/> <br/>

                            We use your Personal Information only for providing and improving the Site. By using the Site,
                            you agree to the collection and use of information in accordance with this policy. <br/> <br/>

                            <strong>Information Collection And Use</strong><br/>
                            While using our Site, we may ask you to provide us with certain personally identifiable information
                            that can be used to contact or identify you. Personally identifible information may include, but is
                            not limited to your name ("Personal Information").<br/> <br/>

                            <strong>What type of information is collected from you?</strong> <br/>
                            The Personal Information we collect might include your name, email address, IP address.
                            Like many site operators, we collect information that your browser sends whenever you visit our Site ("Log Data").
                            This Log Data may include information such as your computer's Internet Protocols ("IP") address, browser
                            type, browser version, the pages of our Site that you visit, the time and date your visit, the time
                            spent on those pages and other statistics.

                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="font-size: 12px;">
                            <br/><br/>
                            <div class="alert registration-msg hidden-default"></div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-disagree" data-dismiss="modal">I disagree</button>
                <button type="button" class="btn btn-primary btn-agree-to-collec-pr-info">I agree</button>
            </div>
        </div>
    </div>
</div>

<div class="loader_blocks"></div>