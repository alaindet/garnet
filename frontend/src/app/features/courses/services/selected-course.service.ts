import { Injectable } from '@angular/core';
import { BehaviorSubject, Observable } from 'rxjs';
import { share } from 'rxjs/operators';

import { environment } from '@environment/environment';
import { LocalStorageService } from '@app/core/services';
import { Course } from '../types';

@Injectable({
  providedIn: 'root',
})
export class SelectedCourseService {

  course$!: Observable<Course | null>;

  private _course$!: BehaviorSubject<Course | null>;
  private STORAGE_KEY = `${environment.appSlug}.course`;

  constructor(private localStorageService: LocalStorageService) {
    this.init();
  }

  set course(course: Course | null) {
    this._course$.next(course);
    const storedValue = JSON.stringify(course);
    this.localStorageService.storeItem(this.STORAGE_KEY, storedValue);
  }

  private init(): void {
    const key = this.STORAGE_KEY;
    this.localStorageService.register(key, this.parser);
    const initialValue = this.localStorageService.fetchItem<Course>(key);
    this._course$ = new BehaviorSubject<Course | null>(initialValue);
    this.course$ = this._course$.asObservable();
  }

  private parser(rawCourse: string | null): Course | null {
    return (rawCourse === null) ? null : JSON.parse(rawCourse) as Course;
  }
}
