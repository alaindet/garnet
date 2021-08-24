import { Component, OnDestroy, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { forkJoin, Subscription } from 'rxjs';
import { finalize } from 'rxjs/operators';

import { UiService } from '@app/core/main-layout/services';
import { Course } from '@app/features/courses/types';
import { TaskManagerService } from '../../services';
import { TaskListItem } from '../../types';
import { CoursesService } from '@app/features/courses/services';

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

    const courseId = this.course?.course_id;
    const taskId = this.tasks[index].taskId;
    this.router.navigate(['/courses', courseId, 'task-manager', taskId]);
  }

  onDeleteTask(index: number): void {
    console.log('onDeleteTask');
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
