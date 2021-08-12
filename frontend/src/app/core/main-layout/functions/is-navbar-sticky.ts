import { ScrollingDirection } from '../types';

export const isNavbarSticky = ([
  isDummyNavbarVisible,
  scrollingDirection
]: [
  isDummyNavbarVisible: boolean,
  scrollingDirection: ScrollingDirection | null
]) => {

  // Initial state
  if (scrollingDirection === null) {
    return true;
  }

  if (isDummyNavbarVisible) {
    return true;
  }

  return scrollingDirection === ScrollingDirection.Up;
}
