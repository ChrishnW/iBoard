<?php
$db_host      = 'localhost';
$db_user      = 'root';
$db_database  = 'ict_asset_inventory';
$db_pass      = '';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_database);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
