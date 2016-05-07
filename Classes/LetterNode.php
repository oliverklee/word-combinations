<?php
namespace OliverKlee\CodeKata;

/**
 * This class represents a node in a prefix tree or suffix tree.
 *
 * Child nodes are uniquely indexed by one-character letters. Nodes can also be associated with words.
 */
class LetterNode
{
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
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param LetterNode $parent
     *
     * @return void
     */
    private function setParent(LetterNode $parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return LetterNode[] the children using the letters as keys
     */
    public function getChildren()
    {
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
    public function addChild(LetterNode $node, $index)
    {
        $this->validateIndex($index);
        if ($this->hasChildWithIndex($index)) {
            throw new \BadMethodCallException(
                'Each node may only get at most one child node per index. Current index letter: ' . $index,
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
     * @param string $index the letter, must be exactly one character
     *
     * @return bool
     *
     * @throws \InvalidArgumentException
     */
    public function hasChildWithIndex($index)
    {
        $this->validateIndex($index);

        return array_key_exists($index, $this->children);
    }

    /**
     * Returns the child for the index $index or null if there is one.
     *
     * @param string $index the letter, must be exactly one character
     *
     * @return LetterNode|null
     *
     * @throws \InvalidArgumentException
     */
    public function getChildByIndex($index)
    {
        $this->validateIndex($index);
        if (!$this->hasChildWithIndex($index)) {
            return null;
        }

        return $this->children[$index];
    }

    /**
     * Checks that $index is exactly one (UTF-8) letter long and throws an exception otherwise.
     *
     * @param string $index the index to validate
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    private function validateIndex($index)
    {
        $indexLength = mb_strlen($index, 'UTF-8');
        if ($indexLength !== 1) {
            throw new \InvalidArgumentException(
                '$indexLetter must exactly be one characters, but is ' . $indexLength . ' characters.',
                1446117800
            );
        }
    }

    /**
     * @return bool
     */
    public function isLeaf()
    {
        return count($this->children) === 0;
    }

    /**
     * @return string
     */
    public function getWord()
    {
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
    public function setWord($word)
    {
        if ($word === '') {
            throw new \InvalidArgumentException('$word must not be empty.', 1446121292);
        }

        $this->word = $word;
    }

    /**
     * @return bool
     */
    public function hasWord()
    {
        return $this->getWord() !== '';
    }
}
