<?php
namespace OliverKlee\CodeKata\Tests\Unit;

use OliverKlee\CodeKata\LetterNode;
use OliverKlee\CodeKata\PrefixTree;

/**
 * Testcase.
 */
class PrefixTreeTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @var PrefixTree
	 */
	private $subject = null;

	protected function setUp() {
		$this->subject = new PrefixTree();
	}

	/**
	 * @test
	 */
	public function canBeInstantiated() {
		self::assertInstanceOf(PrefixTree::class, $this->subject);
	}

	/**
	 * @test
	 * @expectedException \InvalidArgumentException
	 */
	public function insertWithEmptyWordThrowsException() {
		$this->subject->insert('');
	}

	/**
	 * @test
	 * @expectedException \InvalidArgumentException
	 */
	public function insertWithWhitespaceOnlyWordThrowsException() {
		$this->subject->insert('  ');
	}

	/**
	 * @test
	 */
	public function insertReturnsNodeWithNonEmptyParent() {
		$result = $this->subject->insert('Hello');

		self::assertInstanceOf(LetterNode::class, $result);
		self::assertNotNull($result->getParent());
	}

	/**
	 * @test
	 */
	public function insertReturnsNodeWithTrimmedWordAttached() {
		$trimmedWord = 'bonjour';
		$word = ' ' . $trimmedWord . ' ';
		$result = $this->subject->insert($word);

		self::assertInstanceOf(LetterNode::class, $result);
		self::assertSame($trimmedWord, $result->getWord());
	}

	/**
	 * @test
	 */
	public function insertTwoTimesWithSameWordReturnsSameNode() {
		$word = 'bonsoir';

		$result1 = $this->subject->insert($word);
		$result2 = $this->subject->insert($word);

		self::assertSame($result1, $result2);
	}

	/**
	 * @test
	 */
	public function insertTwoTimesWithSameWordWithDifferentSurroundingWhitespaceReturnsSameNode() {
		$word = 'bonsoir';

		$result1 = $this->subject->insert($word);
		$result2 = $this->subject->insert(' ' . $word . ' ');

		self::assertSame($result1, $result2);
	}
}