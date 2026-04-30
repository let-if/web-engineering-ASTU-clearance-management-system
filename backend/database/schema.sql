CREATE DATABASE test_db;
USE test_db;

-- USERS
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  password VARCHAR(255),
  role ENUM('student','department','admin') DEFAULT 'student',
  department_id INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- DEPARTMENTS
CREATE TABLE departments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- CLEARANCE REQUESTS
CREATE TABLE clearance_requests (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_id INT,
  status ENUM('pending','approved','rejected') DEFAULT 'pending',
  reason TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (student_id) REFERENCES users(id)
);

-- APPROVALS
CREATE TABLE approvals (
  id INT AUTO_INCREMENT PRIMARY KEY,
  request_id INT,
  department_id INT,
  status ENUM('pending','approved','rejected') DEFAULT 'pending',
  comment TEXT,
  approved_by INT,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (request_id) REFERENCES clearance_requests(id),
  FOREIGN KEY (department_id) REFERENCES departments(id),
  FOREIGN KEY (approved_by) REFERENCES users(id)
);

-- NOTIFICATIONS
CREATE TABLE notifications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  message TEXT,
  is_read BOOLEAN DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

-- LOGS
CREATE TABLE logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  action TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);
