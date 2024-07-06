<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ServeFileController extends Controller
{
	// http://hero.test/storage/quests/2/sample.pdf
	public function serveQuestFile($questId, $filename): BinaryFileResponse
	{
		$path = 'public/quests/' . $questId . '/' . $filename;

		if (!Storage::exists($path))
		{
			abort(404);
		}

		return response()->file(storage_path('app/' . $path));
	}

	// http://hero.test/storage/feedback/2/14/another-file-20240705-190436.pdf
	public function serveQuestLogFile($questId, $questLogId, $filename): BinaryFileResponse
	{
		$path = 'public/feedback/' . $questId . '/' . $questLogId . '/'. $filename;

		if (!Storage::exists($path))
		{
			abort(404);
		}

		return response()->file(storage_path('app/' . $path));
	}
}