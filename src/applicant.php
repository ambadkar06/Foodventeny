<?php
include 'db.php';

// Submit applicant information
function submitApplication($name, $email, $applicationId) {
    global $conn;
    if ($conn) {
        $stmt = $conn->prepare("INSERT INTO applicants (name, email, application_id) VALUES (:name, :email, :application_id)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':application_id', $applicationId, PDO::PARAM_INT);
        $stmt->execute();
    } else {
        echo "Database connection is not established.";
    }
}

// Get applicants by application ID
function getApplicants($applicationId) {
    global $conn;
    if ($conn) {
        $stmt = $conn->prepare("SELECT * FROM applicants WHERE application_id = :application_id");
        $stmt->bindParam(':application_id', $applicationId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        echo "Database connection is not established.";
        return [];
    }
}
?>
