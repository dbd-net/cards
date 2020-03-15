<?php declare(strict_types=1);

namespace Gamebetr\Cards\Tests;

use Gamebetr\Cards\Card;
use Gamebetr\Cards\CardInterface;
use NumberFormatter;
use OutOfBoundsException;
use PHPUnit\Framework\TestCase;

/**
 * Class CardTest
 *
 * @coversDefaultClass \Gamebetr\Cards\Card
 */
class CardTest extends TestCase
{
    /**
     * @covers ::rankName
     */
    public function testRankName()
    {
        for ($i = 2; $i <= 10; $i++) {
            $card = new Card($i, CardInterface::SUIT_SPADE);
            $this->assertEquals($card->name(), $card->rankName());
        }

        $card = new Card(CardInterface::FACE_JOKER, CardInterface::SUIT_SPADE);
        $this->assertEquals($card->name(), $card->rankName(), 'Joker');
        $card = new Card(CardInterface::FACE_JACK, CardInterface::SUIT_SPADE);
        $this->assertEquals($card->name(), $card->rankName(), 'Jack');
        $card = new Card(CardInterface::FACE_QUEEN, CardInterface::SUIT_SPADE);
        $this->assertEquals($card->name(), $card->rankName(), 'Queen');
        $card = new Card(CardInterface::FACE_KING, CardInterface::SUIT_SPADE);
        $this->assertEquals($card->name(), $card->rankName(), 'King');
        $card = new Card(CardInterface::FACE_ACE, CardInterface::SUIT_SPADE);
        $this->assertEquals($card->name(), $card->rankName(), 'Ace');
    }

    /**
     * @covers ::suitName
     * @covers ::getSuitNames
     */
    public function testSuitName()
    {
        $card = new Card(10, CardInterface::SUIT_DIAMOND);
        $this->assertEquals('diamonds', $card->suitName());

        $card = new Card(10, CardInterface::SUIT_HEART);
        $this->assertEquals('hearts', $card->suitName());

        $card = new Card(10, CardInterface::SUIT_CLUB);
        $this->assertEquals('clubs', $card->suitName());

        $card = new Card(10, CardInterface::SUIT_SPADE);
        $this->assertEquals('spades', $card->suitName());
    }

    /**
     * @covers ::suit
     */
    public function testSuit()
    {
        $card = new Card(10, CardInterface::SUIT_DIAMOND);
        $this->assertEquals(CardInterface::SUIT_DIAMOND, $card->suit());

        $card = new Card(10, CardInterface::SUIT_HEART);
        $this->assertEquals(CardInterface::SUIT_HEART, $card->suit());

        $card = new Card(10, CardInterface::SUIT_CLUB);
        $this->assertEquals(CardInterface::SUIT_CLUB, $card->suit());

        $card = new Card(10, CardInterface::SUIT_SPADE);
        $this->assertEquals(CardInterface::SUIT_SPADE, $card->suit());
    }

    /**
     * @covers ::fullName
     */
    public function testFullName()
    {
        $formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);
        for ($i = 2; $i <= 10; $i++) {
            $card = new Card($i, CardInterface::SUIT_SPADE);
            $this->assertEquals(
                sprintf('%s of spades', $formatter->format($i)),
                $card->fullName()
            );
        }

