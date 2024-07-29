<?php
session_start();

$uname = $_POST['user'];
$pass = $_POST['psd'];

// Include database connection
require('firstimport.php');

$tbl_name = "users"; // Table name

// Use prepared statements to prevent SQL injection
$sql = "SELECT * FROM $tbl_name WHERE f_name = ? AND password = ?";

if ($stmt = mysqli_prepare($conn, $sql)) {
    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ss", $uname, $pass);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get the result
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) < 1) {
        // Login failed
        $_SESSION['error'] = "1";
        header("Location: login1.php"); // Redirect to login page
        exit();
    } else {
        // Login successful
        $_SESSION['name'] = $uname; // Store username in session
        header("Location: index.php"); // Redirect to index page
        exit();
    }

    // Free result and close statement
    mysqli_free_result($result);
    mysqli_stmt_close($stmt);
} else {
    // Handle error if prepared statement fails
    die("Database query failed: " . mysqli_error($conn));
}

// Close the connection
mysqli_close($conn);

?>
