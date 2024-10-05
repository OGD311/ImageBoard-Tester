<?php 
require_once 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="/core/static/js/hide-page.js"></script>
    <script type="module">
        import'/core/static/js/cookie.js'; 
    </script>
</head>

<body>
   
    <div class="container-fluid text-center justify-content-center">
        <button id="agreeBtn">
            I agree to the <a href="#">terms and conditions</a>
        </button>
        <button id="disagreeBtn">
            I do not agree to the <a href="#">terms and conditions</a>
        </button>
    </div>


    <script type="module">
        import { setCookie } from '/core/static/js/cookie.js'; 

        window.agree = function() {
            setCookie('ageCheck', 'agree'); 
            window.location.href = 'index.php';
        };

        window.disagree = function() {
            setCookie('ageCheck', 'disagree'); 
            window.location.replace('https://www.google.com');
        };

        document.getElementById('agreeBtn').onclick = agree;
        document.getElementById('disagreeBtn').onclick = disagree;
    </script>


<?php include 'core/html-parts/footer.php'; ?>
</body>
</html>
