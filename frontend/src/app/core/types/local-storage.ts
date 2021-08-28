export interface LocalStorageSetOperation {
  key: string;
  value: string;
}

export interface LocalStorageClearOperation {
  key: string;
}

export type LocalStorageWriteOperation = (
  | LocalStorageSetOperation
  | LocalStorageClearOperation
);

export type LocalStorageItemParser<T = any> = (rawValue: string | null) => T;

export interface LocalStorageItem<T = any> {
  rawValue: string | null;
  parsedValue: T | null;
  parser: LocalStorageItemParser<T>;
}

export interface LocalStorageData {
  [key: string]: LocalStorageItem;
}
