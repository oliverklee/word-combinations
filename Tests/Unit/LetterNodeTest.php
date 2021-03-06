<?php
declare(strict_types=1);

namespace OliverKlee\CodeKata\Tests\Unit;

use OliverKlee\CodeKata\LetterNode;

/**
 * Testcase.
 */
class LetterNodeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var LetterNode
     */
    private $subject = null;

    protected function setUp()
    {
        $this->subject = new LetterNode();
    }

    /**
     * @test
     */
    public function getParentInitiallyReturnsNull()
    {
        self::assertNull($this->subject->getParent());
    }

    /**
     * @test
     */
    public function getChildrenInitiallyReturnsEmptyArray()
    {
        self::assertSame([], $this->subject->getChildren());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function addChildForEmptyLetterThrowsException()
    {
        $this->subject->addChild(new LetterNode(), '');
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function addChildForTwoCharacterLetterThrowsException()
    {
        $this->subject->addChild(new LetterNode(), 'ab');
    }

    /**
     * @test
     */
    public function addChildForOneCharacterUmlautLetterNotThrowsException()
    {
        $this->subject->addChild(new LetterNode(), 'ä');
    }

    /**
     * @test
     * @expectedException \BadMethodCallException
     */
    public function addChildForNodeThatAlreadyHasParentThrowsException()
    {
        $child = new LetterNode();
        $otherParent = new LetterNode();
        $otherParent->addChild($child, 'a');

        $this->subject->addChild($child, 'b');
    }

    /**
     * @test
     */
    public function addChilAddsChildForThatLetter()
    {
        $child = new LetterNode();
        $letter = 'x';

        $this->subject->addChild($child, $letter);

        self::assertSame(
            [$letter => $child],
            $this->subject->getChildren()
        );
    }

    /**
     * @test
     */
    public function addChildWithDifferentLetterAddsSecondChild()
    {
        $child1 = new LetterNode();
        $letter1 = 'x';
        $child2 = new LetterNode();
        $letter2 = 'y';

        $this->subject->addChild($child1, $letter1);
        $this->subject->addChild($child2, $letter2);

        self::assertSame(
            [
                $letter1 => $child1,
                $letter2 => $child2,
            ],
            $this->subject->getChildren()
        );
    }

    /**
     * @test
     * @expectedException \BadMethodCallException
     */
    public function addChildTwoTimeWithSameLetterThrowsException()
    {
        $this->subject->addChild(new LetterNode(), 'a');
        $this->subject->addChild(new LetterNode(), 'a');
    }

    /**
     * @test
     */
    public function addChildSetsNodeAsParentOfChild()
    {
        $child = new LetterNode();

        $this->subject->addChild($child, 'a');

        self::assertSame($this->subject, $child->getParent());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function hasChildWithIndexForEmptyIndexThrowsException()
    {
        $this->subject->hasChildWithIndex('');
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function hasChildWithIndexForTwoLetterIndexThrowsException()
    {
        $this->subject->hasChildWithIndex('ig');
    }

    /**
     * @test
     */
    public function hasChildWithIndexForNoChildrenReturnsFalse()
    {
        $result = $this->subject->hasChildWithIndex('a');

        self::assertFalse($result);
    }

    /**
     * @test
     */
    public function hasChildWithIndexForOnlyChildrenWithDifferentIndexReturnsFalse()
    {
        $this->subject->addChild(new LetterNode(), 'n');

        $result = $this->subject->hasChildWithIndex('a');

        self::assertFalse($result);
    }

    /**
     * @test
     */
    public function hasChildWithIndexForChildWithGivenIndexReturnsTrue()
    {
        $index = 'h';
        $this->subject->addChild(new LetterNode(), $index);

        $result = $this->subject->hasChildWithIndex($index);

        self::assertTrue($result);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function getChildByIndexForEmptyIndexThrowsException()
    {
        $this->subject->getChildByIndex('');
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function getChildByIndexForTwoLetterIndexThrowsException()
    {
        $this->subject->getChildByIndex('as');
    }

    /**
     * @test
     */
    public function getChildByIndexForNoMatchingChildReturnsNull()
    {
        $node = new LetterNode();
        $this->subject->addChild($node, 'x');

        $result = $this->subject->getChildByIndex('y');

        self::assertNull($result);
    }

    /**
     * @test
     */
    public function getChildByIndexForMatchingChildReturnsMatchingChild()
    {
        $index = 'x';
        $node = new LetterNode();
        $this->subject->addChild($node, $index);

        $result = $this->subject->getChildByIndex($index);

        self::assertSame($node, $result);
    }

    /**
     * @test
     */
    public function isLeafForNoChildrenReturnsTrue()
    {
        self::assertTrue(
            $this->subject->isLeaf()
        );
    }

    /**
     * @test
     */
    public function isLeafForOneChildReturnsFalse()
    {
        $this->subject->addChild(new LetterNode(), 'a');

        self::assertFalse(
            $this->subject->isLeaf()
        );
    }

    /**
     * @test
     */
    public function isLeafForTwoChildrenReturnsFalse()
    {
        $this->subject->addChild(new LetterNode(), 'a');
        $this->subject->addChild(new LetterNode(), 'b');

        self::assertFalse(
            $this->subject->isLeaf()
        );
    }

    /**
     * @test
     */
    public function getWordInitiallyReturnsEmptyString()
    {
        self::assertSame('', $this->subject->getWord());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function setWordWithEmptyWordThrowsException()
    {
        $this->subject->setWord('');
    }

    /**
     * @test
     */
    public function setWordSetsWord()
    {
        $word = 'frubble';

        $this->subject->setWord($word);

        self::assertSame($word, $this->subject->getWord());
    }

    /**
     * @test
     */
    public function hasWordWithoutWordReturnsFalse()
    {
        self::assertFalse($this->subject->hasWord());
    }

    /**
     * @test
     */
    public function hasWordWithWordReturnsTrue()
    {
        $this->subject->setWord('Genève');

        self::assertTrue($this->subject->hasWord());
    }
}
