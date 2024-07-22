<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once 'db.php'; // Ensure this file contains $conn for PDO connection

// Initialize variables
$applicationStatus = [];

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_application'])) {
        $applicantName = $_POST['name'];
        $applicantEmail = $_POST['email'];
        $applicationTypeName = $_POST['application_type_name'];

        try {
            // Validate application type name
            $sql = "SELECT COUNT(*) FROM application_types WHERE title = :application_type_name";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':application_type_name', $applicationTypeName, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetchColumn();

            if ($count == 0) {
                throw new Exception('Invalid application type name.');
            }

            // Insert into application table
            $sql = "INSERT INTO application (application_type_name, applicant_name, applicant_email) 
                    VALUES (:application_type_name, :applicant_name, :applicant_email)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':application_type_name', $applicationTypeName, PDO::PARAM_STR);
            $stmt->bindParam(':applicant_name', $applicantName, PDO::PARAM_STR);
            $stmt->bindParam(':applicant_email', $applicantEmail, PDO::PARAM_STR);
            $stmt->execute();

            // Get the last inserted ID
            $applicationId = $conn->lastInsertId();

            // Insert into applicants table
            $sql = "INSERT INTO applicants (name, email, application_id) 
                    VALUES (:name, :email, :application_id)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $applicantName, PDO::PARAM_STR);
            $stmt->bindParam(':email', $applicantEmail, PDO::PARAM_STR);
            $stmt->bindParam(':application_id', $applicationId, PDO::PARAM_INT);
            $stmt->execute();

            echo "Application submitted successfully.";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    } elseif (isset($_POST['check_status'])) {
        // Handle status check
        $name = $_POST['check_name'];
        $email = $_POST['check_email'];

        try {
            // Prepare and execute the SQL query to check application status
            $sql = "SELECT a.id, a.applicant_name, a.applicant_email, a.status, a.application_type_name
                    FROM application a
                    WHERE a.applicant_name = :name AND a.applicant_email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            $application = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($application) {
                $applicationStatus = $application;
            } else {
                $applicationStatus = ['status' => 'No application found'];
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

// Fetch application types for the dropdown
try {
    $sql = "SELECT * FROM application_types";
    $stmt = $conn->query($sql);
    $applicationTypes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foodeventeny Festival</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="form-handler.js" defer></script>
</head>
<body>
    <h1>Welcome to the applicant section of Foodventeny. Here you can view and apply for various opportunities.</h1>
    <h1 style="color:red;">Foodeventeny Festival</h1>
    
    <h2>Apply for a Vendor Spot</h2>
    <form method="POST" action="submit_application.php">
        <label for="application_type_name">Select Application Type:</label>
        <select name="application_type_name" id="application_type_name" required>
            <option value="">Select an Application Type</option>
            <?php foreach ($applicationTypes as $type): ?>
                <option value="<?php echo htmlspecialchars($type['title']); ?>">
                    <?php echo htmlspecialchars($type['title']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <input type="submit" name="submit_application" value="Submit">
    </form>

    <h2>Check Your Application Status</h2>
    <form id="checkStatusForm" method="post">
        <input type="text" id="check_name" name="check_name" placeholder="Name" required>
        <input type="email" id="check_email" name="check_email" placeholder="Email" required>
        <button type="submit" name="check_status">Check Status</button>
    </form>

    <?php if (!empty($applicationStatus)): ?>
        <h3>Application Status</h3>
        <?php if (isset($applicationStatus['status']) && $applicationStatus['status'] === 'No application found'): ?>
            <p>No application found with the provided details.</p>
        <?php else: ?>
            <p><strong>Application ID:</strong> <?php echo htmlspecialchars($applicationStatus['id']); ?></p>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($applicationStatus['applicant_name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($applicationStatus['applicant_email']); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($applicationStatus['status']); ?></p>
            <p><strong>Application Type:</strong> <?php echo htmlspecialchars($applicationStatus['application_type_name']); ?></p>
        <?php endif; ?>
    <?php endif; ?>

    <script>
    document.getElementById('applicationSelect').addEventListener('change', function() {
        const id = this.value;
        if (id) {
            fetch(`get_application.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('applicationDetails').innerHTML = `
                        <h3>${data.title}</h3>
                        <p>${data.description}</p>
                    `;
                });
        } else {
            document.getElementById('applicationDetails').innerHTML = '';
        }
    });
    </script>
</body>
</html>
