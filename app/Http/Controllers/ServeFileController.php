<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ServeFileController extends Controller
{
	public function getQuestFile($questId, $filename): BinaryFileResponse
	{
		$path = 'public/quests/' . $questId . '/' . $filename;

		if (!Storage::exists($path))
		{
			abort(404);
		}

		return response()->file(storage_path('app/' . $path));
	}
}