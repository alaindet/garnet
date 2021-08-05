import { HttpClient } from '@angular/common/http';
import { Component } from '@angular/core';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {

  message: string = 'Loading...';

  constructor(
    private http: HttpClient,
  ) {}

  ngOnInit(): void {
    this.http.get('http://localhost:8080').subscribe((res: any) => {
      this.message = res?.message;
    });
  }
}
