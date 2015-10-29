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

		return $currentNode;
	}
}