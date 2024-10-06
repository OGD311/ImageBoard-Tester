<?php

require_once '../config.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchInput = isset($_POST['search']) ? $_POST['search'] : '';

    header('Location: /core/main.php?search=' . htmlspecialchars($searchInput) .'');

} 