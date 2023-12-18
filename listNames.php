<?php
include 'connection.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Retrieve names from the database
$stmt = $conn->prepare("SELECT username FROM chatTable");
$stmt->execute();
$stmt->bind_result($username);

echo "<ul>";

while ($stmt->fetch()) {
    echo "<li>" . $username . "</li>";
}

echo "</ul>";

$stmt->close();
$conn->close();
?>
