<?php
$servername = "localhost";
$username = "root";
$password = ""; // Assuming you allowed connections without a password
$dbname = "url_shortener_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['c'])) {
    $short_code = $_GET['c'];

    // Retrieve original URL from database
    $stmt = $conn->prepare("SELECT long_url, hits FROM short_urls WHERE short_code = ?");
    $stmt->bind_param("s", $short_code);
    $stmt->execute();

    // Fetch result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update hit count
        $row = $result->fetch_assoc();
        $hits = $row['hits'] + 1;
        
        // Update hits in database
        $update_stmt = $conn->prepare("UPDATE short_urls SET hits = ? WHERE short_code = ?");
        $update_stmt->bind_param("is", $hits, $short_code);
        $update_stmt->execute();
        
        // Redirect to original URL
        header("Location: " . $row['long_url']);
        exit();
    } else {
        echo "URL not found.";
    }
} else {
    echo "No short code provided.";
}

$conn->close();
?>
