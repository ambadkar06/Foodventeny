<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_application'])) {
        $applicantName = $_POST['name'];
        $applicantEmail = $_POST['email'];
        $applicationTypeName = trim($_POST['application_type_name']);  // Ensure trimming of any extra spaces

        // Debugging output
        echo "Submitted application type name: " . htmlspecialchars($applicationTypeName) . "<br>";

        try {
            // Start a transaction
            $conn->beginTransaction();

            // Check if the application type name exists in the application_types table
            $sql = "SELECT title FROM application_types WHERE title = :application_type_name";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':application_type_name', $applicationTypeName, PDO::PARAM_STR);
            $stmt->execute();

            // Fetch the result
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                // Insert into application table
                $sql = "INSERT INTO application (application_type_name, applicant_name, applicant_email, status) 
                        VALUES (:application_type_name, :applicant_name, :applicant_email, 'pending')";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':application_type_name', $applicationTypeName, PDO::PARAM_STR);
                $stmt->bindParam(':applicant_name', $applicantName, PDO::PARAM_STR);
                $stmt->bindParam(':applicant_email', $applicantEmail, PDO::PARAM_STR);
                $stmt->execute();

                // Get the last inserted application ID
                $applicationId = $conn->lastInsertId();

                // Insert into applicants table
                $sql = "INSERT INTO applicants (name, email, application_id) 
                        VALUES (:name, :email, :application_id)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':name', $applicantName, PDO::PARAM_STR);
                $stmt->bindParam(':email', $applicantEmail, PDO::PARAM_STR);
                $stmt->bindParam(':application_id', $applicationId, PDO::PARAM_INT);
                $stmt->execute();

                // Commit the transaction
                $conn->commit();

                echo "Application submitted successfully.";
            } else {
                throw new Exception("Invalid application type name.");
            }
        } catch (PDOException $e) {
            // Rollback if there's an error
            $conn->rollBack();
            echo "Error: " . $e->getMessage();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
