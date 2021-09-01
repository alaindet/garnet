import { Component, OnInit } from '@angular/core';
import { CdkDragDrop, transferArrayItem } from '@angular/cdk/drag-drop';
import { Task } from '@app/shared/types';

const MOCK_TASKS: Task[] = [
  {
    task_id: 1,
    course_id: 1,
    created_on: '2021-09-01 10:00',
    updated_on: '2021-09-01 10:00',
    name: 'First Step',
    description: 'Perform the first step',
  },
  {
    task_id: 2,
    course_id: 1,
    created_on: '2021-09-01 10:00',
    updated_on: '2021-09-01 10:00',
    name: 'Second Step',
    description: 'Perform the second step',
  },
];

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

  TaskState = TaskState;

  boardState: BoardState = {
    [TaskState.ToDo]: MOCK_TASKS,
    [TaskState.InProgress]: [],
    [TaskState.Done]: [],
  };

  ngOnInit(): void {
    // ...
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
}
