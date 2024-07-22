-- Table to store application types
CREATE TABLE IF NOT EXISTS application_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL UNIQUE,  -- Ensure title is unique
    description TEXT NOT NULL,
    deadline DATE NOT NULL,
    cover_photo VARCHAR(255) NULL
);

-- Table to store applications
CREATE TABLE IF NOT EXISTS application (
    id INT AUTO_INCREMENT PRIMARY KEY,
    application_type_name VARCHAR(255) NOT NULL,  -- Changed to VARCHAR
    applicant_name VARCHAR(255) NOT NULL,
    applicant_email VARCHAR(255) NOT NULL,
    status ENUM('pending', 'approved', 'waitlisted') DEFAULT 'pending',
    FOREIGN KEY (application_type_name) REFERENCES application_types(title)  -- Foreign key reference to title
);

-- Table to store applicants
CREATE TABLE IF NOT EXISTS applicants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    application_id INT NOT NULL,
    FOREIGN KEY (application_id) REFERENCES application(id)  -- Corrected foreign key reference
);
