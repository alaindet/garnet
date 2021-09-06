import { Component, ElementRef, OnInit, ViewChild } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { animationFrameScheduler, Subscription } from 'rxjs';
import { finalize, tap, throttleTime } from 'rxjs/operators';
import { CdkDragDrop, CdkDragStart, transferArrayItem } from '@angular/cdk/drag-drop';

import { UiService } from '@app/core/main-layout/services';
import { followDraggedItem } from '@app/shared/utils';
import { TasksService } from '../../services';
import { BoardTask, BoardState, TaskState } from '../../types';

@Component({
  templateUrl: './board.component.html',
  styleUrls: ['./board.component.scss'],
})
export class BoardComponent implements OnInit {

  @ViewChild('boardColumnsRef', { static: true })
  boardColumnsRef!: ElementRef;

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

  onDropTask(event: CdkDragDrop<TaskState>): void {

    const fromContainerIndex = event.previousContainer.data;
    const fromContainer = this.boardState[fromContainerIndex];
    const toContainerIndex = event.container.data;
    const toContainer = this.boardState[toContainerIndex];
    const fromContainerItemIndex = event.previousIndex;
    const item = fromContainer[fromContainerItemIndex];

    this.ui.loading = true;
    this.tasksService.updateTaskStateById(this.courseId, item.taskId, toContainerIndex)
      .pipe(tap(() => this.ui.loading = false))
      .subscribe({
        error: err => this.ui.setErrorToaster(err.error.error.message),
        next: () => console.log('task state updated'),
      });

    transferArrayItem(
      this.boardState[event.previousContainer.data],
      this.boardState[event.container.data],
      event.previousIndex,
      event.currentIndex
    );
  }

  private fetchTasks(): void {
    this.ui.loading = true;
    const userId = 1;
    this.tasksService.getBoardTasks(this.courseId)
      .pipe(finalize(() => this.ui.loading = false))
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

  private dragSub?: Subscription;

  onDragStart(event: CdkDragStart<HTMLElement>): void {

    this.dragSub?.unsubscribe();

    const board = this.boardColumnsRef.nativeElement;
    const windowWidth = window.innerWidth;
    const leftThreshold = 0.15 * windowWidth;
    const rightThreshold = 0.90 * windowWidth;

    this.dragSub = event.source.moved
      .pipe(throttleTime(0, animationFrameScheduler))
      .subscribe(followDraggedItem(board, leftThreshold, rightThreshold));
  }

  onDragStop(event: CdkDragDrop<any>): void {
    this.dragSub?.unsubscribe();
  }
}
