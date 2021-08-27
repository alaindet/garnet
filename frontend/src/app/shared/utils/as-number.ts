export const asNumber = (value: string | number | null): number => {
  switch (typeof value) {
    case 'string':
      return parseInt(value);
    case 'number':
      return value;
    case 'boolean':
      return value ? 1 : 0;
    default:
      return 0;
  }
};
