-- Adminer 4.8.1 MySQL 5.5.5-10.6.3-MariaDB-1:10.6.3+maria~focal dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE DATABASE `garnet` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `garnet`;

CREATE TABLE `courses` (
  `course_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `teacher_id` int(10) unsigned NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `name` varchar(191) NOT NULL,
  PRIMARY KEY (`course_id`),
  KEY `teacher_id` (`teacher_id`),
  CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `courses` (`course_id`, `teacher_id`, `created_on`, `updated_on`, `name`) VALUES
(1,	1,	'2021-08-05 18:47:08',	'2021-08-05 18:47:08',	'React autumn 2021'),
(2,	2,	'2021-08-05 18:47:21',	'2021-08-05 18:47:21',	'Angular autumn 2021');

CREATE TABLE `course_student` (
  `course_id` int(10) unsigned NOT NULL,
  `student_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`course_id`,`student_id`),
  KEY `student_id` (`student_id`),
  CONSTRAINT `course_student_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `course_student_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `course_student` (`course_id`, `student_id`) VALUES
(1,	3),
(1,	4),
(1,	5),
(2,	6),
(2,	7);

CREATE TABLE `states` (
  `state_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  PRIMARY KEY (`state_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `states` (`state_id`, `name`) VALUES
(1,	'To Do'),
(2,	'In Progress'),
(3,	'Done');

CREATE TABLE `tasks` (
  `task_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int(10) unsigned NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `name` text NOT NULL,
  `description` varchar(191) NOT NULL,
  PRIMARY KEY (`task_id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tasks` (`task_id`, `course_id`, `created_on`, `updated_on`, `name`, `description`) VALUES
(1,	1,	'2021-08-06 16:30:34',	'2021-08-06 16:30:34',	'Init repo',	'Initialize repository on GitHub'),
(2,	1,	'2021-08-06 16:30:34',	'2021-08-06 16:30:34',	'Scaffolding',	'Scaffold application via CLI'),
(3,	1,	'2021-08-06 16:30:34',	'2021-08-06 16:30:34',	'Feature: Create new todo',	'As a user, I want to create a new todo'),
(4,	1,	'2021-08-06 16:30:34',	'2021-08-06 16:30:34',	'Feature: Get all todos',	'As a user, I want to get a list of all todos'),
(5,	1,	'2021-08-06 16:30:34',	'2021-08-06 16:30:34',	'Feature: Get one todo',	'As a user, I want to get a single todo'),
(6,	1,	'2021-08-06 16:30:34',	'2021-08-06 16:30:34',	'Feature: Replace todo',	'As a user, I want to replace a todo'),
(7,	1,	'2021-08-06 16:30:34',	'2021-08-06 16:30:34',	'Feature: Delete todo',	'As a user, I want to delete a todo'),
(8,	1,	'2021-08-06 16:30:34',	'2021-08-06 16:30:34',	'Feature: Delete todos',	'As a user, I want to delete all todos'),
(9,	1,	'2021-08-06 16:30:34',	'2021-08-06 16:30:34',	'Feature: Authentication',	'As a user, I want to authenticate via username and password so that I get back a JWT access token'),
(10,	1,	'2021-08-06 16:30:34',	'2021-08-06 16:30:34',	'Feature: Validation',	'Validate todo CRUD operations'),
(11,	2,	'2021-08-06 16:30:34',	'2021-08-06 16:30:34',	'Init repo',	'Initialize repository on GitHub'),
(12,	2,	'2021-08-06 16:30:34',	'2021-08-06 16:30:34',	'Scaffolding',	'Scaffold application via CLI'),
(13,	2,	'2021-08-06 16:30:34',	'2021-08-06 16:30:34',	'Feature: Create new todo',	'As a user, I want to create a new todo'),
(14,	2,	'2021-08-06 16:30:34',	'2021-08-06 16:30:34',	'Feature: Get all todos',	'As a user, I want to get a list of all todos'),
(15,	2,	'2021-08-06 16:30:34',	'2021-08-06 16:30:34',	'Feature: Get one todo',	'As a user, I want to get a single todo'),
(16,	2,	'2021-08-06 16:30:34',	'2021-08-06 16:30:34',	'Feature: Replace todo',	'As a user, I want to replace a todo'),
(17,	2,	'2021-08-06 16:30:34',	'2021-08-06 16:30:34',	'Feature: Delete todo',	'As a user, I want to delete a todo'),
(18,	2,	'2021-08-06 16:30:34',	'2021-08-06 16:30:34',	'Feature: Delete todos',	'As a user, I want to delete all todos'),
(19,	2,	'2021-08-06 16:30:34',	'2021-08-06 16:30:34',	'Feature: Authentication',	'As a user, I want to authenticate via username and password so that I get back a JWT access token'),
(20,	2,	'2021-08-06 16:30:34',	'2021-08-06 16:30:34',	'Feature: Validation',	'Validate todo CRUD operations');

CREATE TABLE `task_user` (
  `task_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `state_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`task_id`,`user_id`,`state_id`),
  KEY `user_id` (`user_id`),
  KEY `state_id` (`state_id`),
  KEY `task_id` (`task_id`),
  CONSTRAINT `task_user_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`task_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `task_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `task_user_ibfk_3` FOREIGN KEY (`state_id`) REFERENCES `states` (`state_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `task_user` (`task_id`, `user_id`, `state_id`) VALUES
(1,	3,	1),
(1,	4,	1),
(1,	5,	1),
(2,	3,	1),
(2,	4,	1),
(2,	5,	1),
(3,	3,	1),
(3,	4,	1),
(3,	5,	1),
(4,	3,	1),
(4,	4,	1),
(4,	5,	1),
(5,	3,	1),
(5,	4,	1),
(5,	5,	1),
(6,	3,	1),
(6,	4,	1),
(6,	5,	1),
(7,	3,	1),
(7,	4,	1),
(7,	5,	1),
(8,	3,	1),
(8,	4,	1),
(8,	5,	1),
(9,	3,	1),
(9,	4,	1),
(9,	5,	1),
(10,	3,	1),
(10,	4,	1),
(10,	5,	1),
(11,	6,	1),
(11,	7,	1),
(12,	6,	1),
(12,	7,	1),
(13,	6,	1),
(13,	7,	1),
(14,	6,	1),
(14,	7,	1),
(15,	6,	1),
(15,	7,	1),
(16,	6,	1),
(16,	7,	1),
(17,	6,	1),
(17,	7,	1),
(18,	6,	1),
(18,	7,	1),
(19,	6,	1),
(19,	7,	1),
(20,	6,	1),
(20,	7,	1);

CREATE TABLE `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `first_name` varchar(191) NOT NULL,
  `last_name` varchar(191) NOT NULL,
  `user_role_id` int(10) unsigned NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `role_id` (`user_role_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`user_role_id`) REFERENCES `user_roles` (`user_role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`user_id`, `created_on`, `updated_on`, `first_name`, `last_name`, `user_role_id`, `email`, `password`) VALUES
(1,	'2021-08-09 06:06:28',	'2021-08-05 18:38:58',	'John',	'Doe',	1,	'john.doe@example.com',	'$2y$10$FhLNAZnCGIL2F2RsreF2Ruw7a9jo9c1OFvWTIK/n1UC5YtDuyhDrC'),
(2,	'2021-08-09 06:06:29',	'2021-08-05 18:39:22',	'Jane',	'Doe',	1,	'jane.doe@example.com',	'$2y$10$4HvRqYMAcT1nFly2gYjWQeXuSMmZx1aGXjvg4IMaUK5AN6NKXpuwm'),
(3,	'2021-08-09 06:06:29',	'2021-08-05 18:40:45',	'Vanessa',	'Collin',	2,	'vanessa.collin@example.com',	'$2y$10$ZkFNL4YxWw9BcjflkMAUMekaKe1clXypXlDE7wzz1F3vxqPY3dHFe'),
(4,	'2021-08-09 06:06:29',	'2021-08-05 18:42:50',	'Quentin',	'Jude',	2,	'quentin.jude@example.com',	'$2y$10$hVtV4fIU6avxhaOoNIpQOehpDW6.5MpydO0SKCpN1Avh57E7XewSe'),
(5,	'2021-08-09 06:06:29',	'2021-08-05 18:43:40',	'Maurice',	'Kennedy',	2,	'maurice.kennedy@example.com',	'$2y$10$IR4G6NG/vc0DTDrrd5ejIeHGhx0M8AyXWxjlaUaYhpac0O9KQZgny'),
(6,	'2021-08-09 06:06:29',	'2021-08-05 18:45:33',	'Deborah',	'Travis',	2,	'deborah.travis@example.com',	'$2y$10$5i83YfzVVHkK4pXScVMkx.w6YhBxBtJoSkypX7PpQLR/oBVJhJD7q'),
(7,	'2021-08-09 06:06:29',	'2021-08-05 18:46:24',	'Sigmur',	'Roland',	2,	'sigmur.roland@example.com',	'$2y$10$W82XcQpq1v2mtbjYv16zDeW3SLBNZ/Kzbwy63NsF4mrUVP.1l0xo2');

CREATE TABLE `user_roles` (
  `user_role_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  PRIMARY KEY (`user_role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `user_roles` (`user_role_id`, `name`) VALUES
(1,	'Teacher'),
(2,	'Student');

CREATE TABLE `user_sessions` (
  `user_session_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hash` varchar(50) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `expires_on` datetime NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `user_role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_session_id`),
  KEY `user_id` (`user_id`),
  KEY `role_id` (`user_role_id`),
  CONSTRAINT `user_sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_sessions_ibfk_2` FOREIGN KEY (`user_role_id`) REFERENCES `user_roles` (`user_role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `user_sessions` (`user_session_id`, `hash`, `created_on`, `expires_on`, `user_id`, `user_role_id`) VALUES
(18,	'5c716b0e5f0192b3a22e72abce2a3bdd1ee16df2d0aede14fe',	'2021-08-10 07:15:39',	'2021-08-10 08:15:39',	1,	1),
(19,	'36a569895adb60bcb76193531e927f4f8cd559828ab7e1b43e',	'2021-08-10 11:16:32',	'2021-08-10 12:16:32',	1,	1);

-- 2021-08-10 11:35:32