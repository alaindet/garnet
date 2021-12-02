import { ValidatorFn, ValidationErrors } from '../types';

export const isString: ValidatorFn = (value: any): ValidationErrors | null => {
  if (typeof value !== 'string') {
    return {
      isString: ':value is not a string'.replace(':value', value),
    };
  }

  return null;
};