import { Component, Input } from '@angular/core';
import { finalize } from 'rxjs/operators';

import { UiService } from '@app/core/main-layout/services';
import { ProgressService } from '../../services';
import { TaskProgress } from '../../types';

@Component({
  selector: 'app-progress-by-task',
  templateUrl: './progress-by-task.component.html',
  styleUrls: ['./progress-by-task.component.scss'],
})
export class ProgressByTaskComponent {

  @Input() courseId!: string | number;

  items: TaskProgress[] = [];

  constructor(
    public ui: UiService,
    private progressService: ProgressService,
  ) { }

  ngOnInit(): void {
    this.ui.title = '_COURSE_NAME_ - Progress by _FEATURE_';
    this.fetchProgressByTask();
  }

  private fetchProgressByTask(): void {
    this.ui.loading = true;
    this.progressService.getCourseProgressByTask(this.courseId)
      .pipe(finalize(() => this.ui.loading = false))
      .subscribe({
        error: err => this.ui.setErrorToaster(err.error.message),
        next: items => this.items = items,
      });
  }
}
