export type ValidationRuleParams = any;

export interface ValidationRules {
	[rule: string]: ValidationRuleParams;
}

export interface ValidationSchema {
	[key: string]: ValidationRules;
}

export interface ValidationErrors {
	[key: string]: string;
}

export type ValidatorFn = (value: any, ...args: any[]) => ValidationErrors | null;

export interface Validators {
  [validatorName: string]: ValidatorFn;
}