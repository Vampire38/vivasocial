<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

    // File upload handling
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;

    // Check if image is a valid image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    if ($uploadOk && move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $description = $conn->real_escape_string($_POST['description']);
        $image_path = $conn->real_escape_string($target_file);

        // Insert into database
        $sql = "INSERT INTO images (image_path, description) VALUES ('$image_path', '$description')";
        if ($conn->query($sql) === TRUE) {
            echo "Image and description uploaded successfully.";
            header('Location: index.html');
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }

    $conn->close();
} else {
    echo "Invalid request method.";
}
?>