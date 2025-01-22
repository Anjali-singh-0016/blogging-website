
<?php if (isset($_SESSION['error'])): ?>
    <div class="error-msg">
        <?php 
            echo $_SESSION['error']; 
            unset($_SESSION['error']); 
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
            <section class=" login section">
                <h2>Login to BlogVault</h2>
                <form id="loginForm" method="POST" action="process_login.php">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    </div>
                    <button type="submit" class="btn">Login</button>
                    <p>or</p>
                    <button id="googleLogin" class="btn google-btn">Login with Google</button>
                </form>
            </section>
    </div>
    
    <?php include('footer.php'); ?>
    <script src="./JS/action.js"></script>
</body>
</html>


