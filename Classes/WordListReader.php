<?php
namespace OliverKlee\CodeKata;

/**
 * This class can read a list of words from disk.
 */
class WordListReader {
	/**
	 * @param string $fileName
	 *
	 * @return string[]
	 */
	public function read($fileName) {

		if (!file_exists($fileName)) {
			throw new \RuntimeException('File doesn\'t exists');
		}

		$content = file_get_contents($fileName);
		if ($content === '') {
			return array();
		}
		$rawWords = explode("\n", $content);

		$filteredWords = array_filter($rawWords, function($word) {
			return trim($word) !== '' && strpos($word, '\'') === FALSE;
		});

		return array_values($filteredWords);
	}
}