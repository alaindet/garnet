import { ValidatorFn, ValidationErrors } from '../types';

export const minValidator: ValidatorFn = (
  value: string | number,
  min: number,
): ValidationErrors | null => {

  if (value < min) {
    return {
      min: `Value ${value} must be greater than or equal to ${min}`,
    };
  }

  return null;
};
