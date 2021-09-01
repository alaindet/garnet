import { Component } from '@angular/core';
import { Router, NavigationCancel } from '@angular/router';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {

  constructor(
    private router: Router,
  ) {}

  ngOnInit(): void {
    this.router.events.subscribe(event => {

      if (event instanceof NavigationCancel) {
        console.log('router event', event.reason);
      }

    });
  }
}
