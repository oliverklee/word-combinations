<?php
namespace OliverKlee\CodeKata;

/**
 * This class represents a prefix tree, i.e., a tree that allows finding words that start with a certain substring,
 * or words that are the prefixes of others.
 */
class PrefixTree {
	/**
	 * @var LetterNode
	 */
	private $root = null;

	/**
	 * @var LetterNode[]
	 */
	private $wordNodes = [];

	/**
	 * The constructor.
	 */
	public function __construct() {
		$this->root = new LetterNode();
	}

	/**
	 * @param string $word
	 *
	 * @return LetterNode the node that has all letters of $words in its path that lead to it from the root node
	 *
	 * @throws \InvalidArgumentException
	 */
	public function insert($word) {
		$trimmedWord = trim($word);
		if ($trimmedWord === '') {
			throw new \InvalidArgumentException('$word must not be empty.', 1446122742);
		}

		$currentNode = $this->root;
		$letters = preg_split('/(?<!^)(?!$)/u', $trimmedWord);

		foreach ($letters as $letter) {
			if ($currentNode->hasChildWithIndex($letter)) {
				$currentNode = $currentNode->getChildByIndex($letter);
			} else {
				$newNode = new LetterNode();
				$currentNode->addChild($newNode, $letter);
				$currentNode = $newNode;
			}
		}

		$currentNode->setWord($trimmedWord);
		$this->wordNodes[] = $currentNode;

		return $currentNode;
	}

	/**
	 * Finds prefixes within the words added so far.
	 *
	 * This method must be called after all words are added.
	 *
	 * @return string[][] the prefixes in the form ['foobar' => ['foo, 'foob'], 'foob' => ['foo']]
	 */
	public function findPrefixes() {
		$prefixesForAllWords = [];

		foreach ($this->wordNodes as $wordNode) {
			$prefixesForWord = $this->findPrefixesForWordNode($wordNode);
			if ($prefixesForWord !== []) {
				$prefixesForAllWords[$wordNode->getWord()] = $prefixesForWord;
			}
		}

		return $prefixesForAllWords;
	}

	/**
	 * @param LetterNode $wordNode
	 *
	 * @return string[]
	 */
	private function findPrefixesForWordNode(LetterNode $wordNode) {
		$prefixes = [];
		$currentNode = $wordNode;

		do {
			if ($currentNode !== $wordNode && $currentNode->hasWord()) {
				$prefixes[] = $currentNode->getWord();
			}

			$currentNode = $currentNode->getParent();
		} while ($currentNode->getParent() !== null);

		return $prefixes;
	}
}