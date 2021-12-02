import { ValidationSchema, ValidationErrors } from './types';
import { ruleValidators } from './validators-map';

export interface ValidationResult {
  valid: boolean;
  errors: ValidationErrors | null;
}

export const validate = (
  input: any,
  schema: ValidationSchema,
): ValidationResult => {

  let errors: ValidationErrors = {};
  let errorsCount = 0;

  for (const propKey of Object.keys(schema)) {
    for (const validatorKey of Object.keys(schema[propKey])) {
      const validator = ruleValidators[validatorKey];
      const validatorParams = schema[propKey][validatorKey];
      const value = input[propKey];
      // TODO: Pass args to validator
      const validatorErrors = validator(value, ...validatorParams);

      if (validatorErrors !== null) {
        errorsCount++;
        errors = { ...errors, ...validatorErrors };
      }
    }
  }

  return {
    valid: errorsCount === 0,
    errors: errorsCount ? errors : null,
  };
};
