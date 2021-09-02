import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { finalize } from 'rxjs/operators';
import { CdkDragDrop, transferArrayItem } from '@angular/cdk/drag-drop';

import { UiService } from '@app/core/main-layout/services';
import { TasksService } from '../../services';
import { BoardTask } from '../../types';

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
  [TaskState.ToDo]: BoardTask[];
  [TaskState.InProgress]: BoardTask[];
  [TaskState.Done]: BoardTask[];
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

  onDropTask(event: CdkDragDrop<BoardTask[]>): void {

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
    const userId = 1;
    this.tasksService.getBoardTasksByUserId(this.courseId, userId)
      .pipe(finalize(() => this.isLoading = false))
      .subscribe({
        error: err => this.ui.setErrorToaster(err.error.error.message),
        next: tasks => {
          for (const task of tasks) {
            const taskState = +task.taskStateId as TaskState;
            this.boardState[taskState].push(task);
          }
        },
      });
  }
}
