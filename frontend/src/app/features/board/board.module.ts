import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { BoardRoutingModule } from './board.routing.module';
import { BoardComponentsModule } from './board.components.module';
import { BoardComponent } from './components';

@NgModule({
  imports: [
    CommonModule,
    BoardRoutingModule,
    BoardComponentsModule,
  ],
  declarations: [
    BoardComponent,
  ],
  providers: [
    // ...
  ],
})
export class BoardModule {}
