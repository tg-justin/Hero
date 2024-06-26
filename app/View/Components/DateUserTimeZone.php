<?php
namespace App\View\Components;

use Illuminate\View\Component;

class DateUserTimeZone extends Component
{
	public $value;

	public $format;

	public $timeZone;

	/**
	 * Create a new component instance.
	 *
	 * @return void
	 */
	public function __construct($value, $format = NULL, $timeZone = NULL)
	{
		$this->value = $value;
		$this->format = $format;
		$this->timeZone = $timeZone;
	}

	/**
	 * Get the view / contents that represent the component.
	 *
	 * @return \Illuminate\View\View|string
	 */
	public function render()
	{
		return view('components.date-user-time-zone');
	}
}