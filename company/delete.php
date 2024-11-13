<?php
session_start();

// Check if the user is logged in as an admin
if (empty($_SESSION['id_company'])) {
    header("Location: index.php");
    exit();
}

// Include database connection
require_once("../db.php");

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    // Validate and sanitize the input
    $id = intval($_GET['id']); // Convert to integer to prevent SQL injection

    // Prepare the SQL statement
    $stmt = $conn->prepare("DELETE FROM mailbox WHERE id_mailbox = ?");
    $stmt->bind_param("i", $id); // Bind the parameter

    // Execute the statement and check for success
    if ($stmt->execute()) {
        // Redirect to companies page on success
        header("Location: mailbox.php");
        exit();
    } else {
        // Handle error
        echo "Error deleting record: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    // Handle the case where 'id' is not provided
    echo "No ID provided for deletion.";
}

// Close the database connection
$conn->close();
?>