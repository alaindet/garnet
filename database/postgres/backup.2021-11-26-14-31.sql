-- Adminer 4.8.1 PostgreSQL 14.1 (Debian 14.1-1.pgdg110+1) dump

\connect "garnet";

CREATE TABLE "public"."course_student" (
    "course_id" integer NOT NULL,
    "student_id" integer NOT NULL,
    "created_on" timestamp DEFAULT '(now())' NOT NULL,
    CONSTRAINT "course_student_pkey" PRIMARY KEY ("course_id", "student_id")
) WITH (oids = false);

INSERT INTO "course_student" ("course_id", "student_id", "created_on") VALUES
(1,	4,	'2021-11-26 12:34:39.948712'),
(1,	5,	'2021-11-26 12:34:39.948712'),
(1,	6,	'2021-11-26 12:34:39.948712'),
(2,	7,	'2021-11-26 12:34:39.948712'),
(2,	8,	'2021-11-26 12:34:39.948712');

CREATE SEQUENCE courses_course_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE SEQUENCE courses_teacher_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."courses" (
    "course_id" integer DEFAULT nextval('courses_course_id_seq') NOT NULL,
    "teacher_id" integer DEFAULT nextval('courses_teacher_id_seq') NOT NULL,
    "created_on" timestamp DEFAULT '(now())' NOT NULL,
    "updated_on" timestamp DEFAULT '(now())' NOT NULL,
    "name" text NOT NULL,
    "description" text NOT NULL,
    CONSTRAINT "courses_pkey" PRIMARY KEY ("course_id"),
    CONSTRAINT "name_unique" UNIQUE ("name")
) WITH (oids = false);

INSERT INTO "courses" ("course_id", "teacher_id", "created_on", "updated_on", "name", "description") VALUES
(1,	2,	'2021-11-26 12:33:15.262011',	'2021-11-26 12:33:15.262011',	'React winter 2021/2022',	'Lorem ipsum dolor sit amet'),
(2,	3,	'2021-11-26 12:33:15.262011',	'2021-11-26 12:33:15.262011',	'Angular winter 2021/2022',	'Lorem ipsum dolor sit amet');

CREATE SEQUENCE invites_invite_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."invites" (
    "invite_id" integer DEFAULT nextval('invites_invite_id_seq') NOT NULL,
    "created_on" timestamp DEFAULT '(now())' NOT NULL,
    "expires_on" timestamp DEFAULT '(now())' NOT NULL,
    "token" text NOT NULL,
    "email" text NOT NULL,
    "user_role_id" integer NOT NULL,
    "course_id" integer NOT NULL,
    CONSTRAINT "invites_email" UNIQUE ("email"),
    CONSTRAINT "invites_pkey" PRIMARY KEY ("invite_id")
) WITH (oids = false);


CREATE SEQUENCE task_states_task_state_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 32767 CACHE 1;

CREATE TABLE "public"."task_states" (
    "task_state_id" smallint DEFAULT nextval('task_states_task_state_id_seq') NOT NULL,
    "name" text NOT NULL,
    CONSTRAINT "task_states_name" UNIQUE ("name"),
    CONSTRAINT "task_states_pkey" PRIMARY KEY ("task_state_id")
) WITH (oids = false);

INSERT INTO "task_states" ("task_state_id", "name") VALUES
(1,	'To Do'),
(2,	'In Progress'),
(3,	'Done');

CREATE TABLE "public"."task_user" (
    "task_id" integer NOT NULL,
    "task_state_id" integer NOT NULL,
    "user_id" integer NOT NULL,
    CONSTRAINT "task_user_user_id_task_id" PRIMARY KEY ("user_id", "task_id")
) WITH (oids = false);

INSERT INTO "task_user" ("task_id", "task_state_id", "user_id") VALUES
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

CREATE SEQUENCE tasks_task_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."tasks" (
    "task_id" integer DEFAULT nextval('tasks_task_id_seq') NOT NULL,
    "course_id" integer NOT NULL,
    "created_on" timestamp DEFAULT '(now())' NOT NULL,
    "updated_on" timestamp DEFAULT '(now())' NOT NULL,
    "name" text NOT NULL,
    "description" text NOT NULL,
    CONSTRAINT "tasks_pkey" PRIMARY KEY ("task_id")
) WITH (oids = false);

