<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($conn) {
        try {
            $stmt = $conn->prepare("SELECT * FROM application_types WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check if data was found
            if ($data) {
                echo json_encode($data);
            } else {
                echo json_encode(['error' => 'No application type found with this ID']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Database connection is not established.']);
    }
} else {
    echo json_encode(['error' => 'ID not provided']);
}
?>
