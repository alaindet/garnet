import { ValidatorFn, ValidationErrors } from '../types';

export const isNumber: ValidatorFn = (value: any): ValidationErrors | null => {
  if (typeof value !== 'number') {
    return {
      isNumber: 'Value is not a number',
    };
  }

  return null;
};