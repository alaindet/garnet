export const trimSlash = (url: string): string => {
  const from = url.startsWith('/') ? 1 : 0;
  const to = url.endsWith('/') ? -1 : url.length;
  return url.slice(from, to);
};
