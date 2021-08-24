import { Component, OnInit } from '@angular/core';
import { HttpErrorResponse } from '@angular/common/http';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { finalize } from 'rxjs/operators';

import { UiService } from '@app/core/main-layout/services';
import { TaskManagerService } from '../../services';
import { Task, TaskFormValue, CreateTaskRequest, UpdateTaskRequest } from '../../types';

@Component({
  templateUrl: './form.component.html',
  styleUrls: ['./form.component.scss'],
})
export class TaskFormComponent implements OnInit {

  isLoading = false;
  courseId!: string | number;
  taskId?: string | number;
  title!: string;
  submit!: string;
  submitIcon!: string;
  taskForm!: FormGroup;
  task?: Task;

  constructor(
    private ui: UiService,
    private taskService: TaskManagerService,
    private router: Router,
    private route: ActivatedRoute,
  ) { }

  get name(): FormControl {
    return this.taskForm.get('name') as FormControl;
  }

  get description(): FormControl {
    return this.taskForm.get('description') as FormControl;
  }

  ngOnInit(): void {

    this.courseId = this.route.snapshot.params['courseid'];
    this.taskId = this.route.snapshot.params['taskid'];
    const isEditing = !!this.taskId;

    if (isEditing) {
      this.updateUiByAction(isEditing);
      this.fetchExistingTask(this.courseId, this.taskId as number);
      return;
    }

    this.updateUiByAction(isEditing);
    this.initForm();
  }

  onSubmit(): void {

    if (this.taskForm.invalid || this.isLoading) {
      return;
    }

    this.isLoading = true;
    this.taskForm.disable();
    const formValue = this.taskForm.value;

    let [request, onSuccess]: [any, () => void] = [null, () => { }];

    // Editing
    if (!!this.task) {

      const dto: UpdateTaskRequest = {
        courseId: this.courseId,
        taskId: this.task?.course_id,
      };

      if (formValue?.name) dto.name = formValue.name;
      if (formValue?.description) dto.description = formValue.description;

      [request, onSuccess] = [this.taskService.updateTask(dto), () => {
        this.router.navigate(['/courses', this.courseId, 'tasks']);
        this.ui.setSnackbarSuccess(`Task with id ${dto.taskId} updated`);
      }];
    }

    else {
      const dto: CreateTaskRequest = formValue;

      [request, onSuccess] = [this.taskService.createTask(dto), () => {
        this.router.navigate(['/courses', this.courseId, 'tasks']);
        this.ui.setSnackbarSuccess('Course created');
      }];
    }

    request
      .pipe(finalize(() => {
        this.isLoading = false;
        this.taskForm.enable();
      }))
      .subscribe({
        error: (err: HttpErrorResponse) => {
          this.ui.setSnackbarError(err.error.message);
        },
        next: onSuccess,
      });
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

  private fetchExistingTask(courseId: string | number, taskId: string | number): void {
    this.taskService.getTaskById(courseId, taskId)
      .pipe(finalize(() => this.isLoading = false))
      .subscribe({
        error: err => this.ui.setSnackbarSuccess(err.error.message),
        next: task => {
          this.task = task;
          this.initForm({
            name: task.name,
            description: task?.description ?? null,
          });
        },
      });
  }

  private initForm(data?: TaskFormValue): void {
    this.taskForm = new FormGroup({
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
