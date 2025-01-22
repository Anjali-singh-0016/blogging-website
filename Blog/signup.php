
<?php
session_start();
 if (isset($_SESSION['error'])): ?>
    <div class="error-msg">
        <?php 
            echo $_SESSION['error']; 
            unset($_SESSION['error']); 
        ?>
    </div>
<?php elseif (isset($_SESSION['success'])): ?>
    <div class="success-msg">
        <?php 
            echo $_SESSION['success']; 
            unset($_SESSION['success']); 
        ?>
    </div>
<?php endif; ?>

<?php include('header.php'); ?>
<html>
    <head>
    <style>
            .footer{
                position: fixed;
                bottom: 0;
                width: 100%;
            }
        </style>
    </head>
    <body>
    <div class="auth-div">
<section class="signup section">
    <h2>Create an Account</h2>
    <form id="signupForm" method="post" action="process_signup.php">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Enter your name" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Create a strong password" required>
        </div>
        <div class="form-group">
            <label for="confirmPassword">Confirm Password</label>
            <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required>
        </div>
        <button type="submit" class="btn">Sign Up</button>
        <p>or</p>
        <button id="googleSignup" class="btn google-btn">Sign Up with Google</button>
    </form>
</section>
</div>
    </body>
</html>

<?php include('footer.php'); ?>
