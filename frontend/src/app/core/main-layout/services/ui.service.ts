import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class UiService {

  private _title$ = new BehaviorSubject<string>('Garnet App');
  title$ = this._title$.asObservable();

  set title(title: string) {
    this._title$.next(title);
  }
}
