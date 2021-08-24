import { Component, OnDestroy, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
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
  isLoading = false;

  private subs: { [sub: string]: Subscription } = {};

  constructor(
    private tasksService: TaskManagerService,
    private coursesService: CoursesService,
    private route: ActivatedRoute,
    private ui: UiService,
  ) {}

  ngOnInit(): void {
    this. courseId = this.route.snapshot.params['courseid'];
    this.fetchTasks();
  }

  ngOnDestroy(): void {
    for (const sub of Object.values(this.subs)) {
      sub.unsubscribe();
    }
  }

  private fetchTasks(): void {

    this.isLoading = true;

    const courseRequest = this.coursesService.getOneCourse(this.courseId);
    const tasksRequest = this.tasksService.getTasksByCourseId(this.courseId);

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

          console.log(course, tasks);
        },
      });
  }
}
