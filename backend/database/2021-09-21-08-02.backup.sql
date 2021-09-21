-- Adminer 4.8.0 MySQL 5.5.5-10.6.4-MariaDB-1:10.6.4+maria~focal dump

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
  `updated_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `name` varchar(191) NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`course_id`),
  KEY `teacher_id` (`teacher_id`),
  CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `courses` (`course_id`, `teacher_id`, `created_on`, `updated_on`, `name`, `description`) VALUES
(1,	2,	'2021-08-05 18:47:08',	'2021-08-05 18:47:08',	'React autumn 2021',	'Lorem ipsum dolor sit amet'),
(2,	3,	'2021-08-05 18:47:21',	'2021-08-05 18:47:21',	'Angular autumn 2021',	'Lorem ipsum dolor sit amet'),
(6,	2,	'2021-09-09 19:57:38',	'2021-09-09 19:57:38',	'New course',	'Some description');

CREATE TABLE `course_student` (
  `course_id` int(10) unsigned NOT NULL,
  `student_id` int(10) unsigned NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`course_id`,`student_id`),
  KEY `student_id` (`student_id`),
  CONSTRAINT `course_student_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `course_student_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `course_student` (`course_id`, `student_id`, `created_on`) VALUES
(1,	4,	'2021-08-19 22:46:00'),
(1,	5,	'2021-08-19 22:46:00'),
(1,	6,	'2021-08-19 22:46:00'),
(2,	7,	'2021-08-19 22:46:00'),
(2,	8,	'2021-08-19 22:46:00');

CREATE TABLE `invites` (
  `invite_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `expires_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `token` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `user_role_id` int(10) unsigned NOT NULL,
  `course_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`invite_id`),
  UNIQUE KEY `email` (`email`),
  KEY `user_role_id` (`user_role_id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `invites_ibfk_1` FOREIGN KEY (`user_role_id`) REFERENCES `user_roles` (`user_role_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `invites_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `invites` (`invite_id`, `created_on`, `expires_on`, `token`, `email`, `user_role_id`, `course_id`) VALUES
(2,	'2021-09-19 06:50:03',	'2021-09-19 06:50:03',	'kmZuIDJiR7LkLc5DwPWAlZqss88YUiHR',	'pincopallo@example.com',	3,	1),
(5,	'2021-09-20 05:09:40',	'2021-09-21 05:09:40',	'JGufUXrEYtQhrDtVqzJSjJpdCrvm3xBa',	'someone@example.com',	3,	1);

CREATE TABLE `tasks` (
  `task_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int(10) unsigned NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
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

CREATE TABLE `task_states` (
  `task_state_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  PRIMARY KEY (`task_state_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `task_states` (`task_state_id`, `name`) VALUES
(1,	'To Do'),
(2,	'In Progress'),
(3,	'Done');

CREATE TABLE `task_user` (
  `task_id` int(10) unsigned NOT NULL,
  `task_state_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`task_id`,`user_id`,`task_state_id`),
  KEY `user_id` (`user_id`),
  KEY `task_state_id` (`task_state_id`),
  KEY `task_id` (`task_id`),
  CONSTRAINT `task_user_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`task_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `task_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `task_user_ibfk_3` FOREIGN KEY (`task_state_id`) REFERENCES `task_states` (`task_state_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `task_user` (`task_id`, `task_state_id`, `user_id`) VALUES
(1,	3,	4),
(1,	1,	5),
(1,	1,	6),
(2,	3,	4),
(2,	1,	5),
(2,	1,	6),
(3,	1,	4),
(3,	1,	5),
(3,	1,	6),
(4,	2,	4),
(4,	1,	5),
(4,	1,	6),
(5,	2,	4),
(5,	1,	5),
(5,	1,	6),
(6,	1,	4),
(6,	1,	5),
(6,	1,	6),
(7,	1,	4),
(7,	1,	5),
(7,	1,	6),
(8,	1,	4),
(8,	1,	5),
(8,	1,	6),
(10,	1,	4),
(10,	1,	5),
(10,	1,	6),
(11,	1,	7),
(11,	1,	8),
(12,	1,	7),
(12,	1,	8),
(13,	1,	7),
(13,	1,	8),
(14,	1,	7),
(14,	1,	8),
(15,	1,	7),
(15,	1,	8),
(16,	1,	7),
(16,	1,	8),
(17,	1,	7),
(17,	1,	8),
(18,	1,	7),
(18,	1,	8),
(19,	1,	7),
(19,	1,	8),
(20,	1,	7),
(20,	1,	8);

CREATE TABLE `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `first_name` varchar(191) NOT NULL,
  `last_name` varchar(191) NOT NULL,
  `user_role_id` int(10) unsigned NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  KEY `role_id` (`user_role_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`user_role_id`) REFERENCES `user_roles` (`user_role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`user_id`, `created_on`, `updated_on`, `first_name`, `last_name`, `user_role_id`, `email`, `password`) VALUES
(1,	'2021-08-20 00:32:00',	'2021-08-20 00:32:00',	'Admin',	'Admin',	1,	'admin.admin@example.com',	'$2y$10$z.XhAtYEQYVkhlMb5Ur.0uuUiYEy57Ti4QmSuyABwBwlCnm.FQtMu'),
(2,	'2021-08-20 00:32:00',	'2021-08-20 00:32:00',	'John',	'Doe',	2,	'john.doe@example.com',	'$2y$10$FhLNAZnCGIL2F2RsreF2Ruw7a9jo9c1OFvWTIK/n1UC5YtDuyhDrC'),
(3,	'2021-08-20 00:32:00',	'2021-08-20 00:32:00',	'Jane',	'Doe',	2,	'jane.doe@example.com',	'$2y$10$4HvRqYMAcT1nFly2gYjWQeXuSMmZx1aGXjvg4IMaUK5AN6NKXpuwm'),
(4,	'2021-08-20 00:32:00',	'2021-08-20 00:32:00',	'Vanessa',	'Collin',	3,	'vanessa.collin@example.com',	'$2y$10$ZkFNL4YxWw9BcjflkMAUMekaKe1clXypXlDE7wzz1F3vxqPY3dHFe'),
(5,	'2021-08-20 00:32:00',	'2021-08-20 00:32:00',	'Quentin',	'Jude',	3,	'quentin.jude@example.com',	'$2y$10$hVtV4fIU6avxhaOoNIpQOehpDW6.5MpydO0SKCpN1Avh57E7XewSe'),
(6,	'2021-08-20 00:32:00',	'2021-08-20 00:32:00',	'Maurice',	'Kennedy',	3,	'maurice.kennedy@example.com',	'$2y$10$IR4G6NG/vc0DTDrrd5ejIeHGhx0M8AyXWxjlaUaYhpac0O9KQZgny'),
(7,	'2021-08-20 00:32:00',	'2021-08-20 00:32:00',	'Deborah',	'Travis',	3,	'deborah.travis@example.com',	'$2y$10$5i83YfzVVHkK4pXScVMkx.w6YhBxBtJoSkypX7PpQLR/oBVJhJD7q'),
(8,	'2021-08-20 00:32:00',	'2021-08-20 00:32:00',	'Sigmur',	'Roland',	3,	'sigmur.roland@example.com',	'$2y$10$W82XcQpq1v2mtbjYv16zDeW3SLBNZ/Kzbwy63NsF4mrUVP.1l0xo2');

CREATE TABLE `user_roles` (
  `user_role_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  PRIMARY KEY (`user_role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `user_roles` (`user_role_id`, `name`) VALUES
(1,	'Admin'),
(2,	'Teacher'),
(3,	'Student');

-- 2021-09-21 06:01:55
