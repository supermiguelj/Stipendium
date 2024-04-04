CREATE TABLE employee_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    department VARCHAR(50),
    job_title VARCHAR(50),
    clock_in DATETIME,
    clock_out DATETIME
);

