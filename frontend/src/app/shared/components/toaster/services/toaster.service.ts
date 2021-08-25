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

  private timeout?: ReturnType<typeof setTimeout>;

  setSuccess(message: string): void {
    this.setToaster(message, 'success');
  }

  setError(message: string): void {
    this.setToaster(message, 'error');
  }

  clearToaster(): void {
    this.clearTimeout();
    this._toaster$.next(null);
  }

  private setToaster(message: string, type: ToasterConfig['type']): void {
    this.clearTimeout();
    this._toaster$.next({ message, type });
    this.timeout = setTimeout(this.clearToaster.bind(this), this.duration);
  }

  private clearTimeout(): void {
    if (this.timeout) {
      clearTimeout(this.timeout);
    }
  }
}
