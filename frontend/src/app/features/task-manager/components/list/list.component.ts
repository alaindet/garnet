import { Component, OnDestroy, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { Subscription } from 'rxjs';
import { finalize } from 'rxjs/operators';
import { MatDialog, MatDialogConfig } from '@angular/material/dialog';

import { UiService } from '@app/core/main-layout/services';
import { ConfirmDeleteComponent } from '@app/shared/components/confirm-delete';
import { ConfirmDeleteDialogConfig, Task } from '@app/shared/types';
import { SelectedCourseService } from '@app/features/courses/services';
import { Course } from '@app/features/courses/types';
import { TaskManagerService } from '../../services';
import { TaskManagerAction } from '../../actions';

@Component({
  templateUrl: './list.component.html',
  styleUrls: ['./list.component.scss'],
})
export class TaskManagerListComponent implements OnInit, OnDestroy {

  courseId!: number | string;
  course!: Course;
  tasks!: Task[];

  private subs: { [sub: string]: Subscription } = {};

  constructor(
    public ui: UiService,
    private tasksService: TaskManagerService,
    private selectedCourseService: SelectedCourseService,
    private route: ActivatedRoute,
    private router: Router,
    private matDialog: MatDialog,
  ) {}

  ngOnInit(): void {
    this.courseId = this.route.snapshot.params['courseid'];
    this.fetchCourse();
    this.fetchTasks();
    this.manageFab();
  }

  private manageFab(): void {
    this.ui.fab = {
      actionName: TaskManagerAction.ShowCreateTaskForm,
      icon: 'add',
    };
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
    this.router.navigate(['/task-manager', courseId, 'tasks', 'create']);
  }

  onEditTask(index: number): void {

    if (!this.tasks?.length) {
      return;
    }

    const courseId = this.courseId;
    const taskId = this.tasks[index].task_id;
    this.router.navigate(['/task-manager', courseId, 'tasks', taskId]);
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
          task <strong>${task.name}</strong> \
          from course <strong>${course?.name}</strong>?
        `),
      },
    };

    this.matDialog.open(ConfirmDeleteComponent, config)
      .afterClosed()
      .subscribe(confirmed => {

        if (!confirmed) {
          return;
        }

        this.ui.loading = true;

        const dto = {
          courseId: this.courseId,
          taskId: task.task_id,
        };

        this.tasksService.deleteTask(dto)
          .pipe(finalize(() => this.ui.loading = false))
          .subscribe({
            error: err => this.ui.setErrorToaster(err.error.error.message),
            next: () => {
              const message = (`
                Task "${task.name}" was deleted
                from course "${course?.name}"
              `);
              this.ui.setSuccessToaster(message);
              this.fetchTasks();
            },
          });
      });
  }

  private fetchCourse(): void {
    this.subs.course = this.selectedCourseService.course$
      .subscribe(course => {
        if (!course) return;
        this.course = course;
        this.ui.title = `${course.name} - Tasks`;
        this.ui.breadcrumbs = [
          { label: 'Courses', url: '/courses' },
          { label: 'Tasks', url: ['/task-manager', this.courseId] },
        ];
      });
  }

  private fetchTasks(): void {
    this.ui.loading = true;
    this.tasksService.getTasksByCourseId(this.courseId)
      .pipe(finalize(() => this.ui.loading = false))
      .subscribe({
        error: err => this.ui.setErrorToaster(err.error.error.message),
        next: tasks => this.tasks = tasks,
      });
  }
}
