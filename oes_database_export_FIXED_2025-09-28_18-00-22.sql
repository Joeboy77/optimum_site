-- Table structure for table `cashindebt`
DROP TABLE IF EXISTS `cashindebt`;
CREATE TABLE `cashindebt` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `location` varchar(150) DEFAULT NULL,
  `work_unit` varchar(100) DEFAULT NULL,
  `track` varchar(100) DEFAULT NULL,
  `balance` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Table structure for table `course_registration`
DROP TABLE IF EXISTS `course_registration`;
CREATE TABLE `course_registration` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `studentID` varchar(100) DEFAULT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `course_name` varchar(200) DEFAULT NULL,
  `course_code` varchar(50) DEFAULT NULL,
  `semester` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Table structure for table `courses`
DROP TABLE IF EXISTS `courses`;
CREATE TABLE `courses` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `programType` varchar(150) DEFAULT NULL,
  `course_name` varchar(200) DEFAULT NULL,
  `programTypeID` int DEFAULT NULL,
  `course_code` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data for table `courses`
INSERT INTO `courses` VALUES (1, 'Computer Science', 'System Design', 1, 'C001');
INSERT INTO `courses` VALUES (2, 'Computer Science', 'Archi', 1, 'C002');
INSERT INTO `courses` VALUES (3, 'sdffd', 'cdvfdfgd', 2, 'C003');

-- Table structure for table `exam_categories`
DROP TABLE IF EXISTS `exam_categories`;
CREATE TABLE `exam_categories` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data for table `exam_categories`
INSERT INTO `exam_categories` VALUES ('1', '1', 'New Set', 'New Set', 'Hello', 'Hello', '2025-09-22 16:46:42', '2025-09-22 16:46:42');
INSERT INTO `exam_categories` VALUES ('3', '3', 'New', 'New', 'scscs', 'scscs', '2025-09-23 16:44:02', '2025-09-23 16:44:02');
INSERT INTO `exam_categories` VALUES ('5', '5', 'sfsf', 'sfsf', 'cscsvcsfc', 'cscsvcsfc', '2025-09-28 10:32:47', '2025-09-28 10:32:47');

-- Table structure for table `exam_questions`
DROP TABLE IF EXISTS `exam_questions`;
CREATE TABLE `exam_questions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `exam_id` int unsigned NOT NULL,
  `question` text NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `correct_option` enum('a','b','c','d') NOT NULL,
  `marks` int DEFAULT '1',
  `attachment` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `exam_id` (`exam_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data for table `exam_questions`
