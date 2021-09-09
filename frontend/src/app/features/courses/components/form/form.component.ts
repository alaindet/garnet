import { Component, OnDestroy, OnInit } from '@angular/core';
import { HttpErrorResponse } from '@angular/common/http';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { finalize } from 'rxjs/operators';

import { UiService } from '@app/core/main-layout/services';
import { CoursesService } from '../../services';
import { Course, CreateCourseRequest, UpdateCourseRequest, CourseFormValue } from '../../types';
import { Subscription } from 'rxjs';

@Component({
  templateUrl: './form.component.html',
  styleUrls: ['./form.component.scss'],
})
export class CourseFormComponent implements OnInit, OnDestroy {

  isLoading = false;
  submit!: string;
  submitIcon!: string;
  isEditing = false;
  existingCourse?: Course;
  courseForm!: FormGroup;

  private subs: { [sub: string]: Subscription } = {};

  constructor(
    public ui: UiService,
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
      this.ui.breadcrumbs = [
        { label: 'Courses', url: '/courses' },
        { label: 'Edit', url: ['/courses', courseId] },
      ];
      this.submit = 'Edit';
      this.submitIcon = 'edit';
      this.fetchCourse(courseId);
      return;
    }

    this.ui.title = 'Create course';
    this.ui.breadcrumbs = [
      { label: 'Courses', url: '/courses' },
      { label: 'Create', url: '/courses/create' },
    ];
    this.submit = 'Create';
    this.submitIcon = 'add';
    this.initForm();
    this.subs.loading = this.ui.loading$.subscribe(isLoading => this.isLoading);
  }

  ngOnDestroy(): void {
    for (const sub of Object.values(this.subs)) {
      sub.unsubscribe();
    }
  }

  onSubmit(): void {

    if (this.courseForm.invalid || this.isLoading) {
      return;
    }

    this.ui.loading = true;
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
        this.ui.loading = false;
        this.courseForm.enable();
      }))
      .subscribe({
        error: (err: HttpErrorResponse) => {
          this.ui.setErrorToaster(err.error.error.message);
        },
        next: onSuccess,
      });
  }

  private fetchCourse(courseId: string | number): void {
    this.ui.loading = true;
    this.coursesService.getOneCourse(courseId)
      .pipe(finalize(() => this.ui.loading = false))
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
