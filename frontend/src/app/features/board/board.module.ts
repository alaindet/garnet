import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { BoardRoutingModule } from './board.routing.module';
import { BoardComponentsModule } from './board.components.module';
import { BoardComponent, TaskComponent } from './components';

@NgModule({
  imports: [
    CommonModule,
    BoardRoutingModule,
    BoardComponentsModule,
  ],
  declarations: [
    BoardComponent,
    TaskComponent,
  ],
  providers: [
    // ...
  ],
})
export class BoardModule {}