INSERT INTO `exam_questions` VALUES ('1', '6', 'who are you', 'me', 'you', 'k', 'b', 'a', '5', '', '2025-09-22 18:08:04');
INSERT INTO `exam_questions` VALUES ('2', '4', 'hi', 'a', 'b', 'c', 'd', 'a', '5', '', '2025-09-22 18:12:18');
INSERT INTO `exam_questions` VALUES ('3', '4', 'hello', 'a', 'b', 'c', 'd', 'a', '5', '', '2025-09-22 18:12:44');
INSERT INTO `exam_questions` VALUES ('4', '7', 'How are you?', 'f', 'v', 'a', 'r', 'a', '1', '', '2025-09-22 19:53:47');
INSERT INTO `exam_questions` VALUES ('5', '7', 'World', 'v', 'i', 'm', 'd', 'a', '1', '', '2025-09-22 19:54:08');
INSERT INTO `exam_questions` VALUES ('6', '8', 'What is a noun', 'Kofi', 'A', 'Animal', 'D', 'a', '5', NULL, '2025-09-23 11:37:10');
INSERT INTO `exam_questions` VALUES ('7', '8', 'IS it true?', 'A', 'B', 'C', 'D', 'a', '5', NULL, '2025-09-23 11:39:54');
INSERT INTO `exam_questions` VALUES ('8', '8', 'A is?', 'A', 'B', 'C', 'D', 'a', '1', NULL, '2025-09-23 12:18:28');
INSERT INTO `exam_questions` VALUES ('9', '8', 'Hello wor', 'd', 'v', 'a', 'f', 'a', '9', NULL, '2025-09-23 12:19:04');
INSERT INTO `exam_questions` VALUES ('10', '9', 'What is a noun?', 'A', 'B', 'C', 'D', 'a', '5', NULL, '2025-09-23 12:45:24');
INSERT INTO `exam_questions` VALUES ('11', '9', 'WHO ARE YOU?', 'A', 'B', 'C', 'D', 'a', '5', NULL, '2025-09-23 12:45:43');
INSERT INTO `exam_questions` VALUES ('12', '10', 'Who are you?', 'Joe', 'B', 'C', 'D', 'a', '5', NULL, '2025-09-23 12:55:14');
INSERT INTO `exam_questions` VALUES ('13', '10', 'WHAT IS THIS?', 'A', 'B', 'C', 'D', 'a', '5', NULL, '2025-09-23 12:55:34');
INSERT INTO `exam_questions` VALUES ('14', '11', 'sadsasdq', 'a', 'cc', 'cs', 'cxcsc', 'a', '1', NULL, '2025-09-23 16:47:39');
INSERT INTO `exam_questions` VALUES ('15', '11', 'sdsdsdasd', 'dsd', 'sdsd', 'sdsd', 'dsds', 'a', '1', NULL, '2025-09-23 16:47:57');
INSERT INTO `exam_questions` VALUES ('16', '12', 'fefefef', 'a', 'b', 'd', 'v', 'a', '1', '', '2025-09-23 16:52:18');
INSERT INTO `exam_questions` VALUES ('17', '12', 'dsdsdsd', 'dssd', 'fbvfvb', 'vffvf', 'vv', 'a', '1', '', '2025-09-23 16:52:31');
INSERT INTO `exam_questions` VALUES ('18', '13', 'fdfdfdf', 'sd', 'dcd', 'cscf', 'dfvdf', 'a', '1', NULL, '2025-09-28 10:37:19');
INSERT INTO `exam_questions` VALUES ('19', '14', 'ccxcxcxc', 'c', 'cxc', 'vdv', 'cxc', 'a', '1', '', '2025-09-28 10:38:46');
INSERT INTO `exam_questions` VALUES ('20', '15', 'SCSCSCS', 'CCS', 'SCS', 'CSCS', 'CSCS', 'a', '1', '', '2025-09-28 10:42:53');
INSERT INTO `exam_questions` VALUES ('21', '15', 'VDVDVDVD', 'CSCS', 'cdcd', 'VDVEV', 'fvf', 'a', '1', '', '2025-09-28 10:43:08');
INSERT INTO `exam_questions` VALUES ('23', '16', 'ggfdfdfdf', 'fff', 'feffe', 'dfdfdf', 'fefefe', 'a', '1', NULL, '2025-09-28 17:07:33');
INSERT INTO `exam_questions` VALUES ('24', '16', 'fefefdfdf', 'fdfdd', 'efef', 'fef', 'efef', 'a', '1', NULL, '2025-09-28 17:07:44');
INSERT INTO `exam_questions` VALUES ('25', '17', 'hjgfdghgjkljhg', 'hgfhj', 'hvb', 'jkhgj', 'iuyt', 'a', '1', '', '2025-09-28 17:17:58');
INSERT INTO `exam_questions` VALUES ('26', '17', 'jghfdghjhkjlk', 'mnnbhvgchvj', 'khjgcvhbj', 'hugyfghj', 'jhgfhjk', 'a', '1', '', '2025-09-28 17:18:23');

-- Table structure for table `exam_results`
DROP TABLE IF EXISTS `exam_results`;
CREATE TABLE `exam_results` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `exam_id` int unsigned NOT NULL,
  `student_id` varchar(100) NOT NULL,
  `score` int NOT NULL,
  `taken_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `exam_id` (`exam_id`),
  KEY `student_id` (`student_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data for table `exam_results`
