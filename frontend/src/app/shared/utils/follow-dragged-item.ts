import { CdkDragMove } from '@angular/cdk/drag-drop';

export const followDraggedItem = (
  elementToScroll: HTMLElement,
  leftThreshold: number,
  rightThreshold: number
): (event: CdkDragMove<HTMLElement>) => void => {

  return (event: CdkDragMove<HTMLElement>) => {

    const pointerX = event.pointerPosition.x;

      if (event.delta.x === 0) {
        return;
      }

      // Going right
      if (event.delta.x > 0 && pointerX > rightThreshold) {
        elementToScroll.scrollLeft += pointerX - rightThreshold;
      }

      // Going left
      else if (event.delta.x < 0 && pointerX < leftThreshold) {
        elementToScroll.scrollLeft += pointerX - leftThreshold;
      }
  };
}
