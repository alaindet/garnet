import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { Subscription } from 'rxjs';

import { UiService } from '@app/core/main-layout/services';
import { SelectedCourseService } from '@app/features/courses/services';
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

  private subs: { [sub: string]: Subscription } = {};

  constructor(
    public ui: UiService,
    private route: ActivatedRoute,
    private selectedCourseService: SelectedCourseService,
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
    this.subs.course = this.selectedCourseService.course$
      .subscribe(course => {
        if (!course) return;
        this.course = course;
        this.ui.title = `${course.name} - Progress`;
        this.ui.breadcrumbs = [
          { label: 'Courses', url: '/courses' },
          { label: 'Progress', url: ['/progress', this.courseId] },
        ];
      });
  }
}
