import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'appTruncate',
  pure: true,
})
export class TruncatePipe implements PipeTransform {
  transform(value: string, maxChars: number, ellipsis = '...'): string {
    return value.length > maxChars
      ? value.slice(0, maxChars) + ellipsis
      : value;
  }
}
