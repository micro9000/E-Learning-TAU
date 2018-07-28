
<div class="container">
    <div class="card card-container">

        <form class="form-signin">
        	<p style="text-align:center">Student Registration</p>

            <input type="text" class="form-control inputFld student_number" placeholder="Student number" required autofocus>

            <input type="text" class="form-control inputFld emailAdd" placeholder="Email" required>

            <input type="text" class="form-control inputFld firstName" placeholder="Firstname" required>

            <input type="text" class="form-control inputFld lastName" placeholder="Lastname" required>

            <input type="password" class="form-control inputFld password" placeholder="Password" required>

            <input type="password" class="form-control inputFld confirmPassword" placeholder="Confirm Password" required>

            <button class="btn btn-lg btn-primary btn-block btn-register" type="submit">Submit</button>
        </form>

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