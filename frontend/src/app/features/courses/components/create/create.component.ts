import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { finalize } from 'rxjs/operators';

import { UiService } from '@app/core/main-layout/services';
import { CoursesService } from '../../services';
import { CreateCourseDto } from '../../types';

@Component({
  templateUrl: './create.component.html',
  styleUrls: ['./create.component.scss'],
})
export class CreateCourseComponent implements OnInit {

  isLoading = false;
  courseForm!: FormGroup;

  constructor(
    private ui: UiService,
    private coursesService: CoursesService,
    private router: Router,
  ) {}

  get name(): FormControl {
    return this.courseForm.get('name') as FormControl;
  }

  get description(): FormControl {
    return this.courseForm.get('description') as FormControl;
  }

  ngOnInit(): void {
    this.ui.title = 'Create course';
    this.initForm();
  }

  onCreateCourse(): void {

    if (this.courseForm.invalid || this.isLoading) {
      return;
    }

    this.isLoading = true;
    this.courseForm.disable();
    const dto: CreateCourseDto = this.courseForm.value;

    this.coursesService.createCourse(dto)
      .pipe(finalize(() => this.isLoading = false))
      .subscribe({
        next: () => {
          this.router.navigate(['/courses']);
          this.ui.snackbar = { message: 'Course created', type: 'success' };
        },
        error: err => {
          console.error(err);
          this.ui.snackbar = { message: 'Could not create course', type: 'error' };
          this.courseForm.enable();
        },
      });
  }

  private initForm(): void {
    this.courseForm = new FormGroup({
      name: new FormControl('', [Validators.required, Validators.minLength(3)]),
      description: new FormControl(''),
    });
  }
}
