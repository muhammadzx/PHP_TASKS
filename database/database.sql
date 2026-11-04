-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2026 at 09:35 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `university_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(100) DEFAULT NULL,
  `course_code` varchar(20) DEFAULT NULL,
  `credits` int(11) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `capacity` int(11) DEFAULT 30
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `course_code`, `credits`, `department`, `capacity`) VALUES
(1, 'Database Systems', 'CS101', 3, 'CS', 30),
(2, 'Artificial Intelligence', 'AI201', 3, 'AI', 25),
(3, 'Web Development', 'CS202', 3, 'CS', 30),
(4, 'Data Structures', 'CS203', 4, 'CS', 25),
(5, 'Machine Learning', 'AI301', 3, 'AI', 20);

-- --------------------------------------------------------

--
-- Table structure for table `course_assignments`
--

CREATE TABLE `course_assignments` (
  `assignment_id` int(11) NOT NULL,
  `instructor_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `semester` varchar(20) DEFAULT NULL,
  `year` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_assignments`
--

INSERT INTO `course_assignments` (`assignment_id`, `instructor_id`, `course_id`, `semester`, `year`) VALUES
(1, 1, 1, 'Fall', 2026),
(2, 2, 2, 'Fall', 2026),
(3, 3, 3, 'Fall', 2026),
(4, 5, 4, 'Fall', 2026),
(5, 4, 5, 'Fall', 2026);

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `enrollment_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `grade` varchar(2) DEFAULT NULL,
  `semester` varchar(20) DEFAULT NULL,
  `year` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`enrollment_id`, `student_id`, `course_id`, `grade`, `semester`, `year`) VALUES
(1, 1, 1, 'A', 'Fall', 2026),
(2, 1, 2, 'B', 'Fall', 2026),
(3, 1, 3, 'A', 'Fall', 2026),
(4, 1, 4, 'B', 'Fall', 2026),
(5, 2, 1, 'A', 'Fall', 2026),
(6, 2, 2, 'A', 'Fall', 2026),
(7, 3, 1, 'B', 'Fall', 2026),
(8, 3, 3, 'A', 'Fall', 2026),
(9, 4, 2, 'A', 'Fall', 2026),
(10, 4, 5, 'B', 'Fall', 2026),
(11, 5, 3, 'C', 'Fall', 2026),
(12, 5, 4, 'B', 'Fall', 2026),
(13, 6, 1, 'A', 'Fall', 2026),
(14, 6, 5, 'A', 'Fall', 2026),
(15, 7, 3, 'B', 'Fall', 2026),
(16, 7, 4, 'C', 'Fall', 2026),
(17, 8, 2, 'A', 'Fall', 2026),
(18, 8, 5, 'A', 'Fall', 2026),
(19, 9, 1, 'B', 'Fall', 2026),
(20, 9, 3, NULL, 'Fall', 2026),
(21, 10, 4, 'A', 'Fall', 2026),
(22, 10, 5, NULL, 'Fall', 2026);

-- --------------------------------------------------------

--
-- Table structure for table `instructors`
--

CREATE TABLE `instructors` (
  `instructor_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `hire_date` date DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instructors`
--

INSERT INTO `instructors` (`instructor_id`, `first_name`, `last_name`, `email`, `hire_date`, `department`) VALUES
(1, 'Khaled', 'Ahmad', 'khaled@uni.edu', '2018-01-10', 'CS'),
(2, 'Mona', 'Ali', 'mona@uni.edu', '2019-05-12', 'AI'),
(3, 'Sami', 'Omar', 'sami@uni.edu', '2020-03-15', 'CS'),
(4, 'Hanan', 'Saleh', 'hanan@uni.edu', '2017-09-01', 'AI'),
(5, 'Fadi', 'Nasser', 'fadi@uni.edu', '2021-02-20', 'CS');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `major` varchar(100) DEFAULT NULL,
  `enrollment_year` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `first_name`, `last_name`, `email`, `date_of_birth`, `gender`, `major`, `enrollment_year`) VALUES
