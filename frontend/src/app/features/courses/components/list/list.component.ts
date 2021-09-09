import { Component, OnDestroy, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Subscription } from 'rxjs';
import { finalize } from 'rxjs/operators';
import { MatDialog, MatDialogConfig } from '@angular/material/dialog';

import { UserInfoService } from '@app/core/auth/services/user-info.service';
import { UiService } from '@app/core/main-layout/services';
import { ConfirmDeleteComponent } from '@app/shared/components/confirm-delete';
import { ConfirmDeleteDialogConfig } from '@app/shared/types';
import { CoursesService, SelectedCourseService } from '../../services';
import { Course } from '../../types';
import { CoursesAction } from '../../actions';
import { UserRole } from '@app/core/auth/types';

@Component({
  templateUrl: './list.component.html',
  styleUrls: ['./list.component.scss'],
})
export class CoursesListComponent implements OnInit, OnDestroy {

  CoursesAction = CoursesAction;
  courses: Course[] | null = null;

  private subs: { [sub: string]: Subscription } = {};

  constructor(
    public userInfo: UserInfoService,
    public ui: UiService,
    private coursesService: CoursesService,
    private selectedCourseService: SelectedCourseService,
    private router: Router,
    private matDialog: MatDialog,
  ) {}

  ngOnInit(): void {
    this.ui.title = 'Courses';
    this.ui.breadcrumbs = [
      { label: 'Courses', url: '/courses' },
    ];
    this.fetchCourses();
    this.manageFab();
  }

  ngOnDestroy(): void {

    this.ui.fab = null;

    for (const sub of Object.values(this.subs)) {
      sub.unsubscribe();
    }
  }

  onShowProgress(courseId: string | number): void {
    this.fetchAndCacheSelectedCourse(courseId, () => {
      this.router.navigate(['/courses', courseId, 'progress']);
    });
  }

  onShowBoard(courseId: string | number): void {
    this.fetchAndCacheSelectedCourse(courseId, () => {
      this.router.navigate(['/courses', courseId, 'board']);
    });
  }

  onEditTasks(courseId: string | number): void {
    this.fetchAndCacheSelectedCourse(courseId, () => {
      this.router.navigate(['/courses', courseId, 'task-manager']);
    });
  }

  onEditCourse(courseId: string | number): void {
    this.fetchAndCacheSelectedCourse(courseId, () => {
      this.router.navigate(['/courses', courseId]);
    });

  }

  onLeaveCourse(courseId: string | number): void {
    console.log('onLeaveCourse', courseId);
    // ...
  }

  onCreateCourse(action: string): void {
    if (action === CoursesAction.ShowCreateCourseForm) {
      this.router.navigate(['/courses/create']);
    }
  }

  onDeleteCourse(courseId: string | number): void {
    const course = this.courses?.find(c => c.course_id === courseId);

    if (!course) {
      return;
    }

    const config: MatDialogConfig<ConfirmDeleteDialogConfig> = {
      data: {
        title: 'Delete course',
        question: `Are you sure you want to delete course "${course.name}"?`,
      },
    };

    this.matDialog.open(ConfirmDeleteComponent, config)
      .afterClosed()
      .subscribe(confirmed => {

        if (!confirmed) {
          return;
        }

        this.ui.loading = true;
        this.coursesService.deleteCourse(course.course_id)
          .pipe(finalize(() => this.ui.loading = false))
          .subscribe({
            error: err => this.ui.setErrorToaster(err.error.error.message),
            next: () => {
              const message = `Course "<strong>${course.name}</strong>" deleted`;
              this.ui.setSuccessToaster(message);
              this.fetchCourses();
            },
          });
      });
  }

  private fetchCourses(): void {
    this.ui.loading = true;
    this.coursesService.getAllCourses()
      .pipe(finalize(() => this.ui.loading = false))
      .subscribe({
        error: err => this.ui.setErrorToaster(err.error.error.message),
        next: courses => this.courses = courses,
      });
  }

  private fetchAndCacheSelectedCourse(
    courseId: string | number,
    onSuccess: () => void,
  ): void {
    this.ui.loading = true;
    this.coursesService.getOneCourse(courseId)
      .pipe(finalize(() => {
        onSuccess();
        this.ui.loading = false;
      }))
      .subscribe({
        error: err => this.ui.setErrorToaster(err.error.error.message),
        next: course => this.selectedCourseService.course = course,
      });
  }

  private manageFab(): void {
    this.userInfo.roleId$.subscribe(roleId => {
      if (roleId && [UserRole.Admin, UserRole.Teacher].includes(roleId)) {
        this.ui.fab = {
          actionName: CoursesAction.ShowCreateCourseForm,
          icon: 'add',
        };
        this.subs.fab = this.ui.fabClicked$
          .subscribe(this.onCreateCourse.bind(this));
      }
    });
  }
}
