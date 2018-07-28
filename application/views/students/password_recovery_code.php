
<div class="container">
    <div class="card card-container">

        <form class="form-recover-password form-submit-pswd-recovery-code">
        	<p style="text-align:center">Enter your recovery code</p>

            <p>Please visit your email account and enter the recovery code</p>

            <input type="text" id="inputRecoveryCode" class="form-control recovery-code" maxlength="6" placeholder="Code" required autofocus>

            <button class="btn btn-lg btn-primary btn-block btn-submit-recovery-code" type="submit">Submit</button>
        </form>

        <div class="login-alert">
        	<div class="alert recovery-code-msg hidden-default"></div>
        	<div class="loader hidden-default"></div>
        </div>
        
    </div>
</div>