<?php

class CSVParser
{
	// Parse CSV text, treating the first line as the header, and using its values as keys for the rest of the lines
	static function parse($text)
	{
		$lines = explode(PHP_EOL, $text);
		$keys = str_getcsv($lines[0]);
		
		$out = array();
		foreach (array_slice($lines, 1) as $line)
		{
			$values = str_getcsv($line);
			if (count($keys) == count($values)) {
				$out[] = array_combine($keys, $values);
			}
		}
		
		return $out;
	}
}