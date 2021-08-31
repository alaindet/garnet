import { Component } from '@angular/core';
import { CdkDragDrop, transferArrayItem } from '@angular/cdk/drag-drop';

@Component({
  templateUrl: './board.component.html',
  styleUrls: ['./board.component.scss'],
})
export class BoardComponent {

  tasks: {
    [columnName: string]: { name: string; description: string }[];
  } = {
    todo: [
      {
        name: 'First Step',
        description: 'Perform the first step',
      },
      {
        name: 'Second Step',
        description: 'Perform the second step',
      },
    ],
    inProgress: [],
    done: [],
  };

  onDropTask(event: CdkDragDrop<{ name: string; description: string }[]>): void {

    // Ignore movements inside the same list
    if (
      event.previousContainer === event.container ||
      !event.container.data ||
      !event.previousContainer.data
    ) {
      return;
    }

    transferArrayItem(
      event.previousContainer.data,
      event.container.data,
      event.previousIndex,
      event.currentIndex
    );

    // TODO: Remove
    console.log('====\nLISTS STATUS\n====');
    console.log('TODO LIST', this.tasks.todo);
    console.log('IN PROGRESS LIST', this.tasks.inProgress);
    console.log('DONE LIST', this.tasks.done);
  }
}