INSERT INTO "tasks" ("task_id", "course_id", "created_on", "updated_on", "name", "description") VALUES
(1,	1,	'2021-11-26 13:22:14.440443',	'2021-11-26 13:22:14.440443',	'Init repo',	'Initialize repository on GitHub'),
(2,	1,	'2021-11-26 13:22:14.440443',	'2021-11-26 13:22:14.440443',	'Scaffolding',	'Scaffold application via CLI'),
(3,	1,	'2021-11-26 13:22:14.440443',	'2021-11-26 13:22:14.440443',	'Feature: Create new todo',	'As a user, I want to create a new todo'),
(4,	1,	'2021-11-26 13:22:14.440443',	'2021-11-26 13:22:14.440443',	'Feature: Get all todos',	'As a user, I want to get a list of all todos'),
(5,	1,	'2021-11-26 13:22:14.440443',	'2021-11-26 13:22:14.440443',	'Feature: Get one todo',	'As a user, I want to get a single todo'),
(6,	1,	'2021-11-26 13:22:14.440443',	'2021-11-26 13:22:14.440443',	'Feature: Replace todo',	'As a user, I want to replace a todo'),
(7,	1,	'2021-11-26 13:22:14.440443',	'2021-11-26 13:22:14.440443',	'Feature: Delete todo',	'As a user, I want to delete a todo'),
(8,	1,	'2021-11-26 13:22:14.440443',	'2021-11-26 13:22:14.440443',	'Feature: Delete todos',	'As a user, I want to delete all todos'),
(10,	1,	'2021-11-26 13:22:14.440443',	'2021-11-26 13:22:14.440443',	'Feature: Validation',	'Validate todo CRUD operations'),
(11,	2,	'2021-11-26 13:22:14.440443',	'2021-11-26 13:22:14.440443',	'Init repo',	'Initialize repository on GitHub'),
(12,	2,	'2021-11-26 13:22:14.440443',	'2021-11-26 13:22:14.440443',	'Scaffolding',	'Scaffold application via CLI'),
(13,	2,	'2021-11-26 13:22:14.440443',	'2021-11-26 13:22:14.440443',	'Feature: Create new todo',	'As a user, I want to create a new todo'),
(14,	2,	'2021-11-26 13:22:14.440443',	'2021-11-26 13:22:14.440443',	'Feature: Get all todos',	'As a user, I want to get a list of all todos'),
(15,	2,	'2021-11-26 13:22:14.440443',	'2021-11-26 13:22:14.440443',	'Feature: Get one todo',	'As a user, I want to get a single todo'),
(16,	2,	'2021-11-26 13:22:14.440443',	'2021-11-26 13:22:14.440443',	'Feature: Replace todo',	'As a user, I want to replace a todo'),
(17,	2,	'2021-11-26 13:22:14.440443',	'2021-11-26 13:22:14.440443',	'Feature: Delete todo',	'As a user, I want to delete a todo'),
(18,	2,	'2021-11-26 13:22:14.440443',	'2021-11-26 13:22:14.440443',	'Feature: Delete todos',	'As a user, I want to delete all todos'),
(19,	2,	'2021-11-26 13:22:14.440443',	'2021-11-26 13:22:14.440443',	'Feature: Authentication',	'As a user, I want to authenticate via username and password so that I get back a JWT access token'),
(20,	2,	'2021-11-26 13:22:14.440443',	'2021-11-26 13:22:14.440443',	'Feature: Validation',	'Validate todo CRUD operations');

CREATE SEQUENCE user_roles_user_role_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 32767 CACHE 1;

CREATE TABLE "public"."user_roles" (
    "user_role_id" smallint DEFAULT nextval('user_roles_user_role_id_seq') NOT NULL,
    "name" text NOT NULL,
    CONSTRAINT "user_roles_name" UNIQUE ("name"),
    CONSTRAINT "user_roles_pkey" PRIMARY KEY ("user_role_id")
) WITH (oids = false);

