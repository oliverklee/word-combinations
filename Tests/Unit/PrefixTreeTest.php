<?php
namespace OliverKlee\CodeKata\Tests\Unit;

use OliverKlee\CodeKata\LetterNode;
use OliverKlee\CodeKata\PrefixTree;

/**
 * Testcase.
 */
class PrefixTreeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PrefixTree
     */
    private $subject = null;

    protected function setUp()
    {
        $this->subject = new PrefixTree();
    }

    /**
     * @test
     */
    public function canBeInstantiated()
    {
        self::assertInstanceOf(PrefixTree::class, $this->subject);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function insertWithEmptyWordThrowsException()
    {
        $this->subject->insert('');
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function insertWithWhitespaceOnlyWordThrowsException()
    {
        $this->subject->insert('  ');
    }

    /**
     * @test
     */
    public function insertReturnsNodeWithNonEmptyParent()
    {
        $result = $this->subject->insert('Hello');

        self::assertInstanceOf(LetterNode::class, $result);
        self::assertNotNull($result->getParent());
    }

    /**
     * @test
     */
    public function insertReturnsNodeWithTrimmedWordAttached()
    {
        $trimmedWord = 'bonjour';
        $word = ' ' . $trimmedWord . ' ';
        $result = $this->subject->insert($word);

        self::assertInstanceOf(LetterNode::class, $result);
        self::assertSame($trimmedWord, $result->getWord());
    }

    /**
     * @test
     */
    public function insertTwoTimesWithSameWordReturnsSameNode()
    {
        $word = 'bonsoir';

        $result1 = $this->subject->insert($word);
        $result2 = $this->subject->insert($word);

        self::assertSame($result1, $result2);
    }

    /**
     * @test
     */
    public function insertTwoTimesWithSameWordWithDifferentSurroundingWhitespaceReturnsSameNode()
    {
        $word = 'bonsoir';

        $result1 = $this->subject->insert($word);
        $result2 = $this->subject->insert(' ' . $word . ' ');

        self::assertSame($result1, $result2);
    }

    /**
     * @test
     */
    public function findPrefixesWithoutWordsReturnsEmptyArray()
    {
        $result = $this->subject->findPrefixes();

        self::assertSame([], $result);
    }

    /**
     * @test
     */
    public function findPrefixesWithOneWordReturnsEmptyArray()
    {
        $this->subject->insert('bonjour');

        $result = $this->subject->findPrefixes();

        self::assertSame([], $result);
    }

    /**
     * @test
     */
    public function findPrefixesWithTwoUnrelatedWordsReturnsEmptyArray()
    {
        $this->subject->insert('bonjour');
        $this->subject->insert('hello');

        $result = $this->subject->findPrefixes();

        self::assertSame([], $result);
    }

    /**
     * @test
     */
    public function findPrefixesWithTheSameWordTwoTimesReturnsEmptyArray()
    {
        $this->subject->insert('bonjour');
        $this->subject->insert('bonjour');

        $result = $this->subject->findPrefixes();

        self::assertSame([], $result);
    }

    /**
     * @test
     */
    public function findPrefixesWithOnePrefixOfTheOtherWordsReturnsPrefix()
    {
        $this->subject->insert('bon');
        $this->subject->insert('bonjour');

        $result = $this->subject->findPrefixes();

        self::assertSame(['bonjour' => ['bon']], $result);
    }

    /**
     * @test
     */
    public function findPrefixesWithOnePrefixOfTheOtherWordsInsertedInReverseOrderReturnsPrefix()
    {
        $this->subject->insert('bonjour');
        $this->subject->insert('bon');

        $result = $this->subject->findPrefixes();

        self::assertSame(['bonjour' => ['bon']], $result);
    }

    /**
     * @test
     */
    public function findPrefixesWithOnePrefixOfTheOtherWordsTwoTimesReturnsPrefixOneTime()
    {
        $this->subject->insert('bon');
        $this->subject->insert('bon');
        $this->subject->insert('bonjour');

        $result = $this->subject->findPrefixes();

        self::assertSame(['bonjour' => ['bon']], $result);
    }

    /**
     * @test
     */
    public function findPrefixesCanFindTwoPrefixesOfTheSameWord()
    {
        $this->subject->insert('Ab');
        $this->subject->insert('Abgas');
        $this->subject->insert('Abgasreinigung');

        $result = $this->subject->findPrefixes();

        self::assertSame(
            [
                'Abgas' => ['Ab'],
                'Abgasreinigung' => ['Abgas', 'Ab'],
            ],
            $result
        );
    }

    /**
     * @test
     */
    public function findPrefixesCanFindOnePrefixOfTwoWords()
    {
        $this->subject->insert('Ab');
        $this->subject->insert('Abfall');
        $this->subject->insert('Abgas');

        $result = $this->subject->findPrefixes();

        self::assertSame(
            [
                'Abfall' => ['Ab'],
                'Abgas' => ['Ab'],
            ],
            $result
        );
    }
}
