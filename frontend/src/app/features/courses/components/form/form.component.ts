import { Component, OnInit } from '@angular/core';
import { HttpErrorResponse } from '@angular/common/http';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { finalize } from 'rxjs/operators';

import { UiService } from '@app/core/main-layout/services';
import { CoursesService } from '../../services';
import { Course, CreateCourseRequest, UpdateCourseRequest, CourseFormValue } from '../../types';
import { CoursesAction } from '../../actions';

@Component({
  templateUrl: './form.component.html',
  styleUrls: ['./form.component.scss'],
})
export class CourseFormComponent implements OnInit {

  isLoading = false;
  title!: string;
  submit!: string;
  submitIcon!: string;
  isEditing = false;
  existingCourse?: Course;
  courseForm!: FormGroup;

  constructor(
    private ui: UiService,
    private coursesService: CoursesService,
    private router: Router,
    private route: ActivatedRoute,
  ) {}

  get name(): FormControl {
    return this.courseForm.get('name') as FormControl;
  }

  get description(): FormControl {
    return this.courseForm.get('description') as FormControl;
  }

  ngOnInit(): void {
    const courseId = this.route.snapshot.params['courseid'];

    this.isEditing = !!courseId;

    if (this.isEditing) {
      this.ui.title = 'Edit course';
      this.title = 'Edit course';
      this.submit = 'Edit';
      this.submitIcon = 'edit';
      this.isLoading = true;
      this.coursesService.getOneCourse(courseId)
        .pipe(finalize(() => this.isLoading = false))
        .subscribe({
          error: err => this.ui.setErrorToaster(err.error.error.message),
          next: course => {
            this.existingCourse = course;
            this.initForm({
              name: course.name,
              description: course?.description ?? null,
            });
          },
        });
      return;
    }

    this.ui.title = 'Create course';
    this.title = 'Create course';
    this.submit = 'Create';
    this.submitIcon = 'add';
    this.initForm();
  }

  onSubmit(): void {

    if (this.courseForm.invalid || this.isLoading) {
      return;
    }

    this.isLoading = true;
    this.courseForm.disable();
    const formValue = this.courseForm.value;

    let [request, onSuccess]: [any, () => void] = [null, () => {}];

    if (this.isEditing && this.existingCourse) {

      const dto: UpdateCourseRequest = { courseId: this.existingCourse?.course_id };
      if (formValue?.name) dto.name = formValue.name;
      if (formValue?.description) dto.description = formValue.description;

      [request, onSuccess] = [this.coursesService.updateCourse(dto), () => {
        this.router.navigate(['/courses']);
        const message = `Course "<strong>${dto.name}</strong>" updated`;
        this.ui.setSuccessToaster(message);
      }];
    }

    else {
      const dto: CreateCourseRequest = formValue;

      [request, onSuccess] = [this.coursesService.createCourse(dto), () => {
        this.router.navigate(['/courses']);
        this.ui.setSuccessToaster('Course created');
      }];
    }

    request
      .pipe(finalize(() => {
        this.isLoading = false;
        this.courseForm.enable();
      }))
      .subscribe({
        error: (err: HttpErrorResponse) => {
          this.ui.setErrorToaster(err.error.error.message);
        },
        next: onSuccess,
      });
  }

  private initForm(data?: CourseFormValue): void {
    this.courseForm = new FormGroup({
      name: new FormControl(data?.name, [
        Validators.required,
        Validators.minLength(5)
      ]),
      description: new FormControl(data?.description, [
        Validators.minLength(5)
      ]),
    });
  }
}
