<?php

if (!function_exists('cleanFilename'))
{
	function cleanFilename($filename, $maxLength = 30): string
	{
		// Convert to lowercase
		$filename = strtolower($filename);

		// Replace non-alphanumeric characters (except dashes, periods, and underscores) with a dash
		$filename = preg_replace('/[^a-z0-9._-]/', '-', $filename);

		// Remove duplicate dashes, periods, and underscores
		$filename = preg_replace('/-+/', '-', $filename);
		$filename = preg_replace('/[.]+/', '.', $filename);
		$filename = preg_replace('/_+/', '_', $filename);

		// Remove leading and trailing non-alphanumerics
		$filename = trim($filename, "-._");

		// Get the file name and extension
		$fileFilename = pathinfo($filename, PATHINFO_FILENAME);
		$fileExtension = pathinfo($filename, PATHINFO_EXTENSION);

		// Limit the length of the filename (excluding the extension) to the specified maxLength
		$fileFilename = substr($fileFilename, 0, $maxLength);

		// Return reconstructed filename with extension
		return $fileFilename . (empty($fileExtension) ? '' : '.' . $fileExtension);
	}
}