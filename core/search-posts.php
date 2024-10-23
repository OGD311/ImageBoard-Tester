<?php

require_once '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchInput = strtolower($_POST['search']) ?? '';

    // Clean up any trailing or unnecessary dashes
    if (str_contains($searchInput, '-')) {
        $searchInput = preg_replace('/(?<= )- | - | -(?=\s*$)/', '', $searchInput);
    }

    // Handle rating search
    if (preg_match('/rating\s*:\s*\'?(\S+?)\'?/', $searchInput, $matches)) {
        $rating = $matches[1];

        // If rating is not numeric, convert to the corresponding value using a helper function
        if (is_numeric($rating)) {
            $rating = get_rating_text($rating, true);
        }

        // Replace the rating term with its processed value in the search input
        $searchInput = preg_replace('/rating\s*:\s*\'?(\S+?)\'?/', 'rating:' . htmlspecialchars($rating), $searchInput);
    }

    // Replace spaces with plus signs for the URL search parameter
    $search = str_replace(' ', '+', $searchInput);

    // Redirect to the search results page with the processed search query
    header('Location: /core/main.php?search=' . htmlspecialchars($search));
    exit();
}
