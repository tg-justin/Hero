<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class ExplodeTrim implements Rule
{
	protected $separator;
	protected $rule;

	public function __construct(string $rule = 'email', string $separator = ',')
	{
		$this->rule = $rule;
		$this->separator = $separator;
	}

	public function passes($attribute, $value)
	{
		$values = explode($this->separator, $value);
		$values = array_map('trim', $values);

		$rules = [
			$attribute.'.*' => $this->rule, // Validate each item using the specified rule
		];

		return Validator::make(
			[$attribute => $values],
			$rules
		)->passes();
	}

	public function message()
	{
		return 'The :attribute must be a valid list of values.';
	}
}
