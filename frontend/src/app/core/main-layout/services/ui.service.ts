import { Injectable } from '@angular/core';
import { BehaviorSubject, combineLatest, Observable } from 'rxjs';
import { map } from 'rxjs/operators';

import { isNavbarSticky } from '../functions';
import { ScrollingDirection } from '../types';

@Injectable({
  providedIn: 'root',
})
export class UiService {

  private _title$ = new BehaviorSubject<string>('Garnet App');
  private _isDummyNavbarVisible$ = new BehaviorSubject<boolean>(true);
  private _scrollingDirection$ = new BehaviorSubject<ScrollingDirection | null>(null);
  private _isSidebarOpen$ = new BehaviorSubject<boolean>(false);

  title$ = this._title$.asObservable();
  isNavbarSticky$!: Observable<boolean>;
  isSidebarOpen$ = this._isSidebarOpen$.asObservable();

  constructor() {
    this.isNavbarSticky$ = this.computeIsNavbarSticky();
  }

  set title(title: string) {
    this._title$.next(title);
  }

  set isSidebarOpen(open: boolean) {
    this._isSidebarOpen$.next(open);
  }

  toggleSidebar(): void {
    this._isSidebarOpen$.next(!this._isSidebarOpen$.getValue());
  }

  set isDummyNavbarVisible(isVisible: boolean) {
    this._isDummyNavbarVisible$.next(isVisible);
  }

  set scrollingDirection(scrollingDirection: ScrollingDirection) {
    this._scrollingDirection$.next(scrollingDirection);
  }

  private computeIsNavbarSticky(): any {
    return combineLatest([this._isDummyNavbarVisible$, this._scrollingDirection$])
      .pipe(map(isNavbarSticky));
  }
}
