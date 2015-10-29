<?php
namespace OliverKlee\CodeKata;

/**
 * This class represents a node in a prefix tree or suffix tree.
 */
class LetterNode {
	/**
	 * @var LetterNode
	 */
	private $parent = null;

	/**
	 * @var LetterNode[]
	 */
	private $children = [];

	/**
	 * @var string
	 */
	private $word = '';

	/**
	 * @return LetterNode|null
	 */
	public function getParent() {
		return $this->parent;
	}

	/**
	 * @param LetterNode $parent
	 *
	 * @return void
	 */
	private function setParent(LetterNode $parent) {
		$this->parent = $parent;
	}

	/**
	 * @return LetterNode[] the children using the letters as keys
	 */
	public function getChildren() {
		return $this->children;
	}

	/**
	 * Adds a child using $index as an index.
	 *
	 * Only one node per letter may be added for each node.
	 *
	 * @param LetterNode $node
	 * @param string $index the letter, must be exactly one character
	 *
	 * @return void
	 *
	 * @throws \BadMethodCallException
	 * @throws \InvalidArgumentException
	 */
	public function addChild(LetterNode $node, $index) {
		$indexLength = mb_strlen($index, 'UTF-8');
		if ($indexLength !== 1) {
			throw new \InvalidArgumentException(
				'$indexLetter must exactly be one characters, but is ' . $indexLength . ' characters.',
				1446117800
			);
		}
		if (isset($this->children[$index])) {
			throw new \BadMethodCallException(
				'Each node may only get at most one child node per index. Current index letter: ' . $indexLength,
				1446117953
			);
		}
		if ($node->getParent() !== null) {
			throw new \BadMethodCallException(
				'$node already has a parent and must not be added to another node anymore.',
				1446118632
			);
		}

		$this->children[$index] = $node;
		$node->setParent($this);
	}

	/**
	 * @return bool
	 */
	public function isLeaf() {
		return count($this->children) === 0;
	}

	/**
	 * @return string
	 */
	public function getWord() {
		return $this->word;
	}

	/**
	 * Sets the (complete) word associated with this node.
	 *
	 * @param string $word
	 *
	 * @return void
	 *
	 * @throws \InvalidArgumentException
	 */
	public function setWord($word) {
		if ($word === '') {
			throw new \InvalidArgumentException('$word must not be empty.', 1446121292);
		}

		$this->word = $word;
	}

	/**
	 * @return bool
	 */
	public function hasWord() {
		return $this->getWord() !== '';
	}
}