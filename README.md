Foodeventeny Festival Application Management System
OVERVIEW
The Foodeventeny Festival Application Management System is a web-based application designed to handle applications for various types of participants in the Foodeventeny Festival. This system allows applicants to submit their applications and check their status, while organizers can manage application types, update statuses, and view application details.

Features
Applicant Portal:

Submit applications for various types.
Check the status of submitted applications.
Organizer Portal:

Create new application types.
Update application statuses.
View and manage applications and applicants.




Certainly! I'll add steps to run the application to the README.md file. Here’s the updated version with detailed instructions on running the application:

Foodeventeny Festival Application Management System
Overview
The Foodeventeny Festival Application Management System is a web-based application designed to handle applications for various types of participants in the Foodeventeny Festival. This system allows applicants to submit their applications and check their status, while organizers can manage application types, update statuses, and view application details.

FEATURES
Applicant Portal:

Submit applications for various types.
Check the status of submitted applications.
Organizer Portal:

Create new application types.
Update application statuses.
View and manage applications and applicants.

INSTALLATION 
Prerequisites - 
1.PHP (>= 7.0)
2.MySQL

SETUP INSTRUCTIONS
1.Clone the Repository
2.Database Configuration
3.Configure Database Connection
4.Upload Files
5.Upload the project files to your web server directory.
6.Access the Application
Open your web browser and navigate to the URL where you have hosted the application.



USAGE
Landing Page - http://localhost:8081/
Select User Type:
Select whether you are a Vendor or an Organizer.
Vendors will be redirected to redirect.php.
Organizers will be redirected to admin.php.
Applicant Portal
Apply for a Vendor Spot:

Navigate to redirect.php after selecting Vendor in index.php.
Fill out the form with your name, email, and select an application type.
Submit the application via submit_application.php.
Check Application Status:

Navigate to applicant.php.
Enter your name and email in the status check form.
View the status of your application retrieved via get_application.php.
Organizer Portal
Create Application Types:

Navigate to admin.php.
Fill out the form with the title, description, and deadline of the application type.
Submit to create a new application type.
Update Application Status:

Navigate to admin.php.
Select an application and update its status.
View Applications:

Navigate to admin.php.
Select an application type and view the list of applicants or applications.

FILE STRUCTURE
db.php - Database connection script.
application.php - Functions for handling application types and statuses.
admin.php - Admin interface for managing application types and viewing applications.
index.php - Main landing page for selecting user type (Vendor or Organizer).
redirect.php - Redirects the user based on their selection in index.php.
submit_application.php - Script to handle the submission of new applications.
applicant.php - Applicant interface for submitting applications and checking status.
get_application.php - Script to retrieve application details.
form-handler.js - JavaScript for handling form submissions and AJAX requests (if applicable).
css/styles.css - CSS styles for the application.
