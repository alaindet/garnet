import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { finalize, tap } from 'rxjs/operators';

import { UiService } from '@app/core/main-layout/services';
import { CoursesService } from '@app/features/courses/services';
import { Course } from '@app/features/courses/types';
import { ProgressService } from '../../services';

@Component({
  templateUrl: './progress.component.html',
  styleUrls: ['./progress.component.scss'],
})
export class ProgressComponent implements OnInit {

  courseId!: string | number;
  course!: Course;
  tabIndex = 0;
  tabsLoaded = [true, false];

  constructor(
    public ui: UiService,
    private route: ActivatedRoute,
    private progressService: ProgressService,
    private coursesService: CoursesService,
  ) {}

  ngOnInit(): void {
    this.courseId = this.route.snapshot.params['courseid'];
    this.fetchCourse();
    this.fetchProgressByTask();
  }

  onTabChange(tabIndex: number): void {
    this.tabIndex = tabIndex;
    this.tabsLoaded[tabIndex] = true;
  }

  private fetchCourse(): void {
    this.ui.loading = true;
    this.coursesService.getOneCourse(this.courseId)
      .pipe(finalize(() => this.ui.loading = false))
      .subscribe(course => {
        this.course = course;
        this.ui.title = `${course.name} - Progress`;
      });
  }

  private fetchProgressByTask(): void {
    this.ui.loading = true;
    this.progressService.getCourseProgressByTask(this.courseId)
      .pipe(finalize(() => this.ui.loading = false))
      .subscribe({
        error: err => this.ui.setErrorToaster(err.error.message),
        next: tasks => {
          console.log('tasks', tasks);
        },
      });
  }
}
