import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';

import { ToasterConfig } from '../types';

@Injectable({
  providedIn: 'root',
})
export class ToasterService {

  private duration = 3000;
  private _toaster$ = new BehaviorSubject<ToasterConfig | null>(null);
  toaster$ = this._toaster$.asObservable();

  setToaster(message: string, type: ToasterConfig['type']): void {
    const duration = this.duration;
    this._toaster$.next({ message, duration, type });
  }

  setSuccess(message: string): void {
    this.setToaster(message, 'success');
  }

  setError(message: string): void {
    this.setToaster(message, 'error');
  }

  clearToaster(): void {
    this._toaster$.next(null);
  }
}
