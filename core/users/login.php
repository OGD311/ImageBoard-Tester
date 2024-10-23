<?php

require_once '../../config.php';

if (isset($_SESSION['user_id'])) {
    header('Location: ../../main.php');
    exit();
}


$is_invalid = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $mysqli = $_DB;

    $sql = sprintf("SELECT * FROM users WHERE username = '%s' ", $mysqli->real_escape_string($_POST['username']));

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    if ($user) {
        if (password_verify($_POST['password'], $user['password_hash'])) {
            
            session_start();

            session_regenerate_id();

            $_SESSION['user_id'] = $user['id'];

            header('Location: ../main.php');

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
        <meta charset="UTF-8">
        <?php include '../html-parts/header-elems.php' ?> 
    </head>

    <body>
        <?php include '../html-parts/nav.php'; ?>


        <h1>Login</h1>

        <form method='post' class="user-form">
            
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
        
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
            
            <button>Login</button>


        </form>

        <?php if ($is_invalid) : ?>
            <em style="color: red">Invalid login</em>
        <?php endif; ?>
        


        <p>Don't have an account? <a href='signup.php'>Sign up</a></p>
    
        <?php include '../html-parts/footer.php'; ?>
    </body>

</html>