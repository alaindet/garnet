import { Pipe, PipeTransform } from '@angular/core';
import { appTruncate } from '@app/shared/utils/truncate';

@Pipe({
  name: 'appTruncate',
  pure: true,
})
export class TruncatePipe implements PipeTransform {
  transform(value: string, maxChars: number, ellipsis = '...'): string {
    return appTruncate(value, maxChars, ellipsis);
  }
}