        $card = new Card(CardInterface::FACE_JOKER, CardInterface::SUIT_SPADE);
        $this->assertEquals('joker of spades', $card->fullName());
        $card = new Card(CardInterface::FACE_JACK, CardInterface::SUIT_SPADE);
        $this->assertEquals('jack of spades', $card->fullName());
        $card = new Card(CardInterface::FACE_QUEEN, CardInterface::SUIT_SPADE);
        $this->assertEquals('queen of spades', $card->fullName());
        $card = new Card(CardInterface::FACE_KING, CardInterface::SUIT_SPADE);
        $this->assertEquals('king of spades', $card->fullName());
        $card = new Card(CardInterface::FACE_ACE, CardInterface::SUIT_SPADE);
        $this->assertEquals('ace of spades', $card->fullName());
    }

    /**
     * @covers ::name
     * @covers ::getCardNames
     */
    public function testName()
    {
        $formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);
        for ($i = 2; $i <= 10; $i++) {
            $card = new Card($i, CardInterface::SUIT_SPADE);
            $this->assertEquals($formatter->format($i), $card->name());
        }

        $card = new Card(CardInterface::FACE_JOKER, CardInterface::SUIT_SPADE);
        $this->assertEquals('joker', $card->name());
        $card = new Card(CardInterface::FACE_JACK, CardInterface::SUIT_SPADE);
        $this->assertEquals('jack', $card->name());
        $card = new Card(CardInterface::FACE_QUEEN, CardInterface::SUIT_SPADE);
        $this->assertEquals('queen', $card->name());
        $card = new Card(CardInterface::FACE_KING, CardInterface::SUIT_SPADE);
        $this->assertEquals('king', $card->name());
        $card = new Card(CardInterface::FACE_ACE, CardInterface::SUIT_SPADE);
        $this->assertEquals('ace', $card->name());
    }

    /**
     * @covers ::init
     */
    public function testInit()
    {
        $card = Card::init(10, CardInterface::SUIT_DIAMOND);
        $this->assertInstanceOf(CardInterface::class, $card);
        $this->assertEquals('ten', $card->name());
        $this->assertEquals(CardInterface::SUIT_DIAMOND, $card->suit());
    }

    /**
     * @covers ::__construct
     * @covers ::isValidFace
     * @covers ::isValidSuit
     */
    public function test__construct()
    {
        $card = new Card(10, CardInterface::SUIT_DIAMOND);
        $this->assertEquals('ten', $card->name());
        $this->assertEquals(CardInterface::SUIT_DIAMOND, $card->suit());
    }

    /**
     * @covers ::__construct
     */
    public function test__constructSuitOOB()
    {
        $this->expectException(OutOfBoundsException::class);
        $card = new Card(10, 100);
    }


    /**
     * @covers ::__construct
     */
    public function test__constructFaceOOB()
    {
        $this->expectException(OutOfBoundsException::class);
        $card = new Card(100, CardInterface::SUIT_DIAMOND);
    }

    /**
     * @covers ::__construct
     * @covers ::faceFromProvable
     * @covers ::suitFromProvable
     */
    public function test__constructFromProvable()
    {
        $card = new Card(-4);
        $this->assertEquals(CardInterface::SUIT_CLUB, $card->suit());
        $this->assertEquals(-1, $card->rank());
        $card = new Card(-3);
        $this->assertEquals(CardInterface::SUIT_DIAMOND, $card->suit());
        $this->assertEquals(-1, $card->rank());
        $card = new Card(-2);
        $this->assertEquals(CardInterface::SUIT_HEART, $card->suit());
        $this->assertEquals(-1, $card->rank());
        $card = new Card(-1);
        $this->assertEquals(CardInterface::SUIT_SPADE, $card->suit());
        $this->assertEquals(-1, $card->rank());

        $card = new Card(0);
        $this->assertEquals(CardInterface::SUIT_CLUB, $card->suit());
        $this->assertEquals(0, $card->rank());

        $card = new Card(60);
        $this->assertEquals(CardInterface::SUIT_CLUB, $card->suit());
        $this->assertEquals(4, $card->value());

        $card = new Card(37);
        $this->assertEquals(CardInterface::SUIT_DIAMOND, $card->suit());
        $this->assertEquals(9, $card->rank());

        $card = new Card(-10);
        $this->assertEquals(CardInterface::SUIT_HEART, $card->suit());
        $this->assertEquals(-1, $card->rank());
    }

    /**
     * @covers ::rank
     */
    public function testRank()
    {
        for ($i = 2; $i <= 10; $i++) {
            $card = new Card($i, CardInterface::SUIT_SPADE);
            $this->assertEquals($i - 2, $card->rank());
        }

        $card = new Card(CardInterface::FACE_JOKER, CardInterface::SUIT_SPADE);
        $this->assertEquals(-1, $card->rank(), 'Joker');
        $card = new Card(CardInterface::FACE_JACK, CardInterface::SUIT_SPADE);
        $this->assertEquals(9, $card->rank(), 'Jack');
        $card = new Card(CardInterface::FACE_QUEEN, CardInterface::SUIT_SPADE);
        $this->assertEquals(10, $card->rank(), 'Queen');
        $card = new Card(CardInterface::FACE_KING, CardInterface::SUIT_SPADE);
        $this->assertEquals(11, $card->rank(), 'King');
        $card = new Card(CardInterface::FACE_ACE, CardInterface::SUIT_SPADE);
        $this->assertEquals(12, $card->rank(), 'Ace');
    }

    /**
     * @covers ::isJoker
     */
    public function testIsJoker()
    {
        for ($i = 2; $i <= 10; $i++) {
            $card = new Card($i, CardInterface::SUIT_HEART);
            $this->assertFalse($card->isJoker());
        }

        $card = new Card(CardInterface::FACE_JOKER, CardInterface::SUIT_HEART);
        $this->assertTrue($card->isJoker(), 'Joker');
        $card = new Card(CardInterface::FACE_JACK, CardInterface::SUIT_HEART);
        $this->assertFalse($card->isJoker(), 'Jack');
        $card = new Card(CardInterface::FACE_QUEEN, CardInterface::SUIT_HEART);
        $this->assertFalse($card->isJoker(), 'Queen');
        $card = new Card(CardInterface::FACE_KING, CardInterface::SUIT_HEART);
        $this->assertFalse($card->isJoker(), 'King');
        $card = new Card(CardInterface::FACE_ACE, CardInterface::SUIT_HEART);
        $this->assertFalse($card->isJoker(), 'Ace');
    }

    /**
     * @covers ::__toString
     */
    public function test__toString()
    {
        $card = new Card(10, CardInterface::SUIT_DIAMOND);
        $this->assertEquals('ten of diamonds', (string)$card);

        $card = new Card(3, CardInterface::SUIT_HEART);
        $this->assertEquals('three of hearts', (string)$card);
    }

    /**
     * @covers ::greaterThan
     * @covers ::compare
     */
    public function testGreaterThan()
    {
        $c1 = new Card(10, CardInterface::SUIT_SPADE);
        $c2 = new Card(10, CardInterface::SUIT_HEART);

        $c4 = new Card(CardInterface::FACE_JACK, CardInterface::SUIT_SPADE);
        $c6 = new Card(CardInterface::FACE_JACK, CardInterface::SUIT_HEART);

        $this->assertFalse($c1->greaterThan($c2), 'Face same (no suit).');
        $this->assertFalse($c1->greaterThan($c1, true), 'Face same (same suit).');
        $this->assertTrue($c1->greaterThan($c2, true), 'Face same (different suit, suit less).');
        $this->assertFalse($c2->greaterThan($c1, true), 'Face same (different suit, suit greater).');

        $this->assertFalse($c1->greaterThan($c4), 'Lower face (no suit).');
        $this->assertFalse($c1->greaterThan($c4, true), 'Lower face (same suit).');
        $this->assertFalse($c1->greaterThan($c6, true), 'Lower face (different suit).');

        $this->assertTrue($c4->greaterThan($c1), 'Higher face (no suit).');
        $this->assertTrue($c4->greaterThan($c1, true), 'Higher face (same suit).');
        $this->assertTrue($c4->greaterThan($c2, true), 'Higher face (different suit).');
    }

    /**
     * @covers ::lessThan
     * @covers ::compare
     */
    public function testLessThan()
    {
        $c1 = new Card(10, CardInterface::SUIT_SPADE);
        $c2 = new Card(10, CardInterface::SUIT_HEART);

        $c4 = new Card(CardInterface::FACE_JACK, CardInterface::SUIT_SPADE);
        $c6 = new Card(CardInterface::FACE_JACK, CardInterface::SUIT_HEART);

        $this->assertFalse($c1->lessThan($c2), 'Face same (no suit).');
        $this->assertFalse($c1->lessThan($c1, true), 'Face same (same suit).');
        $this->assertFalse($c1->lessThan($c2, true), 'Face same (different suit).');

        $this->assertTrue($c1->lessThan($c4), 'Lower face (no suit).');
        $this->assertTrue($c1->lessThan($c4, true), 'Lower face (same suit).');
        $this->assertTrue($c1->lessThan($c6, true), 'Lower face (different suit).');

        $this->assertFalse($c4->lessThan($c1), 'Higher face (no suit).');
        $this->assertFalse($c4->lessThan($c1, true), 'Higher face (same suit).');
        $this->assertFalse($c4->lessThan($c2, true), 'Higher face (different suit).');
    }

    /**
     * @covers ::equalTo
     * @covers ::compare
     */
    public function testEqualTo()
    {
        $c1 = new Card(10, CardInterface::SUIT_SPADE);
        $c2 = new Card(10, CardInterface::SUIT_HEART);
        $c3 = new Card(10, CardInterface::SUIT_HEART);

        $c4 = new Card(CardInterface::FACE_JACK, CardInterface::SUIT_SPADE);
        $c6 = new Card(CardInterface::FACE_JACK, CardInterface::SUIT_HEART);
        $c7 = new Card(CardInterface::FACE_JACK, CardInterface::SUIT_HEART);

        $this->assertFalse($c1->equalTo($c2, true), 'Same face, different suit.');
        $this->assertFalse($c4->equalTo($c6, true), 'Same face, different suit.');

        $this->assertFalse($c1->equalTo($c4, true), 'Different face, same suit.');
        $this->assertFalse($c2->equalTo($c6, true), 'Different face, same suit.');

        $this->assertFalse($c1->equalTo($c6, true), 'Different face, different suit.');

        $this->assertTrue($c2->equalTo($c3, true), 'Same face, same suit.');
        $this->assertTrue($c6->equalTo($c7, true), 'Same face, same suit.');

        $this->assertFalse($c1->equalTo($c4), 'Different face (no suit).');
        $this->assertTrue($c1->equalTo($c2), 'Same face (no suit)');
    }

    /**
     * @covers ::value
     */
    public function testValue()
    {
        for ($i = 2; $i <= 10; $i++) {
            $card = new Card($i, CardInterface::SUIT_HEART);
            $this->assertEquals($i, $card->value());
        }

        $card = new Card(CardInterface::FACE_JOKER, CardInterface::SUIT_HEART);
        $this->assertEquals(0, $card->value(), 'Joker');
        $card = new Card(CardInterface::FACE_JACK, CardInterface::SUIT_HEART);
        $this->assertEquals(10, $card->value(), 'Jack');
        $card = new Card(CardInterface::FACE_QUEEN, CardInterface::SUIT_HEART);
        $this->assertEquals(10, $card->value(), 'Queen');
        $card = new Card(CardInterface::FACE_KING, CardInterface::SUIT_HEART);
        $this->assertEquals(10, $card->value(), 'King');
        $card = new Card(CardInterface::FACE_ACE, CardInterface::SUIT_HEART);
        $this->assertEquals(11, $card->value(), 'Ace');
    }

    /**
     * @covers ::isAce
     */
    public function testIsAce()
    {
        for ($i = 2; $i <= 10; $i++) {
            $card = new Card($i, CardInterface::SUIT_HEART);
            $this->assertFalse($card->isAce());
        }

        $card = new Card(CardInterface::FACE_JOKER, CardInterface::SUIT_HEART);
        $this->assertFalse($card->isAce(), 'Joker');
        $card = new Card(CardInterface::FACE_JACK, CardInterface::SUIT_HEART);
        $this->assertFalse($card->isAce(), 'Jack');
        $card = new Card(CardInterface::FACE_QUEEN, CardInterface::SUIT_HEART);
        $this->assertFalse($card->isAce(), 'Queen');
        $card = new Card(CardInterface::FACE_KING, CardInterface::SUIT_HEART);
        $this->assertFalse($card->isAce(), 'King');
        $card = new Card(CardInterface::FACE_ACE, CardInterface::SUIT_HEART);
        $this->assertTrue($card->isAce(), 'Ace');
    }

    /**
     * @covers ::isRoyalty
     */
    public function testIsRoyalty()
    {
        for ($i = 2; $i <= 10; $i++) {
            $card = new Card($i, CardInterface::SUIT_HEART);
            $this->assertFalse($card->isRoyalty());
        }

        $card = new Card(CardInterface::FACE_JOKER, CardInterface::SUIT_HEART);
        $this->assertFalse($card->isRoyalty(), 'Joker');

        $card = new Card(CardInterface::FACE_JACK, CardInterface::SUIT_HEART);
        $this->assertTrue($card->isRoyalty(), 'Jack');
        $card = new Card(CardInterface::FACE_QUEEN, CardInterface::SUIT_HEART);
        $this->assertTrue($card->isRoyalty(), 'Queen');
        $card = new Card(CardInterface::FACE_KING, CardInterface::SUIT_HEART);
        $this->assertTrue($card->isRoyalty(), 'King');
        $card = new Card(CardInterface::FACE_ACE, CardInterface::SUIT_HEART);
        $this->assertFalse($card->isRoyalty(), 'Ace');
    }

    /**
     * @covers ::getOriginalFaceValue
     */
    public function testGetOriginalFaceValue() {
        $card = new Card(1000, Card::TYPE_PROVABLE);
        $this->assertEquals(1000, $card->getOriginalFaceValue());

        $card = new Card(10, CardInterface::SUIT_CLUB);
        $this->assertEquals(10, $card->getOriginalFaceValue());
    }

    /**
     * @covers ::getProvable
     */
    public function testGetProvable() {
        // A hardcoded list here so we're not duplicating the math we're trying to test.

        $card = new Card(CardInterface::FACE_JOKER, CardInterface::SUIT_CLUB);
        $this->assertEquals(-4, $card->getProvable());
        $card = new Card(CardInterface::FACE_JOKER, CardInterface::SUIT_DIAMOND);
        $this->assertEquals(-3, $card->getProvable());
        $card = new Card(CardInterface::FACE_JOKER, CardInterface::SUIT_HEART);
        $this->assertEquals(-2, $card->getProvable());
        $card = new Card(CardInterface::FACE_JOKER, CardInterface::SUIT_SPADE);
        $this->assertEquals(-1, $card->getProvable());

        $card = new Card(2, CardInterface::SUIT_CLUB);
        $this->assertEquals(0, $card->getProvable());
        $card = new Card(2, CardInterface::SUIT_DIAMOND);
        $this->assertEquals(1, $card->getProvable());
        $card = new Card(2, CardInterface::SUIT_HEART);
        $this->assertEquals(2, $card->getProvable());
        $card = new Card(2, CardInterface::SUIT_SPADE);
        $this->assertEquals(3, $card->getProvable());

        $card = new Card(3, CardInterface::SUIT_CLUB);
        $this->assertEquals(4, $card->getProvable());
        $card = new Card(3, CardInterface::SUIT_DIAMOND);
        $this->assertEquals(5, $card->getProvable());
        $card = new Card(3, CardInterface::SUIT_HEART);
        $this->assertEquals(6, $card->getProvable());
        $card = new Card(3, CardInterface::SUIT_SPADE);
        $this->assertEquals(7, $card->getProvable());

        $card = new Card(4, CardInterface::SUIT_CLUB);
        $this->assertEquals(8, $card->getProvable());
        $card = new Card(4, CardInterface::SUIT_DIAMOND);
        $this->assertEquals(9, $card->getProvable());
        $card = new Card(4, CardInterface::SUIT_HEART);
        $this->assertEquals(10, $card->getProvable());
        $card = new Card(4, CardInterface::SUIT_SPADE);
        $this->assertEquals(11, $card->getProvable());

        $card = new Card(5, CardInterface::SUIT_CLUB);
        $this->assertEquals(12, $card->getProvable());
        $card = new Card(5, CardInterface::SUIT_DIAMOND);
        $this->assertEquals(13, $card->getProvable());
        $card = new Card(5, CardInterface::SUIT_HEART);
        $this->assertEquals(14, $card->getProvable());
        $card = new Card(5, CardInterface::SUIT_SPADE);
        $this->assertEquals(15, $card->getProvable());

        $card = new Card(6, CardInterface::SUIT_CLUB);
        $this->assertEquals(16, $card->getProvable());
        $card = new Card(6, CardInterface::SUIT_DIAMOND);
        $this->assertEquals(17, $card->getProvable());
        $card = new Card(6, CardInterface::SUIT_HEART);
        $this->assertEquals(18, $card->getProvable());
        $card = new Card(6, CardInterface::SUIT_SPADE);
        $this->assertEquals(19, $card->getProvable());

        $card = new Card(7, CardInterface::SUIT_CLUB);
        $this->assertEquals(20, $card->getProvable());
        $card = new Card(7, CardInterface::SUIT_DIAMOND);
        $this->assertEquals(21, $card->getProvable());
        $card = new Card(7, CardInterface::SUIT_HEART);
        $this->assertEquals(22, $card->getProvable());
        $card = new Card(7, CardInterface::SUIT_SPADE);
        $this->assertEquals(23, $card->getProvable());

        $card = new Card(8, CardInterface::SUIT_CLUB);
        $this->assertEquals(24, $card->getProvable());
        $card = new Card(8, CardInterface::SUIT_DIAMOND);
        $this->assertEquals(25, $card->getProvable());
        $card = new Card(8, CardInterface::SUIT_HEART);
        $this->assertEquals(26, $card->getProvable());
        $card = new Card(8, CardInterface::SUIT_SPADE);
        $this->assertEquals(27, $card->getProvable());

        $card = new Card(9, CardInterface::SUIT_CLUB);
        $this->assertEquals(28, $card->getProvable());
        $card = new Card(9, CardInterface::SUIT_DIAMOND);
        $this->assertEquals(29, $card->getProvable());
        $card = new Card(9, CardInterface::SUIT_HEART);
        $this->assertEquals(30, $card->getProvable());
        $card = new Card(9, CardInterface::SUIT_SPADE);
        $this->assertEquals(31, $card->getProvable());

        $card = new Card(10, CardInterface::SUIT_CLUB);
        $this->assertEquals(32, $card->getProvable());
        $card = new Card(10, CardInterface::SUIT_DIAMOND);
        $this->assertEquals(33, $card->getProvable());
        $card = new Card(10, CardInterface::SUIT_HEART);
        $this->assertEquals(34, $card->getProvable());
        $card = new Card(10, CardInterface::SUIT_SPADE);
        $this->assertEquals(35, $card->getProvable());

        $card = new Card(CardInterface::FACE_JACK, CardInterface::SUIT_CLUB);
        $this->assertEquals(36, $card->getProvable());
        $card = new Card(CardInterface::FACE_JACK, CardInterface::SUIT_DIAMOND);
        $this->assertEquals(37, $card->getProvable());
        $card = new Card(CardInterface::FACE_JACK, CardInterface::SUIT_HEART);
        $this->assertEquals(38, $card->getProvable());
        $card = new Card(CardInterface::FACE_JACK, CardInterface::SUIT_SPADE);
        $this->assertEquals(39, $card->getProvable());

        $card = new Card(CardInterface::FACE_QUEEN, CardInterface::SUIT_CLUB);
        $this->assertEquals(40, $card->getProvable());
        $card = new Card(CardInterface::FACE_QUEEN, CardInterface::SUIT_DIAMOND);
        $this->assertEquals(41, $card->getProvable());
        $card = new Card(CardInterface::FACE_QUEEN, CardInterface::SUIT_HEART);
        $this->assertEquals(42, $card->getProvable());
        $card = new Card(CardInterface::FACE_QUEEN, CardInterface::SUIT_SPADE);
        $this->assertEquals(43, $card->getProvable());

        $card = new Card(CardInterface::FACE_KING, CardInterface::SUIT_CLUB);
        $this->assertEquals(44, $card->getProvable());
        $card = new Card(CardInterface::FACE_KING, CardInterface::SUIT_DIAMOND);
        $this->assertEquals(45, $card->getProvable());
        $card = new Card(CardInterface::FACE_KING, CardInterface::SUIT_HEART);
        $this->assertEquals(46, $card->getProvable());
        $card = new Card(CardInterface::FACE_KING, CardInterface::SUIT_SPADE);
        $this->assertEquals(47, $card->getProvable());

        $card = new Card(CardInterface::FACE_ACE, CardInterface::SUIT_CLUB);
        $this->assertEquals(48, $card->getProvable());
        $card = new Card(CardInterface::FACE_ACE, CardInterface::SUIT_DIAMOND);
        $this->assertEquals(49, $card->getProvable());
        $card = new Card(CardInterface::FACE_ACE, CardInterface::SUIT_HEART);
        $this->assertEquals(50, $card->getProvable());
        $card = new Card(CardInterface::FACE_ACE, CardInterface::SUIT_SPADE);
        $this->assertEquals(51, $card->getProvable());
    }

}
