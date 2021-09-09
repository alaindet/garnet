import { Injectable } from '@angular/core';
import { Title } from '@angular/platform-browser';
import { BehaviorSubject, combineLatest, Observable, Subject } from 'rxjs';
import { distinctUntilChanged, map, share } from 'rxjs/operators';

import { environment } from '@environment/environment';
import { ToasterService } from '@app/shared/components/toaster';
import { Breadcrumb } from '@app/shared/components/breadcrumbs';
import { isNavbarSticky } from '../functions';
import { ScrollingDirection, FabConfiguration } from '../types';

const INITIAL_BREADCRUMBS: Breadcrumb[] = [{ label: 'Home', url: '/' }];

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
  private _loading$ = new BehaviorSubject<number>(0);
  private _breadcrumbs$ = new BehaviorSubject<Breadcrumb[]>(INITIAL_BREADCRUMBS);

  title$ = this._title$.asObservable().pipe(share());
  isNavbarSticky$!: Observable<boolean>;
  isSidebarOpen$ = this._isSidebarOpen$.asObservable().pipe(share());
  fab$ = this._fab$.asObservable().pipe(share());
  fabClicked$ = this._fabClicked$.asObservable().pipe(share());
  breadcrumbs$ = this._breadcrumbs$.asObservable().pipe(share());
  loading$ = this._loading$
    .asObservable()
    .pipe(share(), map(counter => counter > 0), distinctUntilChanged());

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

  set breadcrumbs(breadcrumbs: Breadcrumb[]) {
    this._breadcrumbs$.next(breadcrumbs);
  }

  set loading(loading: boolean) {
    const prevValue = this._loading$.getValue();
    const nextValue = prevValue + (loading ? 1 : -1);
    this._loading$.next(nextValue);
  }

  clearLoading(): void {
    this._loading$.next(0);
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
