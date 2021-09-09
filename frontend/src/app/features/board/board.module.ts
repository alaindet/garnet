import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { BoardRoutingModule } from './board.routing';
import { BoardComponentsModule } from './board.components.module';
import { BoardComponent } from './components';
import { TasksService } from './services';

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
    TasksService,
  ],
})
export class BoardModule {}
