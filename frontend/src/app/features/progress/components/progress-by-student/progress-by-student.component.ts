import { Component, Input } from '@angular/core';
import { finalize } from 'rxjs/operators';

import { UiService } from '@app/core/main-layout/services';
import { ProgressService } from '../../services';
import { StudentProgress } from '../../types';

@Component({
  selector: 'app-progress-by-student',
  templateUrl: './progress-by-student.component.html',
  styleUrls: ['./progress-by-student.component.scss'],
})
export class ProgressByStudentComponent {

  @Input() courseId!: string | number;

  items: StudentProgress[] = [];

  constructor(
    public ui: UiService,
    private progressService: ProgressService,
  ) {}

  ngOnInit(): void {
    this.ui.title = '_COURSE_NAME_ - Progress by _FEATURE_';
    this.fetchProgressByStudent();
  }

  private fetchProgressByStudent(): void {
    this.ui.loading = true;
    this.progressService.getCourseProgressByStudent(this.courseId)
      .pipe(finalize(() => this.ui.loading = false))
      .subscribe({
        error: err => this.ui.setErrorToaster(err.error.message),
        next: items => this.items = items,
      });
  }
}
