<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\UploadedFile;

class ExcludeMimes implements Rule
{
	protected $mimes;

	public function __construct(array $mimes)
	{
		$this->mimes = $mimes;
	}

	public function passes($attribute, $value)
	{
		if (! $value instanceof UploadedFile) {
			return false;
		}
		return ! in_array(strtolower($value->getClientOriginalExtension()), $this->mimes); // Check the file extension
	}

	public function message()
	{
		return 'The file must not be one of the following types: ' . implode(', ', $this->mimes);
	}
}