INSERT INTO `exam_results` VALUES ('1', '4', '25COTVI0014', '5', '2025-09-22 18:16:18');
INSERT INTO `exam_results` VALUES ('2', '6', '25COTVI0014', '5', '2025-09-22 19:43:54');
INSERT INTO `exam_results` VALUES ('3', '7', '25COTVI0014', '2', '2025-09-22 20:00:48');
INSERT INTO `exam_results` VALUES ('4', '8', '14', '20', '2025-09-23 12:33:23');
INSERT INTO `exam_results` VALUES ('5', '8', '25COTVI0014', '20', '2025-09-23 12:41:07');
INSERT INTO `exam_results` VALUES ('6', '9', '25COTVI0014', '5', '2025-09-23 12:46:37');
INSERT INTO `exam_results` VALUES ('7', '10', '25COTVI0014', '5', '2025-09-23 12:56:01');
INSERT INTO `exam_results` VALUES ('8', '12', '25COTVI0014', '1', '2025-09-23 16:53:06');
INSERT INTO `exam_results` VALUES ('9', '17', '25COTVI0017', '0', '2025-09-28 17:19:11');

-- Table structure for table `exams_questions`
DROP TABLE IF EXISTS `exams_questions`;
CREATE TABLE `exams_questions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `staffID` varchar(100) DEFAULT NULL,
  `questionID` int DEFAULT NULL,
  `question_no` int DEFAULT NULL,
  `question` text,
  `option1` text,
  `option2` text,
  `option3` text,
  `option4` text,
  `correct_answer` varchar(50) DEFAULT NULL,
  `reason` text,
  `marks` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data for table `exams_questions`
INSERT INTO `exams_questions` VALUES ('1', '25SOTVI0013', '13', '1', 'What is a book', 'book', 'block', 'bible', 'bra', 'a', 'Because a mook is a book', '100', '2025-09-22 15:24:03');
INSERT INTO `exams_questions` VALUES ('2', '25SOTVI0013', '13', '2', '<p>Hello?</p>', 'hi', 'no', 'go', 'bra', 'a', '<p>No required</p>', '1', '2025-09-22 15:25:17');
INSERT INTO `exams_questions` VALUES ('3', '25SOTVI0013', '13', '3', '<p>A?</p>', 'a', 'b', 'c', 'd', 'a', '<p>A is a</p>', '1', '2025-09-22 15:25:42');
INSERT INTO `exams_questions` VALUES ('4', '25SOTVI0013', '13', '4', '<p>WHo are you</p>', 'Joe', 'Nana', 'Yaw', 'A', 'a', '<p>No</p>', '5', '2025-09-22 16:19:25');
INSERT INTO `exams_questions` VALUES ('5', '25SOTVI0013', '13', '5', '<p>How are you</p>', 'sd', 'cscs', 'cssc', 'cscsc', 'a', '<p>ccsc</p>', '2', '2025-09-22 16:19:51');

-- Table structure for table `exams_setting`
DROP TABLE IF EXISTS `exams_setting`;
CREATE TABLE `exams_setting` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `course` varchar(200) DEFAULT NULL,
  `semester` varchar(50) DEFAULT NULL,
  `timelimit` int DEFAULT NULL,
  `start_at` datetime DEFAULT NULL,
  `end_at` datetime DEFAULT NULL,
  `totalmarks` int DEFAULT NULL,
  `total_questions` int DEFAULT NULL,
  `lecturer` varchar(150) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `start_indicator` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data for table `exams_setting`
INSERT INTO `exams_setting` VALUES ('1', 'ENDER', NULL, 'System Design', 'Semeter 1', '20', NULL, NULL, '100', NULL, 'Teacher 1', NULL, NULL, '2025-09-22 15:23:12');
INSERT INTO `exams_setting` VALUES ('2', 'Another', NULL, 'System Design', 'Semeter 1', '10', NULL, NULL, '3', NULL, 'Teacher 1', NULL, NULL, '2025-09-22 15:24:49');
INSERT INTO `exams_setting` VALUES ('3', 'Test 1', 'New Set', 'System Design', 'Semester 1', '10', '2025-09-22 17:13:00', '2025-09-25 17:13:00', '10', '3', 'Teacher 1', NULL, NULL, '2025-09-22 16:17:56');
INSERT INTO `exams_setting` VALUES ('4', 'Testing you', 'New Set', 'System Design', 'Semester 1', '10', '2025-09-22 17:53:00', '2025-09-24 17:53:00', '10', '2', NULL, 'Nana Yaw', NULL, '2025-09-22 17:53:26');
INSERT INTO `exams_setting` VALUES ('5', 'Another', 'New Set', 'System Design', 'Semester 1', '10', '2025-09-22 18:03:00', '2025-09-24 18:03:00', '10', '2', NULL, 'Nana Yaw', NULL, '2025-09-22 18:04:02');
INSERT INTO `exams_setting` VALUES ('6', 'Another', 'New Set', 'System Design', 'Semester 1', '10', '2025-09-22 18:03:00', '2025-09-24 18:03:00', '10', '2', NULL, 'Nana Yaw', NULL, '2025-09-22 18:06:27');
INSERT INTO `exams_setting` VALUES ('7', 'Master', 'New Set', 'System Design', 'Semester 1', '4', '2025-09-22 19:52:00', '2025-09-25 19:52:00', '10', '2', NULL, 'Nana Yaw', NULL, '2025-09-22 19:52:47');
INSERT INTO `exams_setting` VALUES ('8', 'Quiz 2', 'Quiz', 'System Design', NULL, NULL, '2025-09-23 11:47:00', '2025-09-24 11:47:00', '10', '2', NULL, '25SOTVI0013', NULL, '2025-09-23 11:36:36');
INSERT INTO `exams_setting` VALUES ('9', 'Quiz 3', 'Quiz', 'System Design', NULL, NULL, '2025-09-23 12:44:00', '2025-09-25 12:44:00', '10', '2', NULL, '25SOTVI0013', NULL, '2025-09-23 12:44:59');
INSERT INTO `exams_setting` VALUES ('10', 'Quiz 4', 'Quiz', 'System Design', NULL, NULL, '2025-09-23 12:53:00', '2025-09-25 12:54:00', '10', '2', NULL, '25SOTVI0013', NULL, '2025-09-23 12:54:06');
INSERT INTO `exams_setting` VALUES ('11', 'cscscs', 'Quiz', 'System Design', NULL, NULL, '2025-09-23 16:47:00', '2025-09-25 16:47:00', '2', '2', NULL, '25SOTVI0013', NULL, '2025-09-23 16:47:27');
INSERT INTO `exams_setting` VALUES ('12', 'Nationa66', 'New Set', 'System Design', 'Semester 1', '2', '2025-09-23 16:50:00', '2025-09-26 16:50:00', '2', '2', NULL, 'Nana Yaw', NULL, '2025-09-23 16:51:01');
INSERT INTO `exams_setting` VALUES ('13', 'cdvdvdv', 'Quiz', 'cdvfdfgd', NULL, NULL, '2025-09-28 10:36:00', '2025-09-29 10:37:00', '10', '1', NULL, '25SOTVI0013', NULL, '2025-09-28 10:37:08');
INSERT INTO `exams_setting` VALUES ('14', 'fgdfgdg', 'sfsf', 'cdvfdfgd', 'Semester 1', '1', '2025-09-28 10:37:00', '2025-09-29 10:37:00', '1', '1', NULL, 'Nana Yaw', NULL, '2025-09-28 10:38:14');
INSERT INTO `exams_setting` VALUES ('15', 'END OF SEM222', 'New', 'Archi', 'Semester 1', '5', '2025-09-28 10:42:00', '2025-09-29 10:42:00', '2', '2', NULL, 'Nana Yaw', NULL, '2025-09-28 10:42:36');
INSERT INTO `exams_setting` VALUES ('16', 'heythere', 'Quiz', 'System Design', NULL, NULL, '2025-09-28 17:07:00', '2025-09-29 17:07:00', '10', '2', NULL, '25SOTVI0013', NULL, '2025-09-28 17:07:22');
INSERT INTO `exams_setting` VALUES ('17', 'jbhgcfghbjnkmjh11', 'New', 'System Design', 'Semester 1', '10', '2025-09-28 17:17:00', '2025-09-29 17:17:00', '2', '2', NULL, 'ghj yghjj', NULL, '2025-09-28 17:17:35');

-- Table structure for table `files_upload`
DROP TABLE IF EXISTS `files_upload`;
CREATE TABLE `files_upload` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `file_title` varchar(200) DEFAULT NULL,
  `file_attachment` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data for table `files_upload`
INSERT INTO `files_upload` VALUES ('1', '1', 'Na', 'Na', '../images/DAILY WORKSHEET.xlsx', '../images/DAILY WORKSHEET.xlsx', '2025-09-22 10:12:45', '2025-09-22 10:12:45');
INSERT INTO `files_upload` VALUES ('2', '2', 'Hello', 'Hello', '../images/DAILY WORKSHEET.xlsx', '../images/DAILY WORKSHEET.xlsx', '2025-09-22 10:30:09', '2025-09-22 10:30:09');
INSERT INTO `files_upload` VALUES ('3', '3', 'Fees', 'Fees', 'uploads/schoolfiles/Roadmap_to_Gait_Biometrics_in_Security.docx', 'uploads/schoolfiles/Roadmap_to_Gait_Biometrics_in_Security.docx', '2025-09-22 10:43:17', '2025-09-22 10:43:17');
INSERT INTO `files_upload` VALUES ('4', '4', 'hdkdd', 'hdkdd', 'uploads/schoolfiles/DAILY_WORKSHEET__1_.xlsx', 'uploads/schoolfiles/DAILY_WORKSHEET__1_.xlsx', '2025-09-28 10:30:25', '2025-09-28 10:30:25');

-- Table structure for table `lesson_upload`
DROP TABLE IF EXISTS `lesson_upload`;
CREATE TABLE `lesson_upload` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `course_name` varchar(200) DEFAULT NULL,
  `lesson_class` varchar(150) DEFAULT NULL,
  `lesson_title` varchar(255) DEFAULT NULL,
  `lesson_note` longtext,
  `lesson_file` varchar(255) DEFAULT NULL,
  `staffID` varchar(100) DEFAULT NULL,
  `staff_name` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data for table `lesson_upload`
INSERT INTO `lesson_upload` VALUES ('1', 'System Design', 'C1', 'Hello', 'Updates', 'images/DAILY WORKSHEET.xlsx', '25SOTVI0013', 'Nana Yaw', '2025-09-23 09:57:47');
INSERT INTO `lesson_upload` VALUES ('2', 'System Design', 'C1', 'csdcs', 'cscsc', 'images/uploads/lessons/20250923_164701_DAILY_WORKSHEET.xlsx', '25SOTVI0013', 'Nana Yaw', '2025-09-23 16:47:01');

-- Table structure for table `message`
DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `message` text,
  `messengerID` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data for table `message`
INSERT INTO `message` VALUES ('1', 'Hi', 'Hello Sir', '25COTVI0014', '2025-09-23 13:39:32');

-- Table structure for table `online_exam_table`
DROP TABLE IF EXISTS `online_exam_table`;
CREATE TABLE `online_exam_table` (
  `online_exam_id` int unsigned NOT NULL AUTO_INCREMENT,
  `online_exam_datetime` datetime DEFAULT NULL,
  `marks_per_right_answer` int DEFAULT '1',
  `marks_per_wrong_answer` int DEFAULT '0',
  `online_exam_status` varchar(50) DEFAULT NULL,
  `total_question` int DEFAULT NULL,
  PRIMARY KEY (`online_exam_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Table structure for table `paymentdetails`
