-- Adminer 4.8.1 PostgreSQL 14.1 (Debian 14.1-1.pgdg110+1) dump

\connect "garnet";

CREATE TABLE "public"."course_student" (
    "course_id" integer NOT NULL,
    "student_id" integer NOT NULL,
    "created_on" timestamp NOT NULL,
    CONSTRAINT "course_student_pkey" PRIMARY KEY ("course_id", "student_id")
) WITH (oids = false);


CREATE SEQUENCE courses_course_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE SEQUENCE courses_teacher_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."courses" (
    "course_id" integer DEFAULT nextval('courses_course_id_seq') NOT NULL,
    "teacher_id" integer DEFAULT nextval('courses_teacher_id_seq') NOT NULL,
    "created_on" timestamp NOT NULL,
    "updated_on" timestamp NOT NULL,
    "name" text NOT NULL,
    "description" text NOT NULL,
    CONSTRAINT "courses_pkey" PRIMARY KEY ("course_id"),
    CONSTRAINT "name_unique" UNIQUE ("name")
) WITH (oids = false);


CREATE SEQUENCE invites_invite_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."invites" (
    "invite_id" integer DEFAULT nextval('invites_invite_id_seq') NOT NULL,
    "created_on" timestamp NOT NULL,
    "expires_on" timestamp NOT NULL,
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


CREATE TABLE "public"."task_user" (
    "task_id" integer NOT NULL,
    "task_state_id" integer NOT NULL,
    "user_id" integer NOT NULL,
    CONSTRAINT "task_user_user_id_task_id" PRIMARY KEY ("user_id", "task_id")
) WITH (oids = false);


CREATE SEQUENCE tasks_task_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."tasks" (
    "task_id" integer DEFAULT nextval('tasks_task_id_seq') NOT NULL,
    "course_id" integer NOT NULL,
    "created_on" timestamp NOT NULL,
    "updated_on" timestamp NOT NULL,
    "name" text NOT NULL,
    "description" text NOT NULL,
    CONSTRAINT "tasks_pkey" PRIMARY KEY ("task_id")
) WITH (oids = false);


CREATE SEQUENCE user_roles_user_role_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 32767 CACHE 1;

CREATE TABLE "public"."user_roles" (
    "user_role_id" smallint DEFAULT nextval('user_roles_user_role_id_seq') NOT NULL,
    "name" text NOT NULL,
    CONSTRAINT "user_roles_name" UNIQUE ("name"),
    CONSTRAINT "user_roles_pkey" PRIMARY KEY ("user_role_id")
) WITH (oids = false);


CREATE SEQUENCE users_user_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."users" (
    "user_id" integer DEFAULT nextval('users_user_id_seq') NOT NULL,
    "created_on" timestamp NOT NULL,
    "updated_on" timestamp NOT NULL,
    "first_name" text NOT NULL,
    "last_name" text NOT NULL,
    "email" text NOT NULL,
    "password" text NOT NULL,
    "user_role_id" smallint NOT NULL,
    CONSTRAINT "email_unique" UNIQUE ("email"),
    CONSTRAINT "users_pkey" PRIMARY KEY ("user_id")
) WITH (oids = false);


ALTER TABLE ONLY "public"."course_student" ADD CONSTRAINT "course_id" FOREIGN KEY (course_id) REFERENCES courses(course_id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE;

ALTER TABLE ONLY "public"."courses" ADD CONSTRAINT "teacher_id_fk" FOREIGN KEY (teacher_id) REFERENCES users(user_id) NOT DEFERRABLE;

ALTER TABLE ONLY "public"."invites" ADD CONSTRAINT "course_id" FOREIGN KEY (course_id) REFERENCES courses(course_id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE;
ALTER TABLE ONLY "public"."invites" ADD CONSTRAINT "user_role_id_fk" FOREIGN KEY (user_role_id) REFERENCES user_roles(user_role_id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE;

ALTER TABLE ONLY "public"."task_user" ADD CONSTRAINT "task_user_task_id_fkey" FOREIGN KEY (task_id) REFERENCES tasks(task_id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE;
ALTER TABLE ONLY "public"."task_user" ADD CONSTRAINT "task_user_user_id_fkey" FOREIGN KEY (user_id) REFERENCES users(user_id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE;

ALTER TABLE ONLY "public"."tasks" ADD CONSTRAINT "tasks_course_id_fkey" FOREIGN KEY (course_id) REFERENCES courses(course_id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE;

ALTER TABLE ONLY "public"."users" ADD CONSTRAINT "user_roles_fk" FOREIGN KEY (user_role_id) REFERENCES user_roles(user_role_id) NOT DEFERRABLE;

-- 2021-11-26 07:09:42.790155+00
