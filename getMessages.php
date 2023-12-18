<?php
include 'connection.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $otherUser = isset($_GET['otherName']) ? $_GET['otherName'] : '';

    if ($otherUser !== "") {
        $sql = "SELECT chatContent FROM chatTable WHERE username='$otherUser'";
        $result = $conn->query($sql);

        if ($result !== false) {
            // Fetch the data from the result set
            $row = $result->fetch_assoc();

            if ($row !== null) {
                // Output the chat content
                echo json_encode(['chatContent' => $row['chatContent']]);
            } else {
                echo "No messages found for the specified name.";
            }
        } else {
            echo "Database error: " . $conn->error;
        }
    } else {
        echo "Please enter a name to listen to.";
    }

    // Debugging line

}

?>
