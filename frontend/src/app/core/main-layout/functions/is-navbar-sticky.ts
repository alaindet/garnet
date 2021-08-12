import { ScrollingDirection } from '../types';

export const isNavbarSticky = ([
  isDummyNavbarVisible,
  scrollingDirection,
  isSidebarOpen,
]: [
  isDummyNavbarVisible: boolean,
  scrollingDirection: ScrollingDirection | null,
  isSidebarOpen: boolean
]) => {

  if (isSidebarOpen) {
    return true;
  }

  // Initial state
  if (scrollingDirection === null) {
    return true;
  }

  if (isDummyNavbarVisible) {
    return true;
  }

  return scrollingDirection === ScrollingDirection.Up;
}
