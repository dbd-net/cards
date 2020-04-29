<?php declare(strict_types=1);

namespace Gamebetr\Cards;

use Gamebetr\Provable\Provable;

class Deck
{
    /**
     * Provable
     *
     * @var Provable
     */
    protected $provable;

    /**
     * Deck cards
     *
     * @var int[]
     */
    protected $cards = [];

    /**
     * Remaining deck cards
     *
     * @var \Gamebetr\Cards\CardInterface[]
     */
    protected $remainingCards = [];

    /**
     * Dealt deck cards
     *
     * @var \Gamebetr\Cards\CardInterface[]
     */
    protected $dealtCards = [];

    /**
     * Burnt deck cards
     *
     * @var \Gamebetr\Cards\CardInterface[]
     */
    protected $burntCards = [];

    /**
     * Class constructor
     * @param string $clientSeed - client seed for shuffle
     * @param string $serverSeed - server seed for shuffle
     * @param int $deckCount - amount of card decks
     * @param bool $jokers - include jokers?
     */
    public function __construct(string $clientSeed = null, string $serverSeed = null, int $deckCount = 1, bool $jokers = false) {
        $start = $jokers ? $deckCount * -2 : 0;
        $range = range($start, ($deckCount * 52) - 1);
        $this->provable = $this->createProvable($clientSeed, $serverSeed, min($range), max($range), 'shuffle');
        $this->cards = $this->provable->results();
        foreach ($this->cards as $card) {
            $this->remainingCards[] = $this->getCardFromProvable($card);
        }
    }

    /**
   * Get a Provable instance.
   *
   * @param string|null $clientSeed
   *   The client seed.
   * @param string|null $serverSeed
   *   The server seed.
   * @param int $min
   *   The minimum value.
   * @param int $max
   *   The maximum value.
   * @param string $type
   *   The type of Provable.
   *
   * @return \Gamebetr\Provable\Provable
   *   A Provable instance.
   */
    protected function createProvable(string $clientSeed = null, string $serverSeed = null, int $min = 0, int $max = 0, string $type = 'number') : Provable {
        return Provable::init($clientSeed, $serverSeed, $min, $max, $type);
    }

    /**
     * Get a Card from a provable number.
     *
     * @param int $provable
     *   The provable number.
     *
     * @return \Gamebetr\Cards\CardInterface
     *   A Card.
     */
    protected function getCardFromProvable(int $provable) : CardInterface {
        return Card::init($provable);
    }

    /**
     * static constructor
     * @param string $clientSeed - client seed for shuffle
     * @param string $serverSeed - server seed for shuffle
     * @param int $deckCount - amount of card decks
     * @param bool $jokers - include jokers?
     */
    public static function init(string $clientSeed = null, string $serverSeed = null, int $deckCount = 1, bool $jokers = false) : Deck {
        return new static($clientSeed, $serverSeed, $deckCount, $jokers);
    }

    /**
     * Deal a card
     * @return CardInterface|null
     */
    public function deal() : ?CardInterface
    {
        if ($card = array_shift($this->remainingCards)) {
            $this->dealtCards[] = $card;
        }
        return $card ?? null;
    }

    /**
     * Burn a card
     *
     * @return CardInterface|null
     *   The burned card (if any).
     */
    public function burn(): ?CardInterface
    {
        if ($card = array_shift($this->remainingCards)) {
            $this->burntCards[] = $card;
        }
        return $card ?? null;
    }

    /**
     * Get original cards
     *
     * @return int[]
     */
    public function getCards() : array
    {
        return $this->cards;
    }

    /**
     * Get remaining cards
     *
     * @return \Gamebetr\Cards\CardInterface[]
     */
    public function getRemainingCards() : array
    {
        return $this->remainingCards;
    }

    /**
     * Get dealt cards
     *
     * @return \Gamebetr\Cards\CardInterface[]
     */
    public function getDealtCards() : array
    {
        return $this->dealtCards;
    }

    /**
     * Get burnt cards
     *
     * @return \Gamebetr\Cards\CardInterface[]
     */
    public function getBurntCards() : array
    {
        return $this->burntCards;
    }

    /**
     * Get provable
     *
     * @return Provable
     */
    public function getProvable() : Provable
    {
       return $this->provable;
    }
}
