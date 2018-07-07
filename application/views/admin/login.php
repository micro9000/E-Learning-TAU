<div class="container">
    <div class="card card-container">
        <img id="profile-img" class="profile-img-card" src="<?php echo base_url("assets/imgs/profile_temp.png"); ?>" />
        <p id="profile-name" class="profile-name-card"></p>
        <form class="form-signin">
        	<p style="text-align:center">
        		Welcome to E-Learning <br/>
        		<b>Admin login</b>
        	</p>
            <span id="reauth-email" class="reauth-email"></span>
            <input type="text" id="inputStdNum" class="form-control faculty_number" placeholder="Faculty number" required autofocus>
            <input type="password" id="inputPassword" class="form-control password" placeholder="Password" required>
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Sign in</button>
        </form><!-- /form -->

        <div class="login-alert">
        	<div class="alert hidden-default"></div>
        	<div class="loader hidden-default"></div>
        </div>
        
    </div><!-- /card-container -->
</div><!-- /container -->