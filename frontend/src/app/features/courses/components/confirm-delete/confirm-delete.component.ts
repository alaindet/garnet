import { ChangeDetectionStrategy, Component, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { finalize } from 'rxjs/operators';

import { UiService } from '@app/core/main-layout/services';
import { CoursesService } from '../../services';
import { Course } from '../../types';

@Component({
  templateUrl: './confirm-delete.component.html',
  styleUrls: ['./confirm-delete.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class ConfirmDeleteComponent {

  isLoading = false;

  constructor(
    @Inject(MAT_DIALOG_DATA) public data: Course,
    private matDialogRef: MatDialogRef<ConfirmDeleteComponent, Course>,
    private coursesService: CoursesService,
    private ui: UiService,
  ) {}

  onConfirm(): void {
    this.coursesService.deleteCourse(this.data.course_id)
      .pipe(finalize(() => this.isLoading = false))
      .subscribe({
        error: err => this.ui.setSnackbarError(err.error.message),
        next: () => {
          const message = `Course <strong>${this.data.name}</strong> was deleted`;
          this.ui.setSnackbarSuccess(message);
          this.matDialogRef.close(this.data);
        },
      });
  }
}
