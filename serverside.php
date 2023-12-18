<?php
include 'connection.php';
// Database configuration
error_reporting(E_ALL);
ini_set('display_errors', 1);


try {
    // for constant database connection.
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit(); // Exit the script if there's a database connection error
}

// Function to validate username and password
function validateUser($username, $password) {
    global $conn;

    $stmt = $conn->prepare("SELECT username, password FROM chatTable WHERE username = :username AND password = :password");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    return $stmt->rowCount() > 0; // Return true if a matching user is found
}

// Function to update the chatbox in the database
function updateChatbox($username, $chatbox) {
    global $conn;

    $stmt = $conn->prepare("UPDATE chatTable SET chatContent = :chatbox WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':chatbox', $chatbox);
    $stmt->execute();
}

// Function to continuously fetch updates from the database





// Check if the request is a POST (sending data to the server)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the POST request
    if (isset($_POST['name'])) {
        $username = $_POST['name'];
    } else {
        $username = '';
    } 
    if (isset($_POST['password'])) {
        $password = $_POST['password'];
    } else {
        $password = '';
    }
    if (isset($_POST['chatbox'])) {
        $chatbox = $_POST['chatbox'];
    } else {
        $chatbox = '';
    }
    if (isset($_POST['otherName'])) {
        $otherName = $_POST['otherName'];
    } else {
        $otherName = '';
    }


    $username = $_POST['name'];
    $password = $_POST['password'];
    $chatbox = $_POST['chatbox'];
    $otherName = $_POST['otherName'];

    // Debugging: Output received data
    echo "Received POST data - username: $username, password: $password, chatbox: $chatbox, otherName: $otherName<br>";

    // Call the function to validate the user
    $isValidUser = validateUser($username, $password);

    if ($isValidUser) {
        // Debugging: Output validation success
        echo "User validation successful<br>";

        // Call the function to update the chatbox in the database
        updateChatbox($username, $chatbox);
    } else {
        // Debugging: Output invalid user
        echo "Invalid credentials<br>";
    }
} else {
    // Call the function to fetch updates from the database
    $otherUser = isset($_POST['otherName']) ? $_POST['otherName'] : '';

    // Debugging: Output received otherName
    echo "Received otherName: $otherUser<br>";


    // Debugging: Output response
    // Send the retrieved data as the response
}


// Close the database connection
$conn = null;
?>
