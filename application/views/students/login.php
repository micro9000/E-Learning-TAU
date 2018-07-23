
<div class="container">
    <div class="card card-container">
        <img id="profile-img" class="profile-img-card" src="<?php echo base_url("assets/imgs/profile_temp.png"); ?>" />
        <p id="profile-name" class="profile-name-card"></p>
        <form class="form-signin">
        	<p style="text-align:center">Welcome to E-Learning</p>
            <span id="reauth-email" class="reauth-email"></span>
            <input type="text" id="inputStdNum" class="form-control student_number" placeholder="Student number" maxlength="10" minlength="10" required autofocus>
            <input type="password" id="inputPassword" class="form-control password" placeholder="Password" required>
            <!-- <div id="remember" class="checkbox">
                <label>
                    <input type="checkbox" value="remember-me"> Remember me
                </label>
            </div> -->
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Sign in</button>
        </form><!-- /form -->

        <div class="login-alert">
        	<div class="alert login-msg hidden-default">asdf</div>
        	<div class="loader hidden-default"></div>
        </div>

        <a href="#" class="forgot-password">
            Forgot the password?
        </a>
        <p>Not Registered? 
        <a href="#" class="forgot-password">
            Register here
        </a></p>
        
    </div><!-- /card-container -->
</div><!-- /container -->