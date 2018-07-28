
<div class="container">
    <div class="card card-container">

        <form class="form-recover-password form-submit-recover-password">
        	<p style="text-align:center">Password Recovery</p>
            <span id="reauth-email" class="reauth-email"></span>
            <input type="text" id="inputStdNum" class="form-control student_number" placeholder="Student number" required autofocus>
            <input type="text" id="inputStdEmail" class="form-control student_email" placeholder="Email" required>

            <button class="btn btn-lg btn-primary btn-block btn-submit-for-pswd-recovery" type="submit">Submit</button>
        </form>

        <div class="login-alert">
        	<div class="alert pswd-recovery-msg hidden-default"></div>
        	<div class="loader hidden-default"></div>
        </div>

        <p>Not Registered? 
        <a href="<?php echo base_url("student_registration_page"); ?>" class="forgot-password">
            Register here
        </a></p>
        
    </div><!-- /card-container -->
</div><!-- /container -->