<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\UploadedFile;

class ExcludeMimes implements Rule
{
	protected array $mimes;

	public function __construct(array $mimes)
	{
		$this->mimes = $mimes;
	}

	public function passes($attribute, $value): bool
	{
		if (! $value instanceof UploadedFile) {
			return false;
		}
		return ! in_array(strtolower($value->getClientOriginalExtension()), $this->mimes); // Check the file extension
	}

	public function message(): string
	{
		return 'The file must not be one of the following types: ' . implode(', ', $this->mimes);
	}
}