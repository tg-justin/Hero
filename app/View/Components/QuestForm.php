<?php
namespace App\View\Components;

use App\Models\Campaign;
use App\Models\Category;
use App\Models\Quest;
use Illuminate\View\Component;

class QuestForm extends Component
{
	public $quest; // Add this property

	public $categories; // Add this property

	public $campaigns; // Add this property

	public $feedback_types; // Add this property
	public $submitButtonText;

	public function __construct($quest = NULL)
	{
		$this->quest = $quest;
		$this->categories = Category::all();
		$this->campaigns = Campaign::all();
		$this->feedback_types = Quest::getFeedbackTypes();

		$this->submitButtonText = $quest && (!is_null($quest->id)) ? 'Update Quest' : 'Create Quest';
	}

	public function render()
	{
		return view('components.quest-form');
	}
}
