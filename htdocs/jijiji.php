<?php
$result = $conn->query("SHOW TABLES LIKE 'rate'");
if ($result->num_rows == 0) {
    die("Table 'rate' doesn't exist.");
}
?>