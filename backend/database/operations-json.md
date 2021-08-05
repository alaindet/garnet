Get all courses of teacher XXX
- /courses
  WHERE teacher_ID = XXX

Get all students of course XXX
- /courses/XXX/students => [SSS1, SSS2, ...]
- /users
  WHERE ID in [SSS1, SSS2, ...]

Get genereal progress of course XXX of student SSS
- /courses/XXX/students/SSS/tasks => [TTT1, TTT2, ...]
- /courses/XXX/tasks
