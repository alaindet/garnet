import { AfterViewInit, Component, ElementRef, HostBinding, OnInit, OnDestroy, ViewChild } from '@angular/core';
import { NavigationEnd, Router, ActivatedRoute } from '@angular/router';
import { fromEvent, Subscription } from 'rxjs';
import { throttleTime, map, distinctUntilChanged, filter, mergeMap, tap } from 'rxjs/operators';
import { MatSnackBar, MatSnackBarRef, MatSnackBarConfig } from '@angular/material/snack-bar';

import { UiService } from '../../services';
import { ScrollingDirection, SnackbarConfiguration } from '../../types';
import { SnackbarComponent } from '../snackbar/snackbar.component';

@Component({
  selector: 'app-main-layout',
  templateUrl: './main-layout.component.html',
  styleUrls: ['./main-layout.component.scss'],
})
export class MainLayoutComponent implements AfterViewInit, OnInit, OnDestroy {

  @ViewChild('routerOutletRef')
  routerOutletRef!: ElementRef;

  @HostBinding('class.--locked-scrolling')
  lockedScrolling = false;

  private snackBarRef?: MatSnackBarRef<SnackbarComponent>;
  private subs: { [sub: string]: Subscription } = {};

  constructor(
    public ui: UiService,
    private router: Router,
    private route: ActivatedRoute,
    private snackBar: MatSnackBar,
  ) {}

  ngOnInit(): void {
    this.observeLockedScrolling();
    this.listenToRouterEvents();
    this.manageSnackBar();
  }

  ngAfterViewInit(): void {
    this.observeScrollingDirection();
  }

  ngOnDestroy(): void {
    for (const sub of Object.values(this.subs)) {
      sub.unsubscribe();
    }
  }

  onSidebarClose(): void {
    this.ui.isSidebarOpen = false;
  }

  private observeLockedScrolling(): void {
    this.subs.lockScrolling = this.ui.isSidebarOpen$
      .subscribe(isSidebarOpen => this.lockedScrolling = isSidebarOpen);
  }

  private observeScrollingDirection(): void {
    let lastScrollY = window.scrollY;
    this.subs.scrollingDirection = fromEvent(window, 'scroll')
      .pipe(
        throttleTime(1000 / 5), // 5 FPS
        map(() => {
          const isScrollingDown = (window.scrollY - lastScrollY) > 0;
          lastScrollY = window.scrollY;
          return isScrollingDown ? ScrollingDirection.Down : ScrollingDirection.Up;
        }),
        distinctUntilChanged(),
      )
      .subscribe(scrollDir => this.ui.scrollingDirection = scrollDir);
  }

  private listenToRouterEvents(): void {

    this.router.events
      .pipe(
        filter(event => event instanceof NavigationEnd),
        tap(this.onSidebarClose.bind(this)),
        map(() => this.route),
        map(route => {
          while (route.firstChild) {
            route = route.firstChild;
          }
          return route;
        }),
        filter(route => route.outlet === 'primary'),
        mergeMap(route => route.data),
        tap(this.updateFabFromRouteData.bind(this)),
      )
      .subscribe();
  }

  private updateFabFromRouteData(routeData: any): void {

    let fab = routeData?.fab ?? null;

    if (typeof fab === 'string') {
      fab = { actionName: fab };
    }

    this.ui.fab = fab;
  }

  private manageSnackBar(): void {

    this.ui.snackbar$.subscribe(data => {
      this.snackBarRef = this.snackBar.openFromComponent(SnackbarComponent, {
        // duration: 3000,
        duration: 120_000,
        horizontalPosition: 'right',
        verticalPosition: 'top',
        data,
      });
    });

    this.ui.setSnackbarSuccess('This is a very unnecessarily long text I will be showing somewhere on the page');
  }
}
