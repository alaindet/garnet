import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { finalize } from 'rxjs/operators';
import { CdkDragDrop, transferArrayItem } from '@angular/cdk/drag-drop';

import { Task } from '@app/shared/types';
import { UiService } from '@app/core/main-layout/services';
import { TasksService } from '../../services';

// const MOCK_TASKS: Task[] = [
//   {
//     task_id: 1,
//     course_id: 1,
//     created_on: '2021-09-01 10:00',
//     updated_on: '2021-09-01 10:00',
//     name: 'First Step',
//     description: 'Perform the first step',
//   },
//   {
//     task_id: 2,
//     course_id: 1,
//     created_on: '2021-09-01 10:00',
//     updated_on: '2021-09-01 10:00',
//     name: 'Second Step',
//     description: 'Perform the second step',
//   },
// ];

export enum TaskState {
  ToDo = 1,
  InProgress = 2,
  Done = 3,
}

export const TASK_STATE = {
  [TaskState.ToDo]: 'To Do',
  [TaskState.InProgress]: 'In Progress',
  [TaskState.Done]: 'Done',
};

export interface BoardState {
  [TaskState.ToDo]: Task[];
  [TaskState.InProgress]: Task[];
  [TaskState.Done]: Task[];
}

@Component({
  templateUrl: './board.component.html',
  styleUrls: ['./board.component.scss'],
})
export class BoardComponent implements OnInit {

  isLoading = true;
  courseId!: string | number;
  TaskState = TaskState;
  boardState: BoardState = {
    [TaskState.ToDo]: [],
    [TaskState.InProgress]: [],
    [TaskState.Done]: [],
  };

  constructor(
    private ui: UiService,
    private route: ActivatedRoute,
    private tasksService: TasksService,
  ) {}

  ngOnInit(): void {
    this.courseId = this.route.snapshot.params['courseid'];
    this.ui.title = '_COURSE_NAME_ - Board'; // TODO
    this.fetchTasks();
  }

  onDropTask(event: CdkDragDrop<Task[]>): void {

    // Ignore movements inside the same list
    if (
      event.previousContainer === event.container ||
      !event.container.data ||
      !event.previousContainer.data
    ) {
      return;
    }

    transferArrayItem(
      event.previousContainer.data,
      event.container.data,
      event.previousIndex,
      event.currentIndex
    );
  }

  private fetchTasks(): void {
    this.isLoading = true;
    this.tasksService.getTasksByCourseId(this.courseId)
      .pipe(finalize(() => this.isLoading = false))
      .subscribe({
        error: err => this.ui.setErrorToaster(err.error.error.message),
        next: tasks => {
          console.log('tasks', tasks);
        },
      });
  }
}
