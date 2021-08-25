import { Component, OnDestroy, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { forkJoin, Subscription } from 'rxjs';
import { finalize } from 'rxjs/operators';
import { MatDialog, MatDialogConfig } from '@angular/material/dialog';

import { UiService } from '@app/core/main-layout/services';
import { ConfirmDeleteComponent } from '@app/shared/components/confirm-delete';
import { ConfirmDeleteDialogConfig } from '@app/shared/types';
import { CoursesService } from '@app/features/courses/services';
import { Course } from '@app/features/courses/types';
import { TaskManagerService } from '../../services';
import { TaskListItem } from '../../types';

@Component({
  templateUrl: './list.component.html',
  styleUrls: ['./list.component.scss'],
})
export class TaskManagerListComponent implements OnInit, OnDestroy {

  courseId!: number | string;
  course?: Course;
  tasks?: TaskListItem[];
  isLoading = true;

  private subs: { [sub: string]: Subscription } = {};

  constructor(
    private tasksService: TaskManagerService,
    private coursesService: CoursesService,
    private route: ActivatedRoute,
    private ui: UiService,
    private router: Router,
    private matDialog: MatDialog,
  ) {}

  ngOnInit(): void {
    this.ui.title = 'Tasks';
    this.courseId = this.route.snapshot.params['courseid'];
    this.fetchTasks();
    this.subs.fab = this.ui.fabClicked$
      .subscribe(this.onCreateTask.bind(this));
  }

  ngOnDestroy(): void {
    for (const sub of Object.values(this.subs)) {
      sub.unsubscribe();
    }
  }

  onCreateTask(): void {
    const courseId = this.course?.course_id;
    this.router.navigate(['/courses', courseId, 'task-manager/create']);
  }

  onEditTask(index: number): void {

    if (!this.tasks?.length) {
      return;
    }

    const courseId = this.courseId;
    const taskId = this.tasks[index].task_id;
    this.router.navigate(['/courses', courseId, 'task-manager', taskId]);
  }

  onDeleteTask(index: number): void {

    if (!this.tasks?.length) {
      return;
    }

    const task = this.tasks[index];
    const course = this.course;

    const config: MatDialogConfig<ConfirmDeleteDialogConfig> = {
      data: {
        title: 'Delete task',
        question: (`
          Are you sure you want to delete \
          task "${task.name}" from course "${course?.name}"?
        `),
      },
    };

    this.matDialog.open(ConfirmDeleteComponent, config)
      .afterClosed()
      .subscribe(confirmed => {

        if (!confirmed) {
          return;
        }

        this.isLoading = true;

        const dto = {
          courseId: this.courseId,
          taskId: task.task_id,
        };

        this.tasksService.deleteTask(dto)
          .pipe(finalize(() => this.isLoading = false))
          .subscribe({
            error: err => this.ui.setSnackbarError(err.error.message),
            next: () => {
              const message = (`
                Task "${task.name}" was deleted
                from course "${course?.name}"
              `);
              this.ui.setSnackbarSuccess(message);
              this.fetchTasks();
            },
          });
      });
  }

  private fetchTasks(): void {

    this.isLoading = true;

    forkJoin([
      this.coursesService.getOneCourse(this.courseId),
      this.tasksService.getTasksByCourseId(this.courseId),
    ])
      .pipe(finalize(() => this.isLoading = false))
      .subscribe({
        error: err => this.ui.setSnackbarError(err.error.message),
        next: ([course, tasks]) => {
          this.course = course;
          this.tasks = tasks;
          this.ui.title = `Tasks of course "${course.name}"`;
        },
      });
  }
}
