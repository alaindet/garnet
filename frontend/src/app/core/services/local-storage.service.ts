import { Injectable, OnDestroy } from '@angular/core';
import { Subject } from 'rxjs';
import { throttleTime } from 'rxjs/operators';

import {
  LocalStorageData,
  LocalStorageWriteOperation,
  LocalStorageItemParser,
  LocalStorageSetOperation
} from '../types';

@Injectable({
  providedIn: 'root',
})
export class LocalStorageService implements OnDestroy {

  private data: LocalStorageData = {};
  private writeOperations$ = new Subject<LocalStorageWriteOperation>();

  constructor() {
    this.manageWriteOperations();
  }

  ngOnDestroy(): void {
    this.writeOperations$.complete();
  }

  register<T = any>(key: string, parser: LocalStorageItemParser<T>): void {
    const rawValue = localStorage.getItem(key);
    const parsedValue = parser(rawValue); 
    this.data[key] = { rawValue, parsedValue, parser };
  }

  fetchItem<T = any>(key: string): T | null {
    return this.data[key].parsedValue;
  }

  storeItem<T = any>(key: string, rawValue: string): void {
    const { parser } = this.data[key];
    this.data[key].rawValue = rawValue;
    this.data[key].parsedValue = parser(rawValue);
    this.writeOperations$.next({ key, value: rawValue });
  }

  clearItem(key: string) {
    this.data[key].rawValue = null;
    this.data[key].parsedValue = null;
    this.writeOperations$.next({ key });
  }

  private manageWriteOperations(): void {
    this.writeOperations$
      .pipe(throttleTime(200))
      .subscribe(operation => {

        if (!operation.hasOwnProperty('value')) {
          localStorage.clearItem(operation.key);
          return;
        }

        const { key, value } = operation as LocalStorageSetOperation;
        localStorage.setItem(key, value);
      });
  }
}
