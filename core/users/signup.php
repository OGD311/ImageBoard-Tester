<!DOCTYPE html>
<html>
    <head>
        <title>Signup</title>
        <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js" defer></script>
        <script src="/js/validate.js" defer></script>
        <meta charset="UTF-8">
        
    </head>

    <body>
        <?php include '../html-parts/nav.php'; ?>


        <h1>Signup</h1>

        <form action="process-signup.php" method="post" id="signup">
            <div>
                <label for="username">Username</label>
                <input type="text" id="username" name="username">
            </div>

            <div>
                <label for="password">Password</label>
                <input type="password" id="password" name="password">
            </div>

            <div>
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation">
            </div>

            <button>Sign up</button>
        </form>


        <p>Have an account? <a href='users/login.php'>Login</a></p>
        <?php include '../html-parts/footer.php'; ?>
    </body>
</html>