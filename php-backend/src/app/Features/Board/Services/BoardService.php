<?php

namespace App\Features\Board\Services;

use App\Features\Board\Models\BoardTask;
use App\Features\Tasks\Repositories\TasksRepository;
use App\Features\Board\Dtos\GetBoardTasksRequestDto;
use App\Features\Board\Dtos\GetBoardTasksResponseDto;
use App\Features\Board\Dtos\UpdateTaskStateDto;
use App\Features\Board\Dtos\GetProgressByStudentDto;
use App\Features\Board\Dtos\GetProgressByTaskDto;
use App\Features\Board\Models\StudentProgress;
use App\Features\Board\Models\TaskProgress;
use App\Features\Courses\Repositories\CoursesRepository;
use App\Shared\Utils\Time;

class BoardService
{
    private TasksRepository $tasksRepo;

    public function __construct()
    {
        $this->tasksRepo = new TasksRepository();
    }

    public function getTasksByBoard(
        GetBoardTasksRequestDto $dtoIn,
    ): GetBoardTasksResponseDto
    {
        $data = $this->tasksRepo->getAllByCourseIdAndUserId($dtoIn);

        $parsedData = [];

        foreach ($data as $item) {
            $task = new BoardTask();
            $task->taskId = $item['task_id'];
            $task->taskStateId = $item['task_state_id'];
            $task->createdOn = Time::getTimestamp($item['created_on']);
            $task->updatedOn = Time::getTimestamp($item['updated_on']);
            $task->name = $item['name'];
            $task->description = $item['description'];
            $parsedData[] = $task;
        }

        return new GetBoardTasksResponseDto(...$parsedData);
    }

    public function updateTaskState(UpdateTaskStateDto $dto): bool
    {
        return $this->tasksRepo->updateStateByIdAndUserId($dto);
    }

    public function getProgressByStudent(
        string|int $courseId,
    ): GetProgressByStudentDto
    {
        $data = $this->tasksRepo->getProgressByStudent($courseId);
        $parsedData = [];

        foreach ($data as $item) {
            $progress = new StudentProgress();
            $progress->userId = $item['user_id'];
            $progress->firstName = $item['first_name'];
            $progress->lastName = $item['last_name'];
            $progress->tasksToDo = (int) $item['to_do'];
            $progress->tasksInProgress = (int) $item['in_progress'];
            $progress->tasksDone = (int) $item['done'];
            $parsedData[] = $progress;
        }

        return new GetProgressByStudentDto(...$parsedData);
    }

    public function getProgressByTask(string|int $courseId): GetProgressByTaskDto
    {
        $data = $this->tasksRepo->getProgressByTask($courseId);
        $parsedData = [];

        foreach ($data as $item) {
            $progress = new TaskProgress();
            $progress->taskId = $item['task_id'];
            $progress->taskName = $item['name'];
            $progress->taskDescription = $item['description'];
            $progress->studentsToDo = (int) $item['to_do'];
            $progress->studentsInProgress = (int) $item['in_progress'];
            $progress->studentsDone = (int) $item['done'];
            $parsedData[] = $progress;
        }

        return new GetProgressByTaskDto(...$parsedData);
    }

    public function doTeacherAndStudentBelongToCourse(
        string|int $teacherId,
        string|int $studentId,
        string|int $courseId,
    ): bool
    {
        $coursesRepo = new CoursesRepository();
        $assoc = $coursesRepo->getStudentAndTeacherAssociation($studentId, $courseId);

        if (
            !isset($assoc) ||
            $assoc['course_id'] != $courseId ||
            $assoc['student_id'] != $studentId ||
            $assoc['teacher_id'] != $teacherId
        ) {
            return false;
        }

        return true;
    }
}
