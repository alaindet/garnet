import { Component, OnInit } from '@angular/core';
import { Location } from '@angular/common';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { Router } from '@angular/router';
// import { MessageService } from 'primeng/api';

import { UiService } from '@app/core/main-layout/services';
import { finalize } from 'rxjs/operators';
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
    private location: Location,
    private coursesService: CoursesService,
    private router: Router,
    // private messageService: MessageService,
  ) {}

  ngOnInit(): void {
    this.ui.title = 'Create course';
    this.initForm();
  }

  onBackClick(): void {
    this.location.back();
  }

  onCreateCourse(): void {

    if (this.courseForm.invalid || this.isLoading) {
      return;
    }

    const dto: CreateCourseDto = this.courseForm.value;

    this.isLoading = true;

    this.coursesService.createCourse(dto)
      .pipe(finalize(() => this.isLoading = false))
      .subscribe({
        next: () => {
          this.router.navigate(['/courses']);
          console.log('New course created');
          // this.messageService.add({
          //   severity: 'success',
          //   summary: 'Success',
          //   detail: 'New course created',
          // });
        },
        error: err => {
          console.error(err);
          console.log('Could not create new course');
          // this.messageService.add({
          //   severity: 'error',
          //   summary: 'Error',
          //   detail: 'Could not create new course',
          // });
        },
      });

    // ...
  }

  private initForm(): void {
    this.courseForm = new FormGroup({
      name: new FormControl('', [Validators.required, Validators.minLength(3)]),
      description: new FormControl(''),
    });
  }
}
