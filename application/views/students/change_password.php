
<div class="container">
    <div class="card card-container">

        <form class="form-recover-password form-submit-new-password">
        	<p style="text-align:center">Enter New Password</p>
            <!-- <span id="reauth-email" class="reauth-email"></span> -->
            <input type="password" id="inputPassword" class="form-control password" placeholder="Password" required>
            <input type="password" id="inputPassword" class="form-control confirm_password" placeholder="Confirm Password" required>

            <button class="btn btn-lg btn-primary btn-block btn-change-password" type="submit">Submit</button>
        </form>

        <div class="login-alert">
        	<div class="alert change-pswd-msg hidden-default"></div>
        	<div class="loader hidden-default"></div>
        </div>
    </div><!-- /card-container -->
</div><!-- /container -->