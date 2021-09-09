import { Component, ElementRef, OnDestroy, OnInit, ViewChild } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { animationFrameScheduler, Subscription } from 'rxjs';
import { finalize, tap, throttleTime } from 'rxjs/operators';
import { CdkDragDrop, CdkDragStart, transferArrayItem } from '@angular/cdk/drag-drop';

import { UiService } from '@app/core/main-layout/services';
import { SelectedCourseService } from '@app/features/courses/services';
import { Course } from '@app/features/courses/types';
import { appFollowDraggedItem } from '@app/shared/utils';
import { TasksService } from '../../services';
import { BoardTask, BoardState, TaskState } from '../../types';

@Component({
  templateUrl: './board.component.html',
  styleUrls: ['./board.component.scss'],
})
export class BoardComponent implements OnInit, OnDestroy {

  @ViewChild('boardColumnsRef', { static: true })
  boardColumnsRef!: ElementRef;

  courseId!: string | number;
  course!: Course;
  TaskState = TaskState;
  boardState: BoardState = {
    [TaskState.ToDo]: [],
    [TaskState.InProgress]: [],
    [TaskState.Done]: [],
  };

  private subs: { [sub: string]: Subscription } = {};

  constructor(
    public ui: UiService,
    private route: ActivatedRoute,
    private tasksService: TasksService,
    private selectedCourseService: SelectedCourseService,
  ) {}

  ngOnInit(): void {
    this.courseId = this.route.snapshot.params['courseid'];
    this.fetchCourse();
    this.fetchTasks();
  }

  ngOnDestroy(): void {
    for (const sub of Object.values(this.subs)) {
      sub.unsubscribe();
    }
  }

  onDropTask(event: CdkDragDrop<TaskState>): void {

    const fromState = event.previousContainer.data;
    const fromContainer = this.boardState[fromState];
    const toState = event.container.data;
    const item = fromContainer[event.previousIndex];

    transferArrayItem(
      this.boardState[event.previousContainer.data],
      this.boardState[event.container.data],
      event.previousIndex,
      event.currentIndex
    );

    this.sortTasks();

    // Do not sync sorting on the backend
    if (event.previousContainer === event.container) {
      return;
    }

    this.ui.loading = true;

    this.tasksService.updateTaskStateById(this.courseId, item.taskId, toState)
      .pipe(tap(() => this.ui.loading = false))
      .subscribe({
        error: err => this.ui.setErrorToaster(err.error.error.message),
        next: () => {},
      });
  }

  private fetchCourse(): void {
    this.subs.course = this.selectedCourseService.course$
      .subscribe(course => {
        if (!course) return;
        this.course = course;
        this.ui.title = `${course.name} - Board`;
        this.ui.breadcrumbs = [
          { label: 'Courses', url: '/courses' },
          { label: 'Board', url: ['/board', this.courseId] },
        ];
      });
  }

  private sortTasks(): void {
    for (const taskState in this.boardState) {
      this.boardState[+taskState as TaskState]
        .sort((a: BoardTask, b: BoardTask) => {
          const aa = a.taskId;
          const bb = b.taskId;
          return (aa === bb) ? 0 : (aa > bb ? 1 : -1);
        });
    }
  }

  private fetchTasks(): void {
    this.ui.loading = true;
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
      .subscribe(appFollowDraggedItem(board, leftThreshold, rightThreshold));
  }

  onDragStop(event: CdkDragDrop<any>): void {
    this.dragSub?.unsubscribe();
  }
}
