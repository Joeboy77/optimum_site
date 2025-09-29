

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `courses` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `programType` varchar(150) DEFAULT NULL,
  `course_name` varchar(200) DEFAULT NULL,
  `programTypeID` int DEFAULT NULL,
  `course_code` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Essential data for table `courses`



CREATE TABLE `exam_categories` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `exam_results` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `exam_id` int unsigned NOT NULL,
  `student_id` varchar(100) NOT NULL,
  `score` int NOT NULL,
  `taken_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `exam_id` (`exam_id`),
  KEY `student_id` (`student_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `files_upload` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `file_title` varchar(200) DEFAULT NULL,
  `file_attachment` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `message` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `message` text,
  `messengerID` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `online_exam_table` (
  `online_exam_id` int unsigned NOT NULL AUTO_INCREMENT,
  `online_exam_datetime` datetime DEFAULT NULL,
  `marks_per_right_answer` int DEFAULT '1',
  `marks_per_wrong_answer` int DEFAULT '0',
  `online_exam_status` varchar(50) DEFAULT NULL,
  `total_question` int DEFAULT NULL,
  PRIMARY KEY (`online_exam_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `programtype` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `program` varchar(150) NOT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Essential data for table `programtype`



CREATE TABLE `question_table` (
  `question_id` int unsigned NOT NULL AUTO_INCREMENT,
  `online_exam_id` int unsigned DEFAULT NULL,
  `question_title` text,
  `answer_option` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Essential data for table `registration`



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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `tripirregularexpenses` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `itemname` varchar(150) DEFAULT NULL,
  `itemamount` decimal(12,2) DEFAULT NULL,
  `itemimage` varchar(255) DEFAULT NULL,
  `work_unit` varchar(100) DEFAULT NULL,
  `track` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `tutorclass` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `classname` varchar(150) DEFAULT NULL,
  `course_name` varchar(200) DEFAULT NULL,
  `course_code` varchar(50) DEFAULT NULL,
  `staff_name` varchar(200) DEFAULT NULL,
  `staffID` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `user_exam_enroll_table` (
  `user_exam_enroll_id` int unsigned NOT NULL AUTO_INCREMENT,
  `online_exam_id` int unsigned DEFAULT NULL,
  `user_id` int unsigned DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`user_exam_enroll_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `user_exam_question_answer` (
  `user_exam_question_answer_id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_exam_enroll_id` int unsigned DEFAULT NULL,
  `question_id` int unsigned DEFAULT NULL,
  `user_answer_option` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`user_exam_question_answer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `visitor_information` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

