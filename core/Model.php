<?php

namespace app\core;

use app\core\Request;

abstract class Model // abstract to prevent creation of instance
{
	public const RULE_REQUIRED = 'required';
	public const RULE_EMAIL = 'email';
	public const RULE_MAX = 'max';
	public const RULE_MIN = 'min';
	public const RULE_MATCH = 'match';

	public array $errors = [];

	public function loadData($data)
	{
		foreach ($data as $key => $value) {
			if (property_exists($this, $key)) {
				$this->{$key} = $value;
			}
		}
	}

	abstract public function rules(): array;

	public function validate()
	{
		foreach ($this->rules() as $attribute => $rules) {
			$value = $this->{$attribute}; // for example attr is an username, $value will be username
			foreach ($rules as $rule) {
				$ruleName = $rule;
				if (!is_string($ruleName)) {
					$ruleName = $rule[0];
				}
				if ($ruleName === self::RULE_REQUIRED && !$value) {
					$this->addError($attribute, self::RULE_REQUIRED);
				}
				if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
					$this->addError($attribute, self::RULE_EMAIL);
				}
				if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
					$this->addError($attribute, self::RULE_MAX. $rule);
				}
				if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
					$this->addError($attribute, self::RULE_MIN, $rule);
				}
				if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
					$this->addError($attribute, self::RULE_MATCH, $rule);
				}
			}
		}

		return empty($this->errors);
	}

	public function addError(string $attribute, string $rule, $params = [])
	{
		$message = $this->errorMessages()[$rule] ?? '';
		foreach ($params as $key => $value) {
			$message = str_replace('{' . $key . '}', $value, $message); // or "{{$key}}"
		}
		$this->errors[$attribute][] = $message;
	}

	private function errorMessages()
	{
		return [
			self::RULE_REQUIRED => 'This field is required',
			self::RULE_MAX => 'Max length of this field must be {max}',
			self::RULE_MIN => 'Min length of this field must be {min}',
			self::RULE_EMAIL => 'This field must be valid email address',
			self::RULE_MATCH => 'This field must be the same as {match}',
		];
	}

	public function hasError(string $attribute)
	{
		return $this->errors[$attribute] ?? false;
	}

	public function getFirstError(string $attribute)
	{
		return $this->errors[$attribute][0] ?? false;
	}

}