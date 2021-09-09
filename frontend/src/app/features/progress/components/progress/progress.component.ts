import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { finalize, tap } from 'rxjs/operators';

import { UiService } from '@app/core/main-layout/services';
import { CoursesService } from '@app/features/courses/services';
import { Course } from '@app/features/courses/types';

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
    private coursesService: CoursesService,
  ) {}

  ngOnInit(): void {
    this.courseId = this.route.snapshot.params['courseid'];
    this.fetchCourse();
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
}
