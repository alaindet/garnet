import { Component, OnInit } from '@angular/core';
import { HttpErrorResponse } from '@angular/common/http';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { finalize } from 'rxjs/operators';

import { UiService } from '@app/core/main-layout/services';
import { TaskManagerService } from '../../services';
import { Task } from '../../types';
// import { Course, CreateCourseRequest, UpdateCourseRequest, CourseFormValue } from '../../types';
import { TaskManagerAction } from '../../actions';

@Component({
  templateUrl: './form.component.html',
  styleUrls: ['./form.component.scss'],
})
export class TaskFormComponent implements OnInit {

  isLoading = false;
  title!: string;
  submit!: string;
  submitIcon!: string;
  isEditing = false;
  existingCourse?: Task;
  courseForm!: FormGroup;

  constructor(
    private ui: UiService,
    private taskService: TaskManagerService,
    private router: Router,
    private route: ActivatedRoute,
  ) { }

  get name(): FormControl {
    return this.courseForm.get('name') as FormControl;
  }

  get description(): FormControl {
    return this.courseForm.get('description') as FormControl;
  }

  ngOnInit(): void {

    const action = this.route.snapshot.data.action;
    const courseId = this.route.snapshot.params['courseid'];
    const taskId = this.route.snapshot.params['taskid'];

    this.isEditing = action === TaskManagerAction.ShowEditTaskForm;

    if (this.isEditing) {
      this.fetchExistingTask();
      // this.coursesService.getOneCourse(courseId)
      //   .pipe(finalize(() => this.isLoading = false))
      //   .subscribe({
      //     error: err => this.ui.setSnackbarSuccess('Could not get course data'),
      //     next: course => {
      //       this.existingCourse = course;
      //       this.initForm({
      //         name: course.name,
      //         description: course?.description ?? null,
      //       });
      //     },
      //   });
      return;
    }

    this.updateUiByAction(this.isEditing);
    this.initForm();
  }

  private updateUiByAction(isEditing: boolean): void {

    if (isEditing) {
      this.ui.title = 'Edit task';
      this.title = 'Edit task';
      this.submit = 'Edit';
      this.submitIcon = 'edit';
      this.isLoading = true;
      return;
    }

    this.ui.title = 'Create task';
    this.title = 'Create task';
    this.submit = 'Create';
    this.submitIcon = 'add';
  }

  private fetchExistingTask(): void {

  }

  onSubmit(): void {

    if (this.courseForm.invalid || this.isLoading) {
      return;
    }

    this.isLoading = true;
    this.courseForm.disable();
    const formValue = this.courseForm.value;

    let [request, onSuccess]: [any, () => void] = [null, () => { }];

    if (this.isEditing && this.existingCourse) {

      const dto: UpdateCourseRequest = { id: this.existingCourse?.course_id };
      if (formValue?.name) dto.name = formValue.name;
      if (formValue?.description) dto.description = formValue.description;

      [request, onSuccess] = [this.coursesService.updateCourse(dto), () => {
        this.router.navigate(['/courses']);
        this.ui.setSnackbarSuccess(`Course with id ${dto.id} updated`);
      }];
    }

    else {
      const dto: CreateCourseRequest = formValue;

      [request, onSuccess] = [this.coursesService.createCourse(dto), () => {
        this.router.navigate(['/courses']);
        this.ui.setSnackbarSuccess('Course created');
      }];
    }

    request
      .pipe(finalize(() => {
        this.isLoading = false;
        this.courseForm.enable();
      }))
      .subscribe({
        error: (err: HttpErrorResponse) => {
          this.ui.setSnackbarError(err.error.message);
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
