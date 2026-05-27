<?php
/**
 * Crafted with love by DevHux
 * Telegram: https://t.me/DevHux
 */
require_once 'config.php';
$db = getDB();
$res = $db->query("DESCRIBE universities");
while($row = $res->fetch_assoc()) {
    echo "Field: " . $row['Field'] . " - Type: " . $row['Type'] . "\n";
}
?>
