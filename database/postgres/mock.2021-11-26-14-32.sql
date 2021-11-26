INSERT INTO "public"."user_roles" ("user_role_id", "name")
VALUES
(1,	'Admin'),
(2,	'Teacher'),
(3,	'Student');

INSERT INTO "public"."users" ("user_id", "first_name", "last_name", "user_role_id", "email", "password")
VALUES
(1, 'Admin', 'Admin', 1, 'admin.admin@example.com', 'change_this'),
(2, 'John', 'Doe', 2, 'john.doe@example.com', 'change_this'),
(3, 'Jane', 'Doe', 2, 'jane.doe@example.com', 'change_this'),
(4, 'Vanessa', 'Collins', 3, 'vanessa.collins@example.com', 'change_this'),
(5, 'Quentin', 'Jude', 3, 'quentin.jude@example.com', 'change_this'),
(6, 'Maurice', 'Kennedy', 3, 'maurice.kennedy@example.com', 'change_this'),
(7, 'Deborah', 'Travis', 3, 'deborah.travis@example.com', 'change_this'),
(8, 'Sigmur', 'Roland', 3, 'sigmur.roland@example.com', 'change_this');

INSERT INTO "public"."task_states" ("task_state_id", "name")
VALUES
(1,	'To Do'),
(2,	'In Progress'),
(3,	'Done');

INSERT INTO "public"."courses" ("course_id", "teacher_id", "name", "description")
VALUES
(1, 2, 'React winter 2021/2022', 'Lorem ipsum dolor sit amet'),
(2, 3, 'Angular winter 2021/2022', 'Lorem ipsum dolor sit amet');

INSERT INTO "public"."course_student" ("course_id", "student_id")
VALUES
(1, 4),
(1, 5),
(1, 6),
(2, 7),
(2, 8);

INSERT INTO "public"."tasks" ("task_id", "course_id", "name", "description")
VALUES
(1,	1, 'Init repo',	'Initialize repository on GitHub'),
(2,	1, 'Scaffolding',	'Scaffold application via CLI'),
(3,	1, 'Feature: Create new todo',	'As a user, I want to create a new todo'),
(4,	1, 'Feature: Get all todos',	'As a user, I want to get a list of all todos'),
(5,	1, 'Feature: Get one todo',	'As a user, I want to get a single todo'),
(6,	1, 'Feature: Replace todo',	'As a user, I want to replace a todo'),
(7,	1, 'Feature: Delete todo',	'As a user, I want to delete a todo'),
(8,	1, 'Feature: Delete todos',	'As a user, I want to delete all todos'),
(10,	1, 'Feature: Validation',	'Validate todo CRUD operations'),
(11,	2, 'Init repo',	'Initialize repository on GitHub'),
(12,	2, 'Scaffolding',	'Scaffold application via CLI'),
(13,	2, 'Feature: Create new todo',	'As a user, I want to create a new todo'),
(14,	2, 'Feature: Get all todos',	'As a user, I want to get a list of all todos'),
(15,	2, 'Feature: Get one todo',	'As a user, I want to get a single todo'),
(16,	2, 'Feature: Replace todo',	'As a user, I want to replace a todo'),
(17,	2, 'Feature: Delete todo',	'As a user, I want to delete a todo'),
(18,	2, 'Feature: Delete todos',	'As a user, I want to delete all todos'),
(19,	2, 'Feature: Authentication',	'As a user, I want to authenticate via username and password so that I get back a JWT access token'),
(20,	2, 'Feature: Validation',	'Validate todo CRUD operations');

INSERT INTO "public"."task_user" ("task_id", "task_state_id", "user_id")
VALUES
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
