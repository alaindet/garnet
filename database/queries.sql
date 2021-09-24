INSERT INTO task_user
SELECT * FROM tasks
WHERE condition;

/*
Clone tasks of course_id = 1 to user_id = 3 as state_id = 1 (To Do)
*/
INSERT INTO task_user
SELECT tasks.task_id AS task_id,
3 AS user_id,
1 AS state_id
FROM tasks
WHERE tasks.course_id = 1;

/*
Update state of task #1 of student #3 to state_id = 2 (Done)
*/
UPDATE task_user
SET state_id = 2
WHERE task_id = 1 AND user_id = 3;

/*
Get all courses of teacher #1
*/
SELECT *
FROM courses
WHERE teacher_id = 1;

/*
Get all student of teacher #1
*/
SELECT
cs.course_id,
cs.student_id
FROM
courses AS c
JOIN course_student AS cs ON c.course_id = cs.course_id
WHERE
c.teacher_id = 1
ORDER BY
cs.course_id ASC,
cs.student_id ASC;

/*
Get all students of course #1
*/
SELECT
c.name,
u.first_name,
u.last_name
FROM
course_student AS cs
JOIN courses AS c ON cs.course_id = c.course_id
JOIN users AS u ON cs.student_id = u.user_id
WHERE cs.course_id = 1;

/*
Get all students of all courses
*/
SELECT
c.name,
u.first_name,
u.last_name
FROM
course_student AS cs
JOIN courses AS c ON cs.course_id = c.course_id
JOIN users AS u ON cs.student_id = u.user_id;

/*
Get all courses of student #3
*/
SELECT
c.name
FROM
course_student AS cs
JOIN courses AS c ON cs.course_id = c.course_id
WHERE cs.student_id = 3;

/*
Get progress of student #3 on course #1
*/
SELECT
tu.task_id,
tu.state_id
FROM
courses AS c
JOIN tasks AS t ON t.course_id = c.course_id
JOIN task_user AS tu ON t.task_id = tu.task_id
WHERE
c.course_id = 1 AND
tu.user_id = 3;

/*
Get progress of every student on course #1
*/
SELECT
tu.task_id,
tu.user_id,
tu.task_state_id
FROM
tasks AS t
JOIN task_user AS tu ON tu.task_id = t.task_id
WHERE
t.course_id = 1
ORDER BY
t.task_id ASC

/*
Get task counters of course #1
*/
SELECT
sub.task_id,
SUM(IF(sub.state_id = 1, 1, 0)) AS to_do,
SUM(IF(sub.state_id = 2, 1, 0)) AS in_progress,
SUM(IF(sub.state_id = 3, 1, 0)) AS done
FROM
(
SELECT
tu.task_id,
tu.user_id,
tu.state_id
FROM
tasks AS t
JOIN task_user AS tu ON tu.task_id = t.task_id
WHERE
t.course_id = 1
ORDER BY
t.task_id ASC
) AS sub
GROUP BY
sub.task_id

-- Progress on course #1 by student
SELECT
u.user_id,
u.first_name,
u.last_name,
SUM(CASE WHEN task_state_id = 1 then 1 ELSE 0 END) AS to_do,
SUM(CASE WHEN task_state_id = 2 then 1 ELSE 0 END) AS in_progress,
SUM(CASE WHEN task_state_id = 3 then 1 ELSE 0 END) AS done
FROM tasks AS t
INNER JOIN task_user AS tu ON t.task_id = tu.task_id
INNER JOIN users AS u ON tu.user_id = u.user_id
WHERE t.course_id = 1
GROUP BY tu.user_id
ORDER BY tu.user_id ASC

-- Progress on course #1 by task
SELECT
t.task_id,
t.name,
t.description,
SUM(CASE WHEN task_state_id = 1 then 1 ELSE 0 END) AS to_do,
SUM(CASE WHEN task_state_id = 2 then 1 ELSE 0 END) AS in_progress,
SUM(CASE WHEN task_state_id = 3 then 1 ELSE 0 END) AS done
FROM tasks AS t
INNER JOIN task_user AS tu ON t.task_id = tu.task_id
WHERE t.course_id = 1
GROUP BY t.task_id
ORDER BY t.task_id ASC

-- Raw progress data
SELECT
tasks.task_id,
tasks.name,
tasks.description,
users.first_name,
users.last_name,
task_user.task_state_id
FROM tasks
INNER JOIN task_user ON tasks.task_id = task_user.task_id
INNER JOIN users ON task_user.user_id = users.user_id
WHERE tasks.course_id = 1
ORDER BY tasks.task_id ASC