DROP TABLE IF EXISTS `paymentdetails`;
CREATE TABLE `paymentdetails` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `indexnumber` varchar(100) DEFAULT NULL,
  `paymentid` varchar(100) DEFAULT NULL,
  `amountowed` decimal(12,2) DEFAULT NULL,
  `feeamount` decimal(12,2) DEFAULT NULL,
  `payment` decimal(12,2) DEFAULT NULL,
  `balance` decimal(12,2) DEFAULT NULL,
  `work_unit` varchar(100) DEFAULT NULL,
  `track` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Table structure for table `programtype`
DROP TABLE IF EXISTS `programtype`;
CREATE TABLE `programtype` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `program` varchar(150) NOT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data for table `programtype`
INSERT INTO `programtype` VALUES ('1', '1', 'Computer Science', 'Computer Science', '201.00', '201.00');
INSERT INTO `programtype` VALUES ('2', '2', 'sdffd', 'sdffd', '20.00', '20.00');

-- Table structure for table `question_table`
DROP TABLE IF EXISTS `question_table`;
CREATE TABLE `question_table` (
  `question_id` int unsigned NOT NULL AUTO_INCREMENT,
  `online_exam_id` int unsigned DEFAULT NULL,
  `question_title` text,
  `answer_option` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Table structure for table `registration`
DROP TABLE IF EXISTS `registration`;
CREATE TABLE `registration` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `indexnumber` varchar(100) DEFAULT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `nationality` varchar(100) DEFAULT NULL,
  `qualification` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `maritalstatus` varchar(50) DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `contactno` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `doappoinment` date DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data for table `registration`
INSERT INTO `registration` VALUES ('2', '25COTVI0001', 'Joseph', 'Acheampong', '2025-09-06', 'Female', 'Ghanaian', NULL, 'cashier@gmail.com', 'Single', '599066717', NULL, 'Accra, 'Accra, '2025-09-08', NULL, NULL, NULL, NULL, 'Student', '2025-09-22 12:14:13');
INSERT INTO `registration` VALUES ('3', '25SOTVI0003', 'Joseph', 'Acheampong', '2025-09-10', NULL, 'Ghanaian', 'Certificate', 'joseph.ecktech@gmail.com', 'Single', '0258330401', NULL, 'Accra, 'Accra, '2025-09-21', 'Blocked', NULL, NULL, NULL, 'Staff', '2025-09-22 12:20:06');
INSERT INTO `registration` VALUES ('4', '25COTVI0004', 'Joseph', 'Acheampong', '2025-09-09', 'Male', 'Ghanaian', NULL, 'admin123@gmail.com', 'Single', '599066717', NULL, 'Accra, 'Accra, '2025-09-15', NULL, NULL, NULL, NULL, 'Student', '2025-09-22 12:23:49');
INSERT INTO `registration` VALUES ('5', '25COTVI0005', 'Joseph', 'Acheampong', '2025-09-10', 'Male', 'Ghanaian', NULL, 'admin155@gmail.com', 'Single', '599066717', NULL, 'Accra, 'Accra, '2025-09-09', NULL, NULL, NULL, NULL, 'Student', '2025-09-22 13:51:26');
INSERT INTO `registration` VALUES ('6', '25COTVI0006', 'Joseph', 'Acheampong', '2025-09-10', 'Male', 'Ghanaian', NULL, 'admin155@gmail.com', 'Single', '599066717', NULL, 'Accra, 'Accra, '2025-09-09', NULL, NULL, NULL, NULL, 'Student', '2025-09-22 13:58:36');
INSERT INTO `registration` VALUES ('7', '25COTVI0007', 'Joseph', 'Acheampong', '2025-09-10', 'Male', 'Ghanaian', NULL, 'admin155@gmail.com', 'Single', '599066717', NULL, 'Accra, 'Accra, '2025-09-02', NULL, NULL, NULL, NULL, 'Student', '2025-09-22 13:59:13');
INSERT INTO `registration` VALUES ('8', '25COTVI0008', 'Joseph', 'Acheampong', '2025-09-10', 'Male', 'Ghanaian', NULL, 'admin155@gmail.com', 'Single', '599066717', NULL, 'Accra, 'Accra, '2025-09-03', NULL, NULL, NULL, NULL, 'Student', '2025-09-22 13:59:38');
INSERT INTO `registration` VALUES ('9', '25COTVI0009', 'Joseph', 'Acheampong', '2025-09-10', 'Male', 'Ghanaian', NULL, 'admin155@gmail.com', 'Single', '599066717', NULL, 'Accra, 'Accra, '2025-09-03', NULL, NULL, NULL, NULL, 'Student', '2025-09-22 14:10:00');
INSERT INTO `registration` VALUES ('10', '25COTVI0010', 'Joseph', 'Acheampong', '2025-09-10', 'Male', 'Ghanaian', NULL, 'admin155@gmail.com', 'Single', '599066717', NULL, 'Accra, 'Accra, '2025-09-03', NULL, NULL, 'joe', 'cb2af2607bac5d358051b1adff9e2a17', 'Student', '2025-09-22 14:17:58');
INSERT INTO `registration` VALUES ('11', '25COTVI0011', 'Joseph', 'Acheampong', '2025-09-04', 'Male', 'Ghanaian', NULL, 'admin12@gmail.com', 'Single', '599066717', NULL, 'Accra, 'Accra, '2025-09-16', NULL, NULL, NULL, NULL, 'Student', '2025-09-22 14:18:55');
INSERT INTO `registration` VALUES ('12', '25COTVI0012', 'Joseph', 'Acheampong', '2025-09-05', 'Male', 'Ghanaian', NULL, 'admin18@gmail.com', 'Single', '599066717', NULL, 'Accra, 'Accra, '2025-09-04', NULL, NULL, NULL, NULL, 'Student', '2025-09-22 14:31:29');
INSERT INTO `registration` VALUES ('13', '25SOTVI0013', 'Nana', 'Yaw', '2025-09-02', NULL, 'Ghanaian', 'Diploma', 'nana@gmail.com', 'Single', '0559066715', NULL, 'AM-0836-8422, 'AM-0836-8422, '2025-09-21', 'Tutor', NULL, 'nana', 'cb2af2607bac5d358051b1adff9e2a17', 'Staff', '2025-09-22 15:17:10');
INSERT INTO `registration` VALUES ('14', '25COTVI0014', 'Kwesi', 'Yeboah', '2025-09-03', 'Female', 'Ghanaian', NULL, 'k@gmail.com', 'Single', '599066710', NULL, 'AM-0836-8422, 'AM-0836-8422, '2025-09-22', NULL, NULL, 'joe77', 'cb2af2607bac5d358051b1adff9e2a17', 'Student', '2025-09-22 17:18:43');
INSERT INTO `registration` VALUES ('15', '25SOTVI0015', 'svcdv', 'vcvv', '2025-09-23', NULL, 'cscs', 'Certificate', 'cdc@gmail.com', 'Single', '2132323', NULL, 'dsdsd', '2025-09-28', 'Tutor', NULL, NULL, NULL, 'Staff', '2025-09-28 10:32:07');
INSERT INTO `registration` VALUES ('16', '25SOTVI0016', 'ghj', 'yghjj', '2025-09-21', NULL, 'vghbnm', 'SHS Graduate', 'jhjhh@gmail.com', 'Single', '323213212', NULL, 'dsdsd', '2025-09-28', 'Tutor', NULL, 'adv', 'cb2af2607bac5d358051b1adff9e2a17', 'Staff', '2025-09-28 17:10:12');
INSERT INTO `registration` VALUES ('17', '25COTVI0017', 'xtghjk', 'retdyfughjk', '2025-09-21', 'Male', 'jihuyfghj', NULL, 'hjg@gmail.com', 'Single', '78654879', NULL, 'hfytdrsyguh', '2025-09-28', NULL, NULL, 'stu', 'cb2af2607bac5d358051b1adff9e2a17', 'Student', '2025-09-28 17:13:10');

-- Table structure for table `student_registration`
DROP TABLE IF EXISTS `student_registration`;
CREATE TABLE `student_registration` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `indexnumber` varchar(100) DEFAULT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `placeOfBirth` varchar(150) DEFAULT NULL,
  `Hometown` varchar(150) DEFAULT NULL,
  `region` varchar(100) DEFAULT NULL,
  `nationality` varchar(100) DEFAULT NULL,
  `dateOfAdmission` date DEFAULT NULL,
  `active` varchar(50) DEFAULT NULL,
  `programType` varchar(150) DEFAULT NULL,
  `courseSelected` varchar(200) DEFAULT NULL,
  `courseDuration` varchar(100) DEFAULT NULL,
  `fees` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data for table `student_registration`
INSERT INTO `student_registration` VALUES ('1', '25COTVI0010', 'Joseph', 'Acheampong', 'admin155@gmail.com', '0599066717', 'Accra', 'Mampong', 'Ashanti', 'Ghanaian', '2025-09-03', 'Yes', 'Computer Science', 'System Design', 'Six months', NULL, '2025-09-22 14:17:58');
INSERT INTO `student_registration` VALUES ('2', '25COTVI0011', 'Joseph', 'Acheampong', 'admin12@gmail.com', '0599066717', 'Accra', 'Mampong', 'Ashanti', 'Ghanaian', '2025-09-16', 'Blocked', 'Computer Science', 'System Design', 'Six months', NULL, '2025-09-22 14:18:55');
INSERT INTO `student_registration` VALUES ('3', '25COTVI0012', 'Joseph', 'Acheampong', 'admin18@gmail.com', '0599066717', 'Accra', 'Mampong', 'Ashanti', 'Ghanaian', '2025-09-04', 'Yes', 'Computer Science', 'System Design', 'Six months', '201.00', '2025-09-22 14:31:29');
INSERT INTO `student_registration` VALUES ('4', '25COTVI0014', 'Kwesi', 'Yeboah', 'k@gmail.com', '0599066710', 'Accra', 'Mampong', 'Ashanti', 'Ghanaian', '2025-09-22', 'Blocked', 'Computer Science', 'System Design', 'Six months', '', '2025-09-22 17:18:43');
INSERT INTO `student_registration` VALUES ('5', '25COTVI0017', 'xtghjk', 'retdyfughjk', 'hjg@gmail.com', '78654879', 'jiughdfgh', 'jihuyfg', 'kjjhghjk', 'jihuyfghj', '2025-09-28', 'Yes', 'Computer Science', 'System Design', 'Six months', '', '2025-09-28 17:13:10');

-- Table structure for table `tripirregularexpenses`
DROP TABLE IF EXISTS `tripirregularexpenses`;
CREATE TABLE `tripirregularexpenses` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `itemname` varchar(150) DEFAULT NULL,
  `itemamount` decimal(12,2) DEFAULT NULL,
  `itemimage` varchar(255) DEFAULT NULL,
  `work_unit` varchar(100) DEFAULT NULL,
  `track` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Table structure for table `tripregularexpenses`
DROP TABLE IF EXISTS `tripregularexpenses`;
CREATE TABLE `tripregularexpenses` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `feedingfee` decimal(12,2) DEFAULT NULL,
  `tax` decimal(12,2) DEFAULT NULL,
  `fuel` decimal(12,2) DEFAULT NULL,
  `numberoflitres` decimal(12,2) DEFAULT NULL,
  `totalfuelcost` decimal(12,2) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `totalregularexpenses` decimal(12,2) DEFAULT NULL,
  `work_unit` varchar(100) DEFAULT NULL,
  `track` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Table structure for table `tutorclass`
DROP TABLE IF EXISTS `tutorclass`;
CREATE TABLE `tutorclass` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `classname` varchar(150) DEFAULT NULL,
  `course_name` varchar(200) DEFAULT NULL,
  `course_code` varchar(50) DEFAULT NULL,
  `staff_name` varchar(200) DEFAULT NULL,
  `staffID` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data for table `tutorclass`
INSERT INTO `tutorclass` VALUES ('1', 'C1', 'Computer Science', 'System Design', 'Nana Yaw', '25SOTVI0013', '2025-09-23 09:41:56');
INSERT INTO `tutorclass` VALUES ('2', 'hh', 'Computer Science', 'System Design', 'Nana Yaw', '25SOTVI0013', '2025-09-23 16:46:27');
INSERT INTO `tutorclass` VALUES ('3', 'sdscd', 'sdffd', 'cdvfdfgd', 'Nana Yaw', '25SOTVI0013', '2025-09-28 10:35:52');

-- Table structure for table `user_exam_enroll_table`
DROP TABLE IF EXISTS `user_exam_enroll_table`;
CREATE TABLE `user_exam_enroll_table` (
  `user_exam_enroll_id` int unsigned NOT NULL AUTO_INCREMENT,
  `online_exam_id` int unsigned DEFAULT NULL,
  `user_id` int unsigned DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`user_exam_enroll_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Table structure for table `user_exam_question_answer`
DROP TABLE IF EXISTS `user_exam_question_answer`;
CREATE TABLE `user_exam_question_answer` (
  `user_exam_question_answer_id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_exam_enroll_id` int unsigned DEFAULT NULL,
  `question_id` int unsigned DEFAULT NULL,
  `user_answer_option` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`user_exam_question_answer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Table structure for table `visitor_information`
DROP TABLE IF EXISTS `visitor_information`;
CREATE TABLE `visitor_information` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