INSERT INTO "user_roles" ("user_role_id", "name") VALUES
(1,	'Admin'),
(2,	'Teacher'),
(3,	'Student');

CREATE SEQUENCE users_user_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."users" (
    "user_id" integer DEFAULT nextval('users_user_id_seq') NOT NULL,
    "created_on" timestamp DEFAULT '(now())' NOT NULL,
    "updated_on" timestamp DEFAULT '(now())' NOT NULL,
    "first_name" text NOT NULL,
    "last_name" text NOT NULL,
    "email" text NOT NULL,
    "password" text NOT NULL,
    "user_role_id" smallint NOT NULL,
    CONSTRAINT "email_unique" UNIQUE ("email"),
    CONSTRAINT "users_pkey" PRIMARY KEY ("user_id")
) WITH (oids = false);

INSERT INTO "users" ("user_id", "created_on", "updated_on", "first_name", "last_name", "email", "password", "user_role_id") VALUES
(1,	'2021-11-26 12:29:25.708895',	'2021-11-26 12:29:25.708895',	'Admin',	'Admin',	'admin.admin@example.com',	'change_this',	1),
(2,	'2021-11-26 12:29:25.708895',	'2021-11-26 12:29:25.708895',	'John',	'Doe',	'john.doe@example.com',	'change_this',	2),
(3,	'2021-11-26 12:29:25.708895',	'2021-11-26 12:29:25.708895',	'Jane',	'Doe',	'jane.doe@example.com',	'change_this',	2),
(4,	'2021-11-26 12:29:25.708895',	'2021-11-26 12:29:25.708895',	'Vanessa',	'Collins',	'vanessa.collins@example.com',	'change_this',	3),
(5,	'2021-11-26 12:29:25.708895',	'2021-11-26 12:29:25.708895',	'Quentin',	'Jude',	'quentin.jude@example.com',	'change_this',	3),
(6,	'2021-11-26 12:29:25.708895',	'2021-11-26 12:29:25.708895',	'Maurice',	'Kennedy',	'maurice.kennedy@example.com',	'change_this',	3),
(7,	'2021-11-26 12:29:25.708895',	'2021-11-26 12:29:25.708895',	'Deborah',	'Travis',	'deborah.travis@example.com',	'change_this',	3),
(8,	'2021-11-26 12:29:25.708895',	'2021-11-26 12:29:25.708895',	'Sigmur',	'Roland',	'sigmur.roland@example.com',	'change_this',	3);

ALTER TABLE ONLY "public"."course_student" ADD CONSTRAINT "course_id" FOREIGN KEY (course_id) REFERENCES courses(course_id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE;

ALTER TABLE ONLY "public"."courses" ADD CONSTRAINT "courses_teacher_id_fkey" FOREIGN KEY (teacher_id) REFERENCES users(user_id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE;

ALTER TABLE ONLY "public"."invites" ADD CONSTRAINT "course_id" FOREIGN KEY (course_id) REFERENCES courses(course_id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE;
ALTER TABLE ONLY "public"."invites" ADD CONSTRAINT "user_role_id_fk" FOREIGN KEY (user_role_id) REFERENCES user_roles(user_role_id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE;

ALTER TABLE ONLY "public"."task_user" ADD CONSTRAINT "task_user_task_id_fkey" FOREIGN KEY (task_id) REFERENCES tasks(task_id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE;
ALTER TABLE ONLY "public"."task_user" ADD CONSTRAINT "task_user_task_state_id_fkey" FOREIGN KEY (task_state_id) REFERENCES task_states(task_state_id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE;
ALTER TABLE ONLY "public"."task_user" ADD CONSTRAINT "task_user_user_id_fkey" FOREIGN KEY (user_id) REFERENCES users(user_id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE;

ALTER TABLE ONLY "public"."tasks" ADD CONSTRAINT "tasks_course_id_fkey" FOREIGN KEY (course_id) REFERENCES courses(course_id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE;

ALTER TABLE ONLY "public"."users" ADD CONSTRAINT "user_roles_fk" FOREIGN KEY (user_role_id) REFERENCES user_roles(user_role_id) NOT DEFERRABLE;

-- 2021-11-26 13:31:30.150228+00
