<?php
// Database connection parameters
$servername = "localhost";  // Replace with your database server
$username = "root";         // Replace with your database username
$password = "";             // Replace with your database password
$dbname = "contact_form_db"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate form data
    if (!empty($name) && !empty($email) && !empty($message) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO enquiry (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);

        // Execute the statement
        if ($stmt->execute()) {
            header("Location: index.html");
        } else {
            echo "<p style='color: red;'>Sorry, something went wrong. Please try again later.</p>";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "<p style='color: red;'>Please fill in all fields correctly.</p>";
    }
} else {
    // Redirect back to the form if the request method is not POST
    header("Location: index.html");
    exit;
}

// Close the connection
$conn->close();
?>

