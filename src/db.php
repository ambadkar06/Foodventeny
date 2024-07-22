<?php
$servername = "db"; // Use the container name
$username = "user";
$password = "password";
$database = "foodfestival";

try {
    $conn = new PDO("mysql:host=$servername;port=3306;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
