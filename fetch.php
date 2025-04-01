<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vivadb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from database
$sql = "SELECT image_path, description FROM images ORDER BY created_at DESC";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Return JSON data
header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
?>
