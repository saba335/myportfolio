<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "contact_form_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch data from the enquiry table
$sql = "SELECT id, name, email, message, created_at FROM enquiry";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Enquiry List</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="mt-5">Enquiries</h2>
    <?php
    if ($result->num_rows > 0) {
        echo '<table class="table mt-3">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Name</th>';
        echo '<th>Email</th>';
        echo '<th>Message</th>';
        echo '<th>Created At</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row["id"] . '</td>';
            echo '<td>' . htmlspecialchars($row["name"]) . '</td>';
            echo '<td>' . htmlspecialchars($row["email"]) . '</td>';
            echo '<td>' . htmlspecialchars($row["message"]) . '</td>';
            echo '<td>' . $row["created_at"] . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>No enquiries found.</p>';
    }

    // Close the connection
    $conn->close();
    ?>
</div>
</body>
</html>
