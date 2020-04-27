<?php declare(strict_types=1);

namespace Gamebetr\Cards;

use Gamebetr\Provable\Provable;

class Deck
{
    /**
     * Provable
     * @var Provable $provable
     */
    protected $provable;

    /**
     * Deck cards
     * @var array $cards
     */
    protected $cards = [];

    /**
     * Remaining deck cards
     * @var array $remainingCards
     */
    protected $remainingCards = [];

    /**
     * Dealt deck cards
     * @var array $dealtCards
     */
    protected $dealtCards = [];

    /**
     * Burnt deck cards
     * @var array $burntCards
     */
    protected $burntCards = [];

    /**
     * Class constructor
     * @param string $clientSeed - client seed for shuffle
     * @param string $serverSeed - server seed for shuffle
     * @param int $deckCount - amount of card decks
     * @param bool $jokers - include jokers?
     */
    public function __construct(
        string $clientSeed = null,
        string $serverSeed = null,
        int $deckCount = 1,
        bool $jokers = false
    ) {
        $start = $jokers ? $deckCount * -2 : 0;
        $range = range($start, ($deckCount * 52) - 1);
        $this->provable = Provable::init($clientSeed, $serverSeed, min($range), max($range), 'shuffle');
        $this->cards = $this->provable->results();
        foreach ($this->cards as $card) {
            $this->remainingCards[] = Card::init($card);
        }
    }

    /**
     * static constructor
     * @param string $clientSeed - client seed for shuffle
     * @param string $serverSeed - server seed for shuffle
     * @param int $deckCount - amount of card decks
     * @param bool $jokers - include jokers?
     */
    public static function init(
        string $clientSeed = null,
        string $serverSeed = null,
        int $deckCount = 1,
        bool $jokers = false
    ) : Deck {
        return new static($clientSeed, $serverSeed, $deckCount, $jokers);
    }

    /**
     * Get provable
     * @return Provable
     */
    public function getProvable() : Provable
    {
        return $this->provable;
    }

    /**
     * Deal a card
     * @return Card|null
     */
    public function deal() : ?Card
    {
        if ($card = array_shift($this->remainingCards)) {
            $this->dealtCards[] = $card;
            return $card;
        }
        return null;
    }

    /**
     * Burn a card
     *
     * @return Card|null
     *   The burned card (if any).
     */
    public function burn(): ?Card
    {
        if ($card = array_shift($this->remainingCards)) {
            $this->burntCards[] = $card;
            return $card;
        }
        return null;
    }

    /**
     * Get original cards
     * @return array
     */
    public function getCards() : array
    {
        return $this->cards;
    }

    /**
     * Get remaining cards
     * @return array
     */
    public function getRemainingCards() : array
    {
        return $this->remainingCards;
    }

    /**
     * Get dealt cards
     * @return array
     */
    public function getDealtCards() : array
    {
        return $this->dealtCards;
    }

    /**
     * Get burnt cards
     * @return array
     */
    public function getBurntCards() : array
    {
        return $this->burntCards;
    }
}
