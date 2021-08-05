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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

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

CREATE TABLE `roles` (
  `role_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

INSERT INTO `roles` (`role_id`, `name`) VALUES
(1,	'Teacher'),
(2,	'Student');

CREATE TABLE `states` (
  `state_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  PRIMARY KEY (`state_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;

INSERT INTO `tasks` (`task_id`, `course_id`, `created_on`, `updated_on`, `name`, `description`) VALUES
(1,	1,	'2021-08-05 19:01:47',	'0000-00-00 00:00:00',	'Init repo',	'Initialize repository on GitHub'),
(2,	1,	'2021-08-05 19:01:47',	'0000-00-00 00:00:00',	'Scaffolding',	'Scaffold application via CLI'),
(3,	1,	'2021-08-05 19:01:47',	'0000-00-00 00:00:00',	'Feature: Create new todo',	'As a user, I want to create a new todo'),
(4,	1,	'2021-08-05 19:01:47',	'0000-00-00 00:00:00',	'Feature: Get all todos',	'As a user, I want to get a list of all todos'),
(5,	1,	'2021-08-05 19:01:47',	'0000-00-00 00:00:00',	'Feature: Get one todo',	'As a user, I want to get a single todo'),
(6,	1,	'2021-08-05 19:01:47',	'0000-00-00 00:00:00',	'Feature: Replace todo',	'As a user, I want to replace a todo'),
(7,	1,	'2021-08-05 19:01:47',	'0000-00-00 00:00:00',	'Feature: Delete todo',	'As a user, I want to delete a todo'),
(8,	1,	'2021-08-05 19:01:47',	'0000-00-00 00:00:00',	'Feature: Delete todos',	'As a user, I want to delete all todos'),
(9,	1,	'2021-08-05 19:01:47',	'0000-00-00 00:00:00',	'Feature: Authentication',	'As a user, I want to authenticate via username and password so that I get back a JWT access token'),
(10,	1,	'2021-08-05 19:01:47',	'0000-00-00 00:00:00',	'Feature: Validation',	'Validate todo CRUD operations'),
(11,	2,	'2021-08-05 19:02:08',	'0000-00-00 00:00:00',	'Init repo',	'Initialize repository on GitHub'),
(12,	2,	'2021-08-05 19:02:08',	'0000-00-00 00:00:00',	'Scaffolding',	'Scaffold application via CLI'),
(13,	2,	'2021-08-05 19:02:08',	'0000-00-00 00:00:00',	'Feature: Create new todo',	'As a user, I want to create a new todo'),
(14,	2,	'2021-08-05 19:02:08',	'0000-00-00 00:00:00',	'Feature: Get all todos',	'As a user, I want to get a list of all todos'),
(15,	2,	'2021-08-05 19:02:08',	'0000-00-00 00:00:00',	'Feature: Get one todo',	'As a user, I want to get a single todo'),
(16,	2,	'2021-08-05 19:02:08',	'0000-00-00 00:00:00',	'Feature: Replace todo',	'As a user, I want to replace a todo'),
(17,	2,	'2021-08-05 19:02:08',	'0000-00-00 00:00:00',	'Feature: Delete todo',	'As a user, I want to delete a todo'),
(18,	2,	'2021-08-05 19:02:08',	'0000-00-00 00:00:00',	'Feature: Delete todos',	'As a user, I want to delete all todos'),
(19,	2,	'2021-08-05 19:02:08',	'0000-00-00 00:00:00',	'Feature: Authentication',	'As a user, I want to authenticate via username and password so that I get back a JWT access token'),
(20,	2,	'2021-08-05 19:02:08',	'0000-00-00 00:00:00',	'Feature: Validation',	'Validate todo CRUD operations');

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
  `role_id` int(10) unsigned NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`user_id`, `created_on`, `updated_on`, `first_name`, `last_name`, `role_id`, `email`, `password`) VALUES
(1,	'2021-08-05 18:38:58',	'2021-08-05 18:38:58',	'John',	'Doe',	1,	'john.doe@example.com',	'*31A6A90D77875364DF4F5791DC5A425933F67EDA'),
(2,	'2021-08-05 18:39:22',	'2021-08-05 18:39:22',	'Jane',	'Doe',	1,	'jane.doe@example.com',	'*C69A47629F0A7A667753473F1CC2AE69EE7DC612'),
(3,	'2021-08-05 18:40:45',	'2021-08-05 18:40:45',	'Vanessa',	'Collin',	2,	'vanessa.collin@example.com',	'*648D7D679BFCD63A6298DD3083F981F5EF9ADD4C'),
(4,	'2021-08-05 18:42:50',	'2021-08-05 18:42:50',	'Quentin',	'Jude',	2,	'quentin.jude@example.com',	'*21230202279588192151EA3AC6E34C956645D0F2'),
(5,	'2021-08-05 18:43:40',	'2021-08-05 18:43:40',	'Maurice',	'Kennedy',	2,	'maurice.kennedy@example.com',	'maurice.kennedy@example.com'),
(6,	'2021-08-05 18:45:33',	'2021-08-05 18:45:33',	'Deborah',	'Travis',	2,	'deborah.travis@example.com',	'*330E7C247C4796D8FDB55165D722891B4725B4A7'),
(7,	'2021-08-05 18:46:24',	'2021-08-05 18:46:24',	'Sigmur',	'Roland',	2,	'sigmur.roland@example.com',	'*5803C1A03A9554E154273A4554964E82144EA103');

-- 2021-08-05 20:02:19