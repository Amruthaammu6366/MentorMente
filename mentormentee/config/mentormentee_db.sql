-- Database: mentormentee

-- Table: faculty
CREATE TABLE IF NOT EXISTS faculty (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    address VARCHAR(255),
    name VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO faculty (username, password, email, phone, address, name) VALUES
('faculty1', MD5('pass123'), 'faculty1@example.com', '9999999999', 'Faculty Address 1', 'Dr. Alice'),
('faculty2', MD5('pass456'), 'faculty2@example.com', '8888888888', 'Faculty Address 2', 'Dr. Bob');

-- Table: student
CREATE TABLE IF NOT EXISTS student (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    address VARCHAR(255),
    name VARCHAR(100),
    semester VARCHAR(20),
    usn VARCHAR(20) UNIQUE,
    parent_phone VARCHAR(20),
    parent_name VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO student (username, password, email, phone, address, name, semester, usn, parent_phone, parent_name) VALUES
('student1', MD5('stud123'), 'stud1@example.com', '7777777777', 'Student Address 1', 'John Doe', '4', 'USN001', '6666666666', 'Mr. Doe'),
('student2', MD5('stud456'), 'stud2@example.com', '6666666666', 'Student Address 2', 'Jane Smith', '6', 'USN002', '5555555555', 'Mrs. Smith');

-- Table: parent
CREATE TABLE IF NOT EXISTS parent (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    phone VARCHAR(20) NOT NULL,
    name VARCHAR(100),
    FOREIGN KEY(student_id) REFERENCES student(id)
);

INSERT INTO parent (student_id, phone, name) VALUES
(1, '6666666666', 'Mr. Doe'),
(2, '5555555555', 'Mrs. Smith');

-- Table: admin (hardcoded login, but table for completeness)
CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

INSERT IGNORE INTO admin (username, password) VALUES
('admin', MD5('admin'));

-- Table: marks
CREATE TABLE IF NOT EXISTS marks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    faculty_id INT,
    student_id INT,
    testname VARCHAR(100),
    date DATE,
    total_marks INT,
    semester VARCHAR(20),
    marks INT,
    FOREIGN KEY(faculty_id) REFERENCES faculty(id),
    FOREIGN KEY(student_id) REFERENCES student(id)
);

INSERT INTO marks (faculty_id, student_id, testname, date, total_marks, semester, marks) VALUES
(1, 1, 'Midterm 1', '2025-04-01', 100, '4', 85),
(1, 2, 'Midterm 1', '2025-04-01', 100, '6', 78);

-- Table: study_plan
CREATE TABLE IF NOT EXISTS study_plan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    faculty_id INT,
    title VARCHAR(100),
    date DATE,
    start_time TIME,
    end_time TIME,
    description TEXT,
    FOREIGN KEY(faculty_id) REFERENCES faculty(id)
);

INSERT INTO study_plan (faculty_id, title, date, start_time, end_time, description) VALUES
(1, 'Plan 1', '2025-05-01', '10:00:00', '12:00:00', 'Study Plan 1 Description');

-- Table: assignment
CREATE TABLE IF NOT EXISTS assignment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    faculty_id INT,
    subject VARCHAR(100),
    from_date DATE,
    to_date DATE,
    file_path VARCHAR(255),
    semester VARCHAR(20),
    description TEXT,
    FOREIGN KEY(faculty_id) REFERENCES faculty(id)
);

INSERT INTO assignment (faculty_id, subject, from_date, to_date, file_path, semester, description) VALUES
(1, 'Maths', '2025-04-15', '2025-04-30', 'uploads/assignment1.pdf', '4', 'Assignment 1 Description');

-- Table: resources
CREATE TABLE IF NOT EXISTS resources (
    id INT AUTO_INCREMENT PRIMARY KEY,
    faculty_id INT,
    title VARCHAR(100),
    file_path VARCHAR(255),
    description TEXT,
    FOREIGN KEY(faculty_id) REFERENCES faculty(id)
);

INSERT INTO resources (faculty_id, title, file_path, description) VALUES
(1, 'Resource 1', 'uploads/resource1.pdf', 'Resource 1 Description');

-- Table: attendance
CREATE TABLE IF NOT EXISTS attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    faculty_id INT,
    student_id INT,
    subject VARCHAR(100),
    total_classes INT,
    month VARCHAR(20),
    year INT,
    total_attended INT,
    FOREIGN KEY(faculty_id) REFERENCES faculty(id),
    FOREIGN KEY(student_id) REFERENCES student(id)
);

INSERT INTO attendance (faculty_id, student_id, subject, total_classes, month, year, total_attended) VALUES
(1, 1, 'Maths', 20, 'April', 2025, 18);

-- Table: assignment_submissions
CREATE TABLE IF NOT EXISTS assignment_submissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    assignment_id INT,
    student_id INT,
    file_path VARCHAR(255),
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(assignment_id) REFERENCES assignment(id),
    FOREIGN KEY(student_id) REFERENCES student(id)
);

INSERT INTO assignment_submissions (assignment_id, student_id, file_path) VALUES
(1, 1, 'uploads/submission1.pdf');
