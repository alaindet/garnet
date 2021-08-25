import { Component, OnDestroy, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Subscription } from 'rxjs';
import { finalize } from 'rxjs/operators';
import { MatDialog, MatDialogConfig } from '@angular/material/dialog';

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
    private coursesService: CoursesService,
    private ui: UiService,
    private router: Router,
    private matDialog: MatDialog,
  ) {}

  ngOnInit(): void {
    this.ui.title = 'Courses';
    this.fetchCourses();
    this.subs.fab = this.ui.fabClicked$.subscribe(this.onFabClick.bind(this));
  }

  ngOnDestroy(): void {
    for (const sub of Object.values(this.subs)) {
      sub.unsubscribe();
    }
  }

  onMenuActionClicked(action: CoursesAction, courseId: string | number): void {
    switch (action) {
      case CoursesAction.ShowEditCourseForm:
        this.router.navigate(['/courses', courseId]);
        break;
      case CoursesAction.ShowDeleteCourse:
        this.deleteCourse(courseId);
        break;
    }
  }

  onEditTasks(courseId: string | number): void {
    this.router.navigate(['/courses', courseId, 'task-manager']);
  }

  onShowStudents(): void {
    console.log(CoursesAction.ShowStudents);
    // ...
  }

  onFabClick(action: string): void {
    if (action === CoursesAction.ShowCreateCourseForm) {
      this.router.navigate(['/courses/create']);
    }
  }

  private fetchCourses(): void {

    this.isLoading = true;

    this.coursesService.getAllCourses()
      .pipe(finalize(() => this.isLoading = false))
      .subscribe({
        error: err => this.ui.setSnackbarError(err.error.message),
        next: courses => this.courses = courses,
      });
  }

  private deleteCourse(courseId: string | number): void {
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
            error: err => this.ui.setSnackbarError(err.error.message),
            next: () => {
              const message = `Course "<strong>${course.name}</strong>" was deleted`;
              this.ui.setSnackbarSuccess(message);
              this.fetchCourses();
            },
          });
      });
  }
}
