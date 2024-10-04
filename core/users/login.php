<?php
require_once '../../config.php';


$is_invalid = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $mysqli = $_DBPATH;

    $sql = sprintf("SELECT * FROM users WHERE username = '%s' ", $mysqli->real_escape_string($_POST['username']));

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    if ($user) {
        if (password_verify($_POST['password'], $user['password_hash'])) {
            
            session_start();

            session_regenerate_id();

            $_SESSION['user_id'] = $user['id'];

            header('Location: ../index.php');

            exit;
        
        }
    }

    $is_invalid = true;
}


?>



<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
        <meta charset="UTF-8">
        <?php include '../html-parts/header-elems.php' ?>
    </head>

    <body>
        <?php include '../html-parts/nav.php'; ?>


        <h1>Login</h1>

        <form method='post'>
            
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
        
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
            
            <button>Login</button>

        </form>

        <?php if ($is_invalid) : ?>
            <em style="color: red">Invalid login</em>
        <?php endif; ?>
        


        <p>Don't have an account? <a href='signup.html'>Sign up</a></p>
    
        <?php include '../html-parts/footer.php'; ?>
    </body>

</html>