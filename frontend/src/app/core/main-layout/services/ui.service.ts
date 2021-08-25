import { Injectable } from '@angular/core';
import { Title } from '@angular/platform-browser';
import { BehaviorSubject, combineLatest, Observable, Subject } from 'rxjs';
import { map } from 'rxjs/operators';

import { environment } from '@environment/environment';
import { ToasterService } from '@app/shared/components/toaster';
import { isNavbarSticky } from '../functions';
import { ScrollingDirection, FabConfiguration } from '../types';

@Injectable({
  providedIn: 'root',
})
export class UiService {

  private _title$ = new BehaviorSubject<string>(environment.appName);
  private _isDummyNavbarVisible$ = new BehaviorSubject<boolean>(true);
  private _scrollingDirection$ = new BehaviorSubject<ScrollingDirection | null>(null);
  private _isSidebarOpen$ = new BehaviorSubject<boolean>(false);
  private _fab$ = new BehaviorSubject<FabConfiguration | null>(null);
  private _fabClicked$ = new Subject<FabConfiguration['actionName']>();

  title$ = this._title$.asObservable();
  isNavbarSticky$!: Observable<boolean>;
  isSidebarOpen$ = this._isSidebarOpen$.asObservable();
  fab$ = this._fab$.asObservable();
  fabClicked$ = this._fabClicked$.asObservable();

  constructor(
    private titleService: Title,
    private toasterService: ToasterService,
  ) {
    this.isNavbarSticky$ = this.computeIsNavbarSticky();
  }

  set title(title: string) {
    this.titleService.setTitle(`${environment.appName} || ${title}`);
    this._title$.next(title);
  }

  set isSidebarOpen(open: boolean) {
    this._isSidebarOpen$.next(open);
  }

  toggleSidebar(): void {
    this._isSidebarOpen$.next(!this._isSidebarOpen$.getValue());
  }

  clickFab(actionName: string): void {
    this._fabClicked$.next(actionName);
  }

  set isDummyNavbarVisible(isVisible: boolean) {
    this._isDummyNavbarVisible$.next(isVisible);
  }

  set scrollingDirection(scrollingDirection: ScrollingDirection) {
    this._scrollingDirection$.next(scrollingDirection);
  }

  setSuccessToaster(message: string): void {
    this.toasterService.setSuccess(message);
  }

  setErrorToaster(message: string): void {
    this.toasterService.setError(message);
  }

  set fab(config: FabConfiguration | null) {
    this._fab$.next(config);
  }

  private computeIsNavbarSticky(): any {
    return combineLatest([
      this._isDummyNavbarVisible$,
      this._scrollingDirection$,
      this._isSidebarOpen$,
    ])
      .pipe(map(isNavbarSticky));
  }
}
