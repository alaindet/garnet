import { Validators } from './types';
import {
  minValidator,
} from './validators';

export const ruleValidators: Validators = {
  min: minValidator,
};
