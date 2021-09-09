export const appTruncate = (
  value: string,
  maxChars: number,
  ellipsis = '...'
): string => {
  return value.length > maxChars
    ? value.slice(0, maxChars) + ellipsis
    : value;
}