(1, 'Ahmad', 'Ali', 'ahmad@gmail.com', '2003-05-12', 'Male', 'Computer Science', 2022),
(2, 'Sara', 'Omar', 'sara@gmail.com', '2004-03-15', 'Female', 'AI', 2023),
(3, 'Mohammad', 'Khaled', 'mohammad@gmail.com', '2002-08-20', 'Male', 'IT', 2021),
(4, 'Lina', 'Hassan', 'lina@gmail.com', '2003-11-10', 'Female', 'AI', 2022),
(5, 'Omar', 'Saleh', 'omar@gmail.com', '2004-01-05', 'Male', 'CS', 2023),
(6, 'Noor', 'Ahmad', 'noor@gmail.com', '2003-06-18', 'Female', 'IT', 2022),
(7, 'Yazan', 'Mahmoud', 'yazan@gmail.com', '2002-09-22', 'Male', 'CS', 2021),
(8, 'Huda', 'Ibrahim', 'huda@gmail.com', '2004-07-14', 'Female', 'AI', 2023),
(9, 'Ali', 'Nasser', 'ali@gmail.com', '2003-02-27', 'Male', 'IT', 2022),
(10, 'Rana', 'Sami', 'rana@gmail.com', '2004-12-09', 'Female', 'CS', 2023);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `course_assignments`
--
ALTER TABLE `course_assignments`
  ADD PRIMARY KEY (`assignment_id`),
  ADD KEY `instructor_id` (`instructor_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`enrollment_id`),
  ADD UNIQUE KEY `student_id` (`student_id`,`course_id`,`semester`,`year`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `instructors`
--
ALTER TABLE `instructors`
  ADD PRIMARY KEY (`instructor_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `course_assignments`
--
ALTER TABLE `course_assignments`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `enrollment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `instructors`
--
ALTER TABLE `instructors`
  MODIFY `instructor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course_assignments`
--
ALTER TABLE `course_assignments`
  ADD CONSTRAINT `course_assignments_ibfk_1` FOREIGN KEY (`instructor_id`) REFERENCES `instructors` (`instructor_id`),
  ADD CONSTRAINT `course_assignments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`);

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- 1. All students
SELECT * FROM Students;

-- 2. Total courses
SELECT COUNT(*) AS total_courses
FROM Courses;

-- 3. Students enrolled in a specific course
SELECT s.first_name, s.last_name
FROM Students s
JOIN Enrollments e ON s.student_id = e.student_id
JOIN Courses c ON e.course_id = c.course_id
WHERE c.course_code = 'CS101';

-- 4. Instructor emails by department
SELECT email
FROM Instructors
WHERE department = 'CS';


-- 5. Courses and number of enrolled students
SELECT c.course_name,
       COUNT(e.enrollment_id) AS total_students
FROM Courses c
LEFT JOIN Enrollments e ON c.course_id = e.course_id
GROUP BY c.course_id, c.course_name;

-- 6. Students with grade A
SELECT DISTINCT s.first_name, s.last_name
FROM Students s
JOIN Enrollments e ON s.student_id = e.student_id
WHERE e.grade = 'A';

-- 7. Courses and instructors for Fall 2026
SELECT c.course_name,
       i.first_name,
       i.last_name
FROM Course_Assignments ca
JOIN Courses c ON ca.course_id = c.course_id
JOIN Instructors i ON ca.instructor_id = i.instructor_id
WHERE ca.semester = 'Fall' AND ca.year = 2026;

-- 8. Average grade for a particular course
SELECT c.course_name,
       AVG(
           CASE e.grade
               WHEN 'A' THEN 4
               WHEN 'B' THEN 3
               WHEN 'C' THEN 2
               WHEN 'D' THEN 1
               WHEN 'F' THEN 0
           END
       ) AS average_grade
FROM Courses c
JOIN Enrollments e ON c.course_id = e.course_id
WHERE c.course_code = 'CS101'
GROUP BY c.course_id, c.course_name;


-- 9. Students taking more than 3 courses in Fall 2026
SELECT s.student_id, s.first_name, s.last_name,
       COUNT(*) AS total_courses
FROM Students s
JOIN Enrollments e ON s.student_id = e.student_id
WHERE e.semester = 'Fall' AND e.year = 2026
GROUP BY s.student_id, s.first_name, s.last_name
HAVING COUNT(*) > 3;

-- 10. Students with incomplete grades
SELECT s.first_name, s.last_name, c.course_name
FROM Students s
JOIN Enrollments e ON s.student_id = e.student_id
JOIN Courses c ON e.course_id = c.course_id
WHERE e.grade IS NULL OR e.grade = 'I';

-- 11. Student with highest average grade
SELECT s.student_id, s.first_name, s.last_name,
       AVG(
           CASE e.grade
               WHEN 'A' THEN 4
               WHEN 'B' THEN 3
               WHEN 'C' THEN 2
               WHEN 'D' THEN 1
               WHEN 'F' THEN 0
           END
       ) AS average_grade
FROM Students s
JOIN Enrollments e ON s.student_id = e.student_id
GROUP BY s.student_id, s.first_name, s.last_name
HAVING COUNT(
    CASE WHEN e.grade IN ('A','B','C','D','F')
    THEN 1 END
) > 0
ORDER BY average_grade DESC
LIMIT 1;

-- 12. Department with most course assignments this year
SELECT c.department,
       COUNT(*) AS total_courses_taught
FROM Course_Assignments ca
JOIN Courses c ON ca.course_id = c.course_id
WHERE ca.year = YEAR(CURDATE())
GROUP BY c.department
ORDER BY total_courses_taught DESC
LIMIT 1;

-- 13. Courses with no enrollments
SELECT c.course_name
FROM Courses c
LEFT JOIN Enrollments e ON c.course_id = e.course_id
WHERE e.enrollment_id IS NULL;


DELIMITER //

CREATE FUNCTION CalculateAge(dob DATE)
RETURNS INT
DETERMINISTIC
NO SQL
BEGIN
    RETURN TIMESTAMPDIFF(YEAR, dob, CURDATE())
           - (DATE_FORMAT(CURDATE(), '%m%d')
           < DATE_FORMAT(dob, '%m%d'));
END //

DELIMITER ;

SELECT first_name, last_name,
       CalculateAge(date_of_birth) AS age
FROM Students;


DELIMITER //

CREATE PROCEDURE EnrollStudent(
    IN p_student_id INT,
    IN p_course_id INT
)
BEGIN
    INSERT INTO Enrollments
    (student_id, course_id, grade, semester, year)
    VALUES
    (p_student_id, p_course_id, NULL, 'Fall', 2026);
END //

DELIMITER ;

-- Example
CALL EnrollStudent(2, 3);


SELECT c.department,
       ROUND(AVG(
           CASE e.grade
               WHEN 'A' THEN 4
               WHEN 'B' THEN 3
               WHEN 'C' THEN 2
               WHEN 'D' THEN 1
               WHEN 'F' THEN 0
           END
       ), 2) AS average_grade
FROM Courses c
JOIN Enrollments e ON c.course_id = e.course_id
GROUP BY c.department;


DELIMITER //

CREATE PROCEDURE EnrollWithCapacity(
    IN p_student_id INT,
    IN p_course_id INT
)
BEGIN
    DECLARE v_capacity INT DEFAULT NULL;
    DECLARE v_count INT DEFAULT 0;

    START TRANSACTION;

    SELECT capacity INTO v_capacity
    FROM Courses
    WHERE course_id = p_course_id
    FOR UPDATE;

    IF v_capacity IS NULL THEN
        ROLLBACK;
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Course not found';

    ELSE
        SELECT COUNT(*) INTO v_count
        FROM Enrollments
        WHERE course_id = p_course_id
          AND semester = 'Fall'
          AND year = 2026;

        IF v_count < v_capacity THEN
            INSERT INTO Enrollments
            (student_id, course_id, grade, semester, year)
            VALUES
            (p_student_id, p_course_id, NULL, 'Fall', 2026);

            COMMIT;
        ELSE
            ROLLBACK;
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Course is full';
        END IF;
    END IF;
END //

DELIMITER ;

CALL EnrollWithCapacity(3, 2);


-- 1. Create index on course_code
CREATE INDEX idx_course_code
ON Courses(course_code);

-- 2. Explain query execution
EXPLAIN
SELECT s.first_name, s.last_name
FROM Students s
JOIN Enrollments e ON s.student_id = e.student_id
JOIN Courses c ON e.course_id = c.course_id
WHERE c.course_code = 'CS101';


-- 1. INNER JOIN
SELECT s.first_name, s.last_name, c.course_name
FROM Students s
INNER JOIN Enrollments e
ON s.student_id = e.student_id
INNER JOIN Courses c
ON e.course_id = c.course_id;

-- 2. LEFT JOIN
SELECT i.first_name, i.last_name, c.course_name
FROM Instructors i
LEFT JOIN Course_Assignments ca
ON i.instructor_id = ca.instructor_id
LEFT JOIN Courses c
ON ca.course_id = c.course_id;

-- 3. UNION
SELECT first_name, last_name, 'Student' AS role
FROM Students
UNION
SELECT first_name, last_name, 'Instructor' AS role
FROM Instructors;


SELECT
    s.student_id,
    CONCAT(s.first_name, ' ', s.last_name) AS student_name,
    s.email,
    s.major,
    c.course_name,
    CONCAT(i.first_name, ' ', i.last_name) AS instructor_name,
    e.grade,
    c.credits,
    (
        SELECT SUM(c2.credits)
        FROM Enrollments e2
        JOIN Courses c2 ON e2.course_id = c2.course_id
        WHERE e2.student_id = s.student_id
          AND e2.semester = 'Fall'
          AND e2.year = 2026
    ) AS total_credits
FROM Students s
JOIN Enrollments e ON s.student_id = e.student_id
JOIN Courses c ON e.course_id = c.course_id
LEFT JOIN Course_Assignments ca
    ON ca.course_id = c.course_id
    AND ca.semester = e.semester
    AND ca.year = e.year
LEFT JOIN Instructors i
    ON ca.instructor_id = i.instructor_id
WHERE e.semester = 'Fall'
  AND e.year = 2026
ORDER BY s.student_id, c.course_name;
