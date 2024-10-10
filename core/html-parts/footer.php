<?php
echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>';

$result = $mysqli->query('SHOW GLOBAL STATUS;', MYSQLI_USE_RESULT);

while ($row = $result->fetch_assoc()) {

    $statistics[$row['Variable_name']] = $row['Value'];

}

$result->close();

echo '<div class="container-fluid justify-content-center text-center">';
echo '<span>';
echo "Total Queries: " . $statistics['Questions'] . " ";
echo "Slow Queries: " . $statistics['Slow_queries'] . " ";
echo "Total Connections: " . $statistics['Connections'] . "";
echo '</span>';
echo '</div>';