<?php 
require_once 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/static/css/navbar.css">
    <link rel="stylesheet" href="/static/css/details.css">
    <script src="/static/js/add-to-search.js" type="module"></script>
    <script src="/static/js/hide-page.js"></script>
    <script src="/static/js/cookie.js" type="module"></script>

</head>

<body>

    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="border border-black p-4 text-center">
            <p>You must be over the age of 18 and agree to the <a href="#" class="text-blue">terms and conditions</a> to access this page.</p>
            <button id="agreeBtn" class="btn btn-success ">
                I agree to the <a href="#" class="text-white">terms and conditions</a>
            </button>
            <button id="disagreeBtn" class="btn btn-secondary">
                I do not agree to the <a href="#" class="text-white">terms and conditions</a>
            </button>
        </div>
    </div>
   


    <script type="module">
        import { setCookie } from '/static/js/cookie.js'; 

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
