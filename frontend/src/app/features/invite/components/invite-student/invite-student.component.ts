import { Component, OnDestroy, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { Observable, Subscription } from 'rxjs';
import { finalize, startWith, debounceTime, distinctUntilChanged, switchMap, map, tap } from 'rxjs/operators';
import { MatAutocompleteSelectedEvent } from '@angular/material/autocomplete';

import { UiService } from '@app/core/main-layout/services';
import { ToasterService } from '@app/shared/components/toaster';
import { CoursesService } from '@app/features/courses/services';
import { InviteService } from '../../services';
import { CourseSearchItem } from '../../types';

@Component({
  templateUrl: './invite-student.component.html',
  styleUrls: ['./invite-student.component.scss'],
})
export class InviteStudentComponent implements OnInit, OnDestroy {

  isLoading = false;
  filteredOptions!: CourseSearchItem[];
  courseId?: string | number;
  inviteForm!: FormGroup;

  private subs: { [sub: string]: Subscription } = {};

  constructor(
    private ui: UiService,
    private inviteService: InviteService,
    private toaster: ToasterService,
    private router: Router,
    private route: ActivatedRoute,
    private coursesService: CoursesService,
  ) {}

  ngOnInit(): void {
    this.initUi();
    const courseId = this.route.snapshot.params['courseid'];
    this.courseId = courseId;

    if (this.courseId = courseId) {
      this.fetchCourse(this.courseId);
    } else {
      this.initForm();
      this.initCourseAutocomplete();
    }
  }

  ngOnDestroy(): void {
    for (const sub of Object.values(this.subs)) {
      sub.unsubscribe();
    }
  }

  onCourseSelected(event: MatAutocompleteSelectedEvent): void {
    const name = event.option.value;
    const course = this.filteredOptions.find(option => option.name === name);
    this.courseId = course?.course_id;
  }

  onSubmit(): void {

    if (this.inviteForm.invalid || this.isLoading || !this.courseId) {
      return;
    }

    const dto = null;

    this.ui.loading = true;

    // this.authService.signIn(dto)
    //   .pipe(finalize(() => this.ui.loading = false))
    //   .subscribe({
    //     next: () => this.router.navigate(['/courses']),
    //     error: err => this.toaster.setError('Wrong email and/or password'),
    //   });
  }

  private initForm(courseName: string | null = null): void {

    this.inviteForm = new FormGroup({
      email: new FormControl(null, [Validators.required, Validators.email]),
    });

    let courseFormControl: FormControl;

    if (courseName) {
      const formState = { value: courseName, disabled: true };
      courseFormControl = new FormControl(formState, Validators.required);
    } else {
      courseFormControl = new FormControl(null, Validators.required);
    }

    this.inviteForm.addControl('course', courseFormControl);
  }

  private initUi(): void {
    this.ui.title = 'Invite Student';
    this.ui.breadcrumbs = [
      { label: 'Courses', url: '/courses' },
      { label: 'Invite Student', url: '/invite/student' },
    ];
    this.subs.loading = this.ui.loading$
      .subscribe(isLoading => this.isLoading = isLoading);
  }

  private fetchCourse(courseId: string | number): void {
    this.ui.loading = true;
    this.coursesService.getOneCourse(courseId)
      .pipe(finalize(() => this.ui.loading = false))
      .subscribe({
        error: err => this.ui.setErrorToaster(err.error.error.message),
        next: course => this.initForm(course.name),
      });
  }

  private initCourseAutocomplete(): void {

    const formControl = this.inviteForm.get('course');

    if (!formControl) {
      return;
    }

    this.subs.courseName = formControl.valueChanges
      .pipe(
        startWith(''),
        distinctUntilChanged(),
        debounceTime(400),
        switchMap(name => this.inviteService.searchCoursesByName(name)),
      )
      .subscribe(items => this.filteredOptions = items);
  }
}
