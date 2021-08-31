import { Component, OnDestroy, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Subscription } from 'rxjs';
import { finalize } from 'rxjs/operators';
import { MatDialog, MatDialogConfig } from '@angular/material/dialog';

import { UserInfoService } from '@app/core/auth/services/user-info.service';
import { UiService } from '@app/core/main-layout/services';
import { ConfirmDeleteComponent } from '@app/shared/components/confirm-delete';
import { ConfirmDeleteDialogConfig } from '@app/shared/types';
import { CoursesService } from '../../services';
import { Course } from '../../types';
import { CoursesAction } from '../../actions';

@Component({
  templateUrl: './list.component.html',
  styleUrls: ['./list.component.scss'],
})
export class CoursesListComponent implements OnInit, OnDestroy {

  CoursesAction = CoursesAction;
  isLoading = false;
  courses: Course[] | null = null;

  private subs: { [sub: string]: Subscription } = {};

  constructor(
    public userInfo: UserInfoService,
    private coursesService: CoursesService,
    private ui: UiService,
    private router: Router,
    private matDialog: MatDialog,
  ) {}

  ngOnInit(): void {
    this.ui.title = 'Courses';
    this.fetchCourses();
    this.subs.fab = this.ui.fabClicked$.subscribe(this.onCreateCourse.bind(this));
  }

  ngOnDestroy(): void {
    for (const sub of Object.values(this.subs)) {
      sub.unsubscribe();
    }
  }

  onShowStudents(courseId: string | number): void {
    console.log('onShowStudents', courseId);
    // ...
  }

  onLeaveCourse(courseId: string | number): void {
    console.log('onLeaveCourse', courseId);
    // ...
  }

  onShowBoard(courseId: string | number): void {
    this.router.navigate(['/courses', courseId, 'board']);
  }

  onEditTasks(courseId: string | number): void {
    this.router.navigate(['/courses', courseId, 'task-manager']);
  }

  onEditCourse(courseId: string | number): void {
    this.router.navigate(['/courses', courseId]);
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

        this.isLoading = true;
        this.coursesService.deleteCourse(course.course_id)
          .pipe(finalize(() => this.isLoading = false))
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

    this.isLoading = true;

    this.coursesService.getAllCourses()
      .pipe(finalize(() => this.isLoading = false))
      .subscribe({
        error: err => this.ui.setErrorToaster(err.error.error.message),
        next: courses => this.courses = courses,
      });
  }
}
