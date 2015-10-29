<?php
namespace OliverKlee\CodeKata\Tests\Functional;

use OliverKlee\CodeKata\WordListReader;

/**
 * Testcase.
 */
class WordListReaderTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @var WordListReader
	 */
	private $subject = NULL;

	protected function setUp() {
		$this->subject = new WordListReader();
	}

	/**
	 * @test
	 */
	public function readForEmptyFileReturnsEmptyArray() {
		self::assertSame(
			array(),
			$this->subject->read(__DIR__ . '/Fixtures/empty.txt')
		);
	}

	/**
	 * @test
	 * @expectedException \RuntimeException
	 */
	public function readForNonexistentFileThrowsException() {
		$this->subject->read(__DIR__ . '/Fixtures/nothing-here.txt');
	}

	/**
	 * @test
	 */
	public function readForOnlyOneWordInFileReturnsArraWithJustOneWord() {
		self::assertSame(
			array(
				'one'
			),
			$this->subject->read(__DIR__ . '/Fixtures/oneWord.txt')
		);
	}

	/**
	 * @test
	 */
	public function readForTwoWordsInFileReturnsTheTwoWords() {
		self::assertSame(
			array(
				'one',
				'two'
			),
			$this->subject->read(__DIR__ . '/Fixtures/twoWords.txt')
		);
	}

	/**
	 * @test
	 */
	public function readForEmptyLineAtTheEndIsRemoved() {
		self::assertSame(
			array(
				'one'
			),
			$this->subject->read(__DIR__ . '/Fixtures/oneWordWithEmptyLineAtTheEnd.txt')
		);
	}

	/**
	 * @test
	 */
	public function readForEmptyLineInsideIsRemoved() {
		self::assertSame(
			array(
				'one',
				'two',
			),
			$this->subject->read(__DIR__ . '/Fixtures/oneWordWithEmptyLineInside.txt')
		);
	}

	/**
	 * @test
	 */
	public function readIgnoresWordsWithApostrophe() {
		self::assertSame(
			array(
			),
			$this->subject->read(__DIR__ . '/Fixtures/oneWordWithApostrophe.txt')
		);
	}
}