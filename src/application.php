<?php
include 'db.php'; 

// Function to create a new application type

function createApplicationType($title, $description, $deadline = '2024-12-31', $coverPhoto = null) {
    global $conn; 

    try {
        $query = "INSERT INTO application_types (title, description, deadline,cover_photo) VALUES (:title, :description, :deadline, :cover_photo)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':deadline', $deadline, PDO::PARAM_STR);
         // Handle NULL value for cover_photo
        if ($coverPhoto === null) {
            $stmt->bindValue(':cover_photo', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindParam(':cover_photo', $coverPhoto, PDO::PARAM_STR);
        }
        $stmt->execute();
        echo "Application type created successfully.";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}






// Function to get all application types
function getApplicationTypes() {
    global $conn;
    if ($conn) {
        $stmt = $conn->prepare("SELECT title FROM application_types");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        echo "Database connection is not established.";
        return [];
    }
}

// Function to create a new application (applicant submission)
function submitApplication($applicationTypeName, $name, $email) {
    global $conn;
    if ($conn) {
        try {
            $stmt = $conn->prepare("INSERT INTO applications (application_type_id, applicant_name, applicant_email) VALUES (:application_type_id, :applicant_name, :applicant_email)");
            $stmt->bindParam(':application_type_name', $applicationTypeName, PDO::PARAM_STR);
            $stmt->bindParam(':applicant_name', $name);
            $stmt->bindParam(':applicant_email', $email);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Database connection is not established.";
    }
}

// Function to get applicants by application type name
function getApplicants($applicationTypeName) {
    global $conn;
    if ($conn) {
        try {
            // Prepare and execute the query to get applicants based on the application type name
            $stmt = $conn->prepare("
                SELECT 
                    a.id,
                    a.application_type_name,
                    a.applicant_name,
                    a.applicant_email,
                    a.status,
                    at.description,
                    at.deadline,
                    at.cover_photo
                FROM 
                    application a
                JOIN 
                    application_types at
                ON 
                    a.application_type_name = at.title
                WHERE 
                    a.application_type_name = :application_type_name
            ");
            $stmt->bindParam(':application_type_name', $applicationTypeName, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    } else {
        echo "Database connection is not established.";
        return [];
    }
}


// Function to update the status of an application
function updateApplicationStatus($id, $status) {
    global $conn;

    // Valid status values
    $validStatuses = ['pending', 'approved', 'waitlisted'];

    if ($conn) {
        if (in_array($status, $validStatuses)) {
            $stmt = $conn->prepare("
                UPDATE application
                SET status = :status
                WHERE id = :id
            ");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':status', $status);
            $stmt->execute();
        } else {
            echo "Invalid status value provided.";
        }
    } else {
        echo "Database connection is not established.";
    }
}

function checkApplicationStatus($name, $email, $conn) {
    try {
        $query = "SELECT status FROM applications WHERE applicant_name = :name AND applicant_email = :email";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $status = $stmt->fetchColumn();
        if ($status) {
            return $status;
        } else {
            return "No application found for the provided name and email.";
        }
    } catch (PDOException $e) {
        return "Error: " . $e->getMessage();
    }
}

// Function to get applicants by application type name
function getApplicantsByTypeName($applicationTypeName) {
    global $conn;
    if ($conn) {
        $stmt = $conn->prepare("
            SELECT applicant_name
            FROM application
            WHERE application_type_name = :application_type_name
        ");
        $stmt->bindParam(':application_type_name', $applicationTypeName, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        echo "Database connection is not established.";
        return [];
    }
}

// Function to get all applications by application type name
function getApplicationsByTypeName($applicationTypeName) {
    global $conn;
    if ($conn) {
        $stmt = $conn->prepare("
            SELECT * 
            FROM application
            WHERE application_type_name = :application_type_name
        ");
        $stmt->bindParam(':application_type_name', $applicationTypeName, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        echo "Database connection is not established.";
        return [];
    }
}


?>
