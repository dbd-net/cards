<?php

declare(strict_types=1);

namespace Gamebetr\Cards\Tests;

use Gamebetr\Cards\AbstractHand;
use Gamebetr\Cards\Card;
use Gamebetr\Cards\CardInterface;
use PHPUnit\Framework\TestCase;


/**
 * Class AbstractHandTest
 *
 * @coversDefaultClass \Gamebetr\Cards\AbstractHand
 */
class AbstractHandTest extends TestCase
{

    public function dataProviderSum(): array
    {
        return [
            [[2, 3, 4], 9],
            [[10, CardInterface::FACE_ACE], 21],
            [[10, CardInterface::FACE_JACK], 20],
            [[10, CardInterface::FACE_QUEEN], 20],
            [[10, CardInterface::FACE_KING], 20],
        ];
    }

    /**
     * @covers ::addCard
     */
    public function testAddCard()
    {
        $hand = $this->getMockForAbstractClass(AbstractHand::class);
        $hand->addCard(new Card(2));
        $hand->addCard(new Card(3));

        $this->assertCount(2, $hand->getCards());
    }

    /**
     * @covers ::getCard
     *
     * @depends testAddCard
     */
    public function testGetCard()
    {
        $hand = $this->getMockForAbstractClass(AbstractHand::class);
        $hand->addCard(new Card(2));
        $hand->addCard(new Card(3));
        $hand->addCard(new Card(4));

        $this->assertEquals(3, $hand->getCard(1)->getProvable());
        $this->assertNull($hand->getCard(-1));
    }

    /**
     * @covers ::getCards
     *
     * @depends testAddCard
     */
    public function testGetCards()
    {
        $hand = $this->getMockForAbstractClass(AbstractHand::class);
        $hand->addCard(new Card(2));
        $hand->addCard(new Card(3));

        $this->assertCount(2, $hand->getCards());
    }

    /**
     * @covers ::isLocked
     */
    public function testIsLocked()
    {
        $hand = $this->getMockForAbstractClass(AbstractHand::class);
        $this->assertFalse($hand->isLocked());
        $hand->lock();
        $this->assertTrue($hand->isLocked());
    }

    /**
     * @covers ::lock
     */
    public function testLock()
    {
        $hand = $this->getMockForAbstractClass(AbstractHand::class);
        $this->assertEquals(1, $hand->addCard(new Card(10)));
        $hand->lock();
        $this->assertEquals(1, $hand->addCard(new Card(10)));
    }

    /**
     * @covers ::unlock
     *
     * @depends testLock
     */
    public function testUnlock() {
        $hand = $this->getMockForAbstractClass(AbstractHand::class);
        $hand->lock();
        $this->assertTrue($hand->isLocked());
        $hand->unlock();
        $this->assertFalse($hand->isLocked());
    }

    /**
     * @covers ::removeCard
     *
     * @depends testAddCard
     * @depends testGetCards
     */
    public function testRemoveCard()
    {
        $hand = $this->getMockForAbstractClass(AbstractHand::class);
        $hand->addCard(new Card(2));
        $hand->addCard(new Card(3));

        $this->assertCount(2, $hand->getCards());

        /** @var \Gamebetr\Cards\Card $card */
        $card = $hand->removeCard(1);

        $this->assertCount(1, $hand->getCards());
        $this->assertEquals(3, $card->getProvable());

        $this->assertFalse($hand->removeCard(-1));
    }

    /**
     * @covers ::reset
     *
     * @depends testAddCard
     * @depends testGetCards
     */
    public function testReset()
    {
        $count = 5;
        $hand = $this->getMockForAbstractClass(AbstractHand::class);
        for ($i = 0; $i < $count; $i++) {
            $hand->addCard(new Card($i));
        }

        $this->assertCount($count, $hand->getCards());
        $this->assertEquals($count, $hand->reset());
        $this->assertEmpty($hand->getCards());
    }

    /**
     * @param array $cardFaces
     *   The faces to sum together.
     * @param int $expected
     *   The expected result.
     *
     * @covers ::sum
     *
     * @depends      testAddCard
     *
     * @dataProvider dataProviderSum
     */
    public function testSum(array $cardFaces, int $expected)
    {
        $hand = $this->getMockForAbstractClass(AbstractHand::class);
        foreach ($cardFaces as $card_face) {
            $hand->addCard(new Card($card_face, CardInterface::SUIT_SPADE));
        }
        $this->assertEquals($expected, $hand->sum());
    }

}
