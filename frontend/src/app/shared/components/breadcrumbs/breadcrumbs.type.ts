import { RouterLink } from '@angular/router';

export interface Breadcrumb {
  label: string;
  url?: RouterLink['routerLink']; // string | any[]

}
