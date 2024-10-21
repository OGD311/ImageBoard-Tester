<?php
require_once '../config.php';
$mysqli = $_DB;

if (!empty($_POST["search"])) {

    $searchTerm = $_POST["search"] . '%';
    $sql = "SELECT name, count FROM tags WHERE name LIKE ? AND count != 0 ORDER BY count DESC LIMIT " . $_TAGS_ALL_LIMIT;

    $stmt = $mysqli->prepare($sql);
    if ($stmt) {

        $stmt->bind_param("s", $searchTerm);

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) { ?>
                <?php while ($tag = $result->fetch_assoc()) { ?>
                    <li onclick="remove_from_search('<?php echo htmlspecialchars(($_POST["search"])); ?>'); add_to_search('<?php echo htmlspecialchars($tag['name']); ?>', true);">
                        <a class="dropdown-item"><?php echo htmlspecialchars($tag["name"]) . ' (' . htmlspecialchars($tag["count"]) . ')'; ?></a>
                    </li>
                <?php } ?>
        <?php } else { ?>
            <li>
                <a class="dropdown-item">No tags found</a>
            </li>
        <?php }
 

        $stmt->close();
    } else {
        echo '
        <li>
            <a class="dropdown-item">Error preparing statement: ' . $mysqli->error . '</a>
        </li>
        ';
    }
}
?>
