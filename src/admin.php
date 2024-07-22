<?php
include 'db.php';
include 'application.php';

$isOrganizer = true;

// Initialize variables for dropdown selection
$selectedType = '';
$viewOption = '';
$applicants = [];
$applications = [];

// Handle form submissions for creating new application types, updating statuses, and viewing data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create_application_type'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $deadline = $_POST['deadline'];

        // Call createApplicationType without a cover photo
        createApplicationType($title, $description, $deadline, null);
    } elseif (isset($_POST['update_status'])) {
        $id = $_POST['id'];
        $status = $_POST['status'];
        updateApplicationStatus($id, $status);
    } elseif (isset($_POST['view_data'])) {
        $selectedType = $_POST['application_type'];
        $viewOption = $_POST['view_option'];


        if ($viewOption == 'applicants') {
            $applicants = getApplicantsByTypeName($selectedType);
        } elseif ($viewOption == 'applications') {
            $applications = getApplicationsByTypeName($selectedType);
        }
    }
}

// Fetch all application types
$applicationTypes = getApplicationTypes();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Interface</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Admin Interface</h1>

    <!-- Create Application Type Section -->
    <h1>Welcome, Organizer! This is your dashboard where you can manage applications and make decisions.</h1>
    <h2 style="color:red;">Organizer Dashboard</h2>
    <form method="post">
        <input type="text" name="title" placeholder="Title" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <input type="date" name="deadline" placeholder="Deadline" required> 
        <button type="submit" name="create_application_type">Create Application Type</button>
    </form>

    <!-- View Data Section -->
    <h2>View Data</h2>
    <form method="post">
        <label for="application_type">Select Application Type:</label>
        <select name="application_type" id="application_type" required>
            <?php foreach ($applicationTypes as $type): ?>
                <option value="<?php echo htmlspecialchars($type['title']); ?>"><?php echo htmlspecialchars($type['title']); ?></option>
            <?php endforeach; ?>
        </select>
        <label for="view_option">Select View Option:</label>
        <select name="view_option" id="view_option" required>
            <option value="applicants">Applicants</option>
            <option value="applications">Applications</option>
        </select>
        <button type="submit" name="view_data">Select</button>
    </form>

    <!-- Display Data Based on Selection -->
    <?php if ($viewOption == 'applicants'): ?>
        <h2>Applicants for "<?php echo htmlspecialchars($selectedType); ?>"</h2>
        <ul>
            <?php if (!empty($applicants)): ?>
                <?php foreach ($applicants as $applicant): ?>
                    <li><?php echo htmlspecialchars($applicant['applicant_name']); ?></li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No applicants found for this application type.</li>
            <?php endif; ?>
        </ul>
    <?php elseif ($viewOption == 'applications'): ?>
        <h2>Applications for "<?php echo htmlspecialchars($selectedType); ?>"</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Application Type Name</th>
                    <th>Applicant Name</th>
                    <th>Applicant Email</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($applications)): ?>
                    <?php foreach ($applications as $application): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($application['id']); ?></td>
                            <td><?php echo htmlspecialchars($application['application_type_name']); ?></td>
                            <td><?php echo htmlspecialchars($application['applicant_name']); ?></td>
                            <td><?php echo htmlspecialchars($application['applicant_email']); ?></td>
                            <td><?php echo htmlspecialchars($application['status']); ?></td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($application['id']); ?>">
                                    <select name="status">
                                        <option value="approved" <?php if ($application['status'] == 'approved') echo 'selected'; ?>>Approve</option>
                                        <option value="waitlisted" <?php if ($application['status'] == 'waitlisted') echo 'selected'; ?>>Waitlist</option>
                                        <option value="rejected" <?php if ($application['status'] == 'rejected') echo 'selected'; ?>>Reject</option>
                                    </select>
                                    <button type="submit" name="update_status">Update Status</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No applications found for this application type.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
