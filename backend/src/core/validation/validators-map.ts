import { Validators } from './types';
import { isNumber, isString } from './validators';

export const ruleValidators: Validators = {
  isNumber,
  isString,
};