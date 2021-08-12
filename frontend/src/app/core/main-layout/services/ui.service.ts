import { Injectable } from '@angular/core';
import { BehaviorSubject, combineLatest, Observable } from 'rxjs';
import { map } from 'rxjs/operators';

import { ScrollDirection } from '../types';

@Injectable({
  providedIn: 'root',
})
export class UiService {

  private _title$ = new BehaviorSubject<string>('Garnet App');
  private _isDummyNavbarVisible$ = new BehaviorSubject<boolean>(true);
  private _scrollingDirection$ = new BehaviorSubject<ScrollDirection | null>(null);

  title$ = this._title$.asObservable();
  isNavbarSticky$!: Observable<boolean>;

  constructor() {
    this.isNavbarSticky$ = this.computeIsNavbarSticky();
  }

  set title(title: string) {
    this._title$.next(title);
  }

  set isDummyNavbarVisible(isVisible: boolean) {
    this._isDummyNavbarVisible$.next(isVisible);
  }

  set scrollingDirection(scrollingDirection: ScrollDirection) {
    this._scrollingDirection$.next(scrollingDirection);
  }

  private computeIsNavbarSticky(): any {
    return combineLatest([this._isDummyNavbarVisible$, this._scrollingDirection$])
      .pipe(
        map(
          ([isDummyNavbarVisible, scrollingDirection]) => {

            if (scrollingDirection === null) {
              return false;
            }

            return (
              !isDummyNavbarVisible &&
              scrollingDirection === ScrollDirection.Up
            );
          }
        )
      );
  }
}
