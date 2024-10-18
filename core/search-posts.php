<?php

require_once '../config.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchInput = isset($_POST['search']) ? $_POST['search'] : '';

    $rating = '';

    if (str_contains($searchInput, 'rating')) {
        preg_match('/rating\s*:\s*\'?(\S+?)\'?/', $searchInput, $matches);
        
        if (isset($matches[1])) {
            $rating = ($matches[1]);
            if (!is_numeric($matches[1])) {
                $rating = get_rating_value($matches[1]);
            }
            
            $searchInput = preg_replace('/rating\s*:\s*\'?(\S+?)\'?/', 'rating:' . htmlspecialchars($rating) . '', $searchInput);
        }
    }

    $search = str_replace(' ', '+', $searchInput);

    header('Location: /core/main.php?search=' . htmlspecialchars($search));
    exit(); 
}
