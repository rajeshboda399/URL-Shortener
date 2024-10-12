<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "url_shortener_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $long_url = filter_var($_POST['url'], FILTER_SANITIZE_URL);
    if (!filter_var($long_url, FILTER_VALIDATE_URL)) {
        die("Invalid URL format.");
    }

    // Check if long URL already exists
    $stmt = $conn->prepare("SELECT short_code FROM short_urls WHERE long_url = ?");
    $stmt->bind_param("s", $long_url);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        // Generate unique short code and ensure no duplicates
        do {
            $short_code = substr(md5(time()), 0, 6);
            $check_stmt = $conn->prepare("SELECT * FROM short_urls WHERE short_code = ?");
            $check_stmt->bind_param("s", $short_code);
            $check_stmt->execute();
            $check_stmt->store_result();
        } while ($check_stmt->num_rows > 0);

        // Insert new URL into the database
        $stmt = $conn->prepare("INSERT INTO short_urls (long_url, short_code) VALUES (?, ?)");
        $stmt->bind_param("ss", $long_url, $short_code);
        $stmt->execute();
    }
}

// Fetch all URLs for display
$stmt = $conn->prepare("SELECT long_url, short_code, hits, created_at FROM short_urls");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>URL Shortener</title>
</head>
<body>
<h1>URL Shortener</h1>
<form method="POST">
    <input type="text" name="url" placeholder="Enter your long URL" required>
    <button type="submit">Shorten</button>
</form>

<h2>Shortened URLs</h2>
<table border="1">
    <tr>
        <th>Long URL</th>
        <th>Short URL</th>
        <th>Hits</th>
        <th>Created At</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><a href="<?php echo htmlspecialchars($row['long_url']); ?>" target="_blank"><?php echo htmlspecialchars($row['long_url']); ?></a></td>
            <td><a href="redirect.php?c=<?php echo htmlspecialchars($row['short_code']); ?>"><?php echo htmlspecialchars($row['short_code']); ?></a></td>
            <td><?php echo htmlspecialchars($row['hits']); ?></td>
            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>

<?php
$conn->close();
?>
