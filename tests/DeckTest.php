<?php declare(strict_types=1);

namespace Gamebetr\Cards\Tests;

use Gamebetr\Cards\Card;
use Gamebetr\Cards\Deck;
use Gamebetr\Provable\Provable;
use PHPUnit\Framework\TestCase;

/**
 * Class DeckTest
 *
 * @coversDefaultClass  \Gamebetr\Cards\Deck
 */
class DeckTest extends TestCase
{
    protected $clientSeed = '123';
    protected $serverSeed = '456';

    /**
     * @covers ::burn
     * @depends testGetRemainingCards
     */
    public function testBurn()
    {
        $deck = new Deck($this->clientSeed, $this->serverSeed);
        $card_count = count($deck->getCards());
        $this->assertEmpty($deck->getBurntCards());
        $this->assertInstanceOf(Card::class, $deck->burn());
        while ($deck->getRemainingCards()) {
            $deck->burn();
        }
        $this->assertCount($card_count, $deck->getBurntCards());
        $this->assertNull($deck->burn());
    }

    /**
     * @covers ::getRemainingCards
     */
    public function testGetRemainingCards()
    {
        $deck = new Deck($this->clientSeed, $this->serverSeed);
        $this->assertIsArray($deck->getRemainingCards());
        $this->assertCount(52, $deck->getRemainingCards());
        $this->assertInstanceOf(Card::class, $deck->getRemainingCards()[0]);
        $deck->deal();
        $this->assertCount(51, $deck->getRemainingCards());
    }

    /**
     * @covers ::getProvable
     */
    public function testGetProvable()
    {
        $deck = new Deck($this->clientSeed, $this->serverSeed);
        $this->assertInstanceOf(Provable::class, $deck->getProvable());
    }

    /**
     * @covers ::getDealtCards
     */
    public function testGetDealtCards()
    {
        $deck = new Deck($this->clientSeed, $this->serverSeed);
        $this->assertIsArray($deck->getDealtCards());
        $this->assertEmpty($deck->getDealtCards());
        $deck->deal();
        $this->assertNotEmpty($deck->getDealtCards());
        $this->assertInstanceOf(Card::class, $deck->getDealtCards()[0]);
    }

    /**
     * @covers ::__construct
     */
    public function test__construct()
    {
        $deck = new Deck($this->clientSeed, $this->serverSeed);
        $this->assertCount(52, $deck->getCards());

        $deck = new Deck($this->clientSeed, $this->serverSeed, 3);
        $this->assertCount(52 * 3, $deck->getCards());
    }

    /**
     * @covers ::init
     */
    public function testInit()
    {
        $deck = new Deck($this->clientSeed, $this->serverSeed);
        $this->assertInstanceOf(Deck::class, $deck);
        $this->assertCount(52, $deck->getCards());
    }

    /**
     * @depends testGetRemainingCards
     * @covers ::getBurntCards
     * @covers ::burn
     */
    public function testGetBurntCards()
    {
        $deck = new Deck($this->clientSeed, $this->serverSeed);
        $this->assertIsArray($deck->getBurntCards());
        $this->assertEmpty($deck->getBurntCards());
        $deck->burn();
        $this->assertNotEmpty($deck->getBurntCards());
        $this->assertInstanceOf(Card::class, $deck->getBurntCards()[0]);
    }

    /**
     * @depends testGetRemainingCards
     * @covers ::deal
     */
    public function testDeal()
    {
        $deck = new Deck($this->clientSeed, $this->serverSeed);
        $this->assertInstanceOf(Card::class, $deck->deal());

        while ($deck->getRemainingCards()) {
            $deck->deal();
        }

        $this->assertNull($deck->deal());
    }

    /**
     * @covers ::getCards
     */
    public function testGetCards()
    {
        $deck = new Deck($this->clientSeed, $this->serverSeed);
        $this->assertIsArray($deck->getCards());
        $this->assertEquals(8, $deck->getCards()[0]);
    }
}
