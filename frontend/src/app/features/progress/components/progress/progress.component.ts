import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { tap } from 'rxjs/operators';

import { UiService } from '@app/core/main-layout/services';
import { ProgressService } from '../../services';

@Component({
  templateUrl: './progress.component.html',
  styleUrls: ['./progress.component.scss'],
})
export class ProgressComponent implements OnInit {

  courseId!: string | number;

  constructor(
    private route: ActivatedRoute,
    private ui: UiService,
    private progressService: ProgressService,
  ) {}

  ngOnInit(): void {
    this.courseId = this.route.snapshot.params['courseid'];
    this.fetchProgress();
  }

  private fetchProgress(): void {
    this.ui.loading = true;

    this.progressService.getCourseProgress(this.courseId)
      .pipe(tap(() => this.ui.loading = false))
      .subscribe(data => console.log('data', data));
  }
}